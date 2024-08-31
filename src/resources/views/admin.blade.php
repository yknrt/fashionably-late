@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
@endsection


@section('header')
<nav>
    <ul class="header-nav">
        <li class="header-nav__item">
            <form  action="/logout" method="post">
                @csrf
                <button class="header-nav__button">logout</button>
                <!-- <button class="header-nav__button" href="/login">logout</button> -->
            </form>
        </li>
    </ul>
</nav>
@endsection

@section('content')
<div class="admin__content">
    <div class="admin-form__heading">
        <p>Admin</p>
    </div>
    <form class="search-form" action="/admin/search" method="get">
        @csrf
        <div class="search-form__text">
            <input type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ old('keyword') }}" />
        </div>
        <div class="search-form__select">
            <select name="gender">
                <option value="">性別</option>
                <option value=1>男性</option>
                <option value=2>女性</option>
                <option value=3>その他</option>
            </select>
        </div>
        <div class="search-form__select">
            <select name="category_id">
                <option value="">選択してください</option>
                @foreach ($categories as $category)
                    <option value="{{ $category['id'] }}">{{ $category['content'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="search-form__date">
            <input type="date" name="date" />
        </div>
        <div class="search-form__button--search">
            <button class="form__button--search-submit" type="submit">検索</button>
        </div>
        <div class="search-form__button--reset">
            <button class="form__button--reset-submit" type="submit">リセット</button>
        </div>
    </form>
    <div class="form__page">
        <div class="form__page--export">
            <button class="form__page--export-submit" type="submit">エクスポート</button>
        </div>
        <div class="form__page--change">{{ $contacts->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}</div>
    </div>
    <div class="admin-table">
        <table class="admin-table__inner">
            <tr class="admin-table__row">
                <th class="admin-table__header">お名前</th>
                <th class="admin-table__header">性別</th>
                <th class="admin-table__header">メールアドレス</th>
                <th class="admin-table__header">お問い合わせの種類</th>
                <th></th>
            </tr>
            @foreach ($contacts as $contact)
            <tr class="admin-table__row">
                <td class="todo-table__item">{{$contact->last_name}} {{$contact->first_name}}</td>
                @if ($contact['gender'] === 1)
                    <td class="todo-table__item">男性</td>
                @elseif ($contact['gender'] === 2)
                    <td class="todo-table__item">女性</td>
                @elseif ($contact['gender'] === 3)
                    <td class="todo-table__item">その他</td>
                @endif
                <td class="todo-table__item">{{$contact->email}}</td>
                <td class="todo-table__item">{{$contact->category->content}}</td>
                <td class="todo-table__item">
                    <form class="detail-form">
                        <div class="detail-form__button">
                            <button class="detail-form__button--submit" type="submit">詳細</button>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection