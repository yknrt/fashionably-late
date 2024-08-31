<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Normalizer;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->only(['first_name', 'last_name', 'gender', 'email', 'tel-area-code', 'tel-local-prefix', 'tel-local-suffix', 'address', 'building', 'category_id', 'detail']);
        $categories = Category::all();
        return view('confirm', compact('contact', 'categories'));
    }

    public function store(Request $request)
    {
        if($request->input('back') == 'back'){
            return redirect('/')->withInput();
        }
        $tell = $request['tel-area-code'].$request['tel-local-prefix'].$request['tel-local-suffix'];
        $contact = $request->only(['category_id', 'first_name', 'last_name', 'gender', 'email', 'address', 'building', 'detail']);
        $contact['tell'] = $tell;
        Contact::create($contact);
        return view('thanks');
    }

    public function admin()
    {
        $contacts = Contact::with('category')->get();
        // $request->session()->put('key', $contacts);//flash
        $contacts = Contact::Paginate(7);
        $categories = Category::all();
        return view('admin', compact('contacts', 'categories'));
    }

    public function search(Request $request)
    {
        $contacts = Contact::with('category')->KeywordSearch($request->keyword)->GenderSearch($request->gender)->CategorySearch($request->category_id)->DateSearch($request->date)->get();
        $request->session()->put('key', $contacts);
        $contacts = Contact::with('category')->KeywordSearch($request->keyword)->GenderSearch($request->gender)->CategorySearch($request->category_id)->DateSearch($request->date)->Paginate(7);
        $categories = Category::all();
        return view('admin', compact('contacts', 'categories'));
    }

    public function destroy(Request $request)
    {
        $contact = Contact::find($request->id);
        $contact->delete();
        return redirect('/admin');
    }

    public function downloadCsv()
    {
        $contacts = session()->get('key');
        $csvHeader = ['id', 'first_name', 'last_name', 'gender', 'email', 'address', 'building', 'detail', 'category_id', 'created_at', 'updated_at'];
        $csvData = $contacts->toArray();
        $temps = [];
        array_push($temps, $csvHeader);
        foreach ($contacts as $contact) {
            $temp = [];
            foreach ($csvHeader as $key) {
                array_push($temp, $contact->$key);
            }
            array_push($temps, $temp);
        }

        $stream = fopen('php://temp', 'r+b');
        fwrite($stream, pack('C*', 0xEF, 0xBB, 0xBF));
        if ($stream) {
            // カラムの書き込み
            // mb_convert_variables('SJIS-win', 'UTF-8', $csvHeader);
            // fputcsv($stream, $csvHeader);
            // データの書き込み
            foreach ($temps as $temp) {
                // mb_convert_variables('SJIS-win', 'UTF-8', $temp);
                fputcsv($stream, $temp);
            }
        }

        rewind($stream);
        $csv = str_replace(PHP_EOL, "\r\n", stream_get_contents($stream));
        $csv = mb_convert_encoding($csv, 'sjis-win', 'UTF-8');
        // ファイルを閉じる
        fclose($stream);

        // HTTPヘッダ
        $headers = array(                     //ヘッダー情報を指定する
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=test.csv'
        );

        return \Response::make($csv, 200, $headers);
    }
}

