<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;

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
        $contacts = Contact::Paginate(7);
        $categories = Category::all();
        return view('admin', compact('contacts', 'categories'));
    }

    public function search(Request $request)
    {
        $contacts = Contact::with('category')->KeywordSearch($request->keyword)->GenderSearch($request->gender)->CategorySearch($request->category_id)->DateSearch($request->date)->Paginate(7);
        $categories = Category::all();
        return view('admin', compact('contacts', 'categories'));
    }

}

