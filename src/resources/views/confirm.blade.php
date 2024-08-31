@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<div class="confirm__content">
    <div class="confirm__heading">
        <p>Confirm</p>
    </div>
    <!-- <form class="form"> -->
    <form class="form" action="/admin" method="post">
        @csrf
        <div class="confirm-table">
            <table class="confirm-table__inner">
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お名前</th>
                    <td class="confirm-table__name">
                        <input type="text" name="last_name" value="{{ $contact['last_name'] }}" readonly />
                        <span> </span>
                        <input type="text" name="first_name" value="{{ $contact['first_name'] }}" readonly />
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">性別</th>
                    <td class="confirm-table__text">
                        <input type="hidden" name="gender" value="{{ $contact['gender'] }}" readonly />
                        @if ($contact['gender'] === '1')
                            男性
                        @elseif ($contact['gender'] === '2')
                            女性
                        @elseif ($contact['gender'] === '3')
                            その他
                        @endif
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">メールアドレス</th>
                    <td class="confirm-table__text">
                        <input type="email" name="email" value="{{ $contact['email'] }}" readonly />
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">電話番号</th>
                    <td class="confirm-table__tel">
                        <input type="tel" name="tel-area-code" value="{{ $contact['tel-area-code'] }}" readonly />
                        <input type="tel" name="tel-local-prefix" value="{{ $contact['tel-local-prefix'] }}" readonly />
                        <input type="tel" name="tel-local-suffix" value="{{ $contact['tel-local-suffix'] }}" readonly />
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">住所</th>
                    <td class="confirm-table__text">
                        <input type="text" name="address" value="{{ $contact['address'] }}" readonly />
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">建物名</th>
                    <td class="confirm-table__text">
                        <input type="text" name="building" value="{{ $contact['building'] }}" readonly />
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合わせの種類</th>
                    <td class="confirm-table__text">
                        <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}" readonly />
                        @foreach ($categories as $category)
                            @if ($category['id'] == $contact['category_id'])
                                {{ $category['content'] }}
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合わせ</th>
                    <td class="confirm-table__text">
                        <input type="text" name="detail" value="{{ $contact['detail'] }}" readonly />
                        <!-- <textarea name="detail" readonly>{{ $contact['detail'] }}</textarea> -->
                    </td>
                </tr>
            </table>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">送信</button>
            <button type="submit" name="back" value="back">修正</button>
        </div>
    </form>
</div>
@endsection