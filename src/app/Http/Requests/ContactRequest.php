<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'tel-area-code' => ['required', 'numeric', 'digits_between:1,5'],
            'tel-local-prefix' => ['required', 'numeric', 'digits_between:1,5'],
            'tel-local-suffix' => ['required', 'numeric', 'digits_between:1,5'],
            'address' => ['required', 'string', 'max:255'],
            'category_id' => ['required'],
            'detail' => ['required', 'string', 'max:120']
        ];
    }

    public function messages()
    {
        return [
            'last_name.required' => '姓を入力してください',
            'first_name.required' => '名を入力してください',
            'gender.required' => '性別を選択してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'address.required' => '住所を入力してください',
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'detail.required' => 'お問い合わせを入力してください',
            'detail.max' => 'お問い合わせは120文字以内で入力してください',
            'tel-area-code.required' => '電話番号を入力してください',
            'tel-local-prefix.required' => '電話番号を入力してください',
            'tel-local-suffix.required' => '電話番号を入力してください',
            'tel-area-code.digits_between' => '電話番号は5桁までの数字で入力してください',
            'tel-local-prefix.digits_between' => '電話番号は5桁までの数字で入力してください',
            'tel-local-suffix.digits_between' => '電話番号は5桁までの数字で入力してください',
        ];
    }
}

