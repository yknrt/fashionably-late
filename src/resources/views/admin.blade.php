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
        <form action="/admin/export" method="post">
            @csrf
            <div class="form__page--export">
                <button class="form__page--export-submit" type="submit">エクスポート</button>
            </div>
        </form>
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
                <td class="admin-table__item">{{$contact->last_name}} {{$contact->first_name}}</td>
                @if ($contact['gender'] === 1)
                    <td class="admin-table__item">男性</td>
                @elseif ($contact['gender'] === 2)
                    <td class="admin-table__item">女性</td>
                @elseif ($contact['gender'] === 3)
                    <td class="admin-table__item">その他</td>
                @endif
                <td class="admin-table__item">{{$contact->email}}</td>
                <td class="admin-table__item">{{$contact->category->content}}</td>
                <td class="admin-table__item">
                    <form class="detail-form">
                        @csrf
                        <div class="detail-form__button">
                            <input type="hidden" name="id" value="{{ $contact->id }}">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#modal{{$contact->id}}">詳細</button>
                        </div>
                    </form>
                    <!-- modal -->
                    <div class="modal fade" id="modal{{$contact->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <p></p>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="modal-table">
                                        <tr class="modal-table__row">
                                            <th class="modal-table__header">お名前</th>
                                            <td class="modal-table__item">{{$contact->last_name}} {{$contact->first_name}}</td>
                                        </tr>
                                        <tr class="modal-table__row">
                                            <th class="modal-table__header">性別</th>
                                            @if ($contact['gender'] === 1)
                                                <td class="modal-table__item">男性</td>
                                            @elseif ($contact['gender'] === 2)
                                                <td class="modal-table__item">女性</td>
                                            @elseif ($contact['gender'] === 3)
                                                <td class="modal-table__item">その他</td>
                                            @endif
                                        </tr>
                                        <tr class="modal-table__row">
                                            <th class="modal-table__header">メールアドレス</th>
                                            <td class="modal-table__item">{{$contact->email}}</td>
                                        </tr>
                                        <tr class="modal-table__row">
                                            <th class="modal-table__header">電話番号</th>
                                            <td class="modal-table__item">{{$contact->tell}}</td>
                                        </tr>
                                        <tr class="modal-table__row">
                                            <th class="modal-table__header">住所</th>
                                            <td class="modal-table__item">{{$contact->address}}</td>
                                        </tr>
                                        <tr class="modal-table__row">
                                            <th class="modal-table__header">建物名</th>
                                            <td class="modal-table__item">{{$contact->building}}</td>
                                        </tr>
                                        <tr class="modal-table__row">
                                            <th class="modal-table__header">お問い合わせの種類</th>
                                            <td class="modal-table__item">{{$contact->category->content}}</td>
                                        </tr>
                                        <tr class="modal-table__row">
                                            <th class="modal-table__header">お問い合わせ内容</th>
                                            <td class="modal-table__item">{{$contact->detail}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <form action="/admin/delete" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $contact['id'] }}">
                                        <button type="submit" class="btn btn-danger">削除</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> -->
@endsection