@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="contact-form__content">
    <div class="contact-form__heading">
        <p>Contact</p>
    </div>
    <form class="form" action="/confirm" method="post">
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お名前</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--name">
                    <input type="text" name="last_name" placeholder="例：山田" value="{{ old('last_name') }}" />
                    <input type="text" name="first_name" placeholder="例：太郎" value="{{ old('first_name') }}" />
                </div>
                <div class="form__error">
                    @error('firstName')
                    {{ $message }}
                    @enderror
                </div>
                <div class="form__error">
                    @error('lastName')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">性別</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--radio">
                    <input type="radio" id="genderChoice1" name="gender" value=1 {{ old('gender') === 1 ? 'checked' : '' }} checked />
                    <label for="genderChoice1">男性</label>
                    <input type="radio" id="genderChoice2" name="gender" value=2 {{ old('gender') === 2 ? 'checked' : '' }} />
                    <label for="genderChoice2">女性</label>
                    <input type="radio" id="genderChoice3" name="gender" value=3 {{ old('gender') === 3 ? 'checked' : '' }} />
                    <label for="genderChoice3">その他</label>
                </div>
                <div class="form__error">
                    @error('gender')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">メールアドレス</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="email" name="email" placeholder="例：test@example.com" value="{{ old('email') }}" />
                </div>
                <div class="form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">電話番号</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--tel">
                    <!-- pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" -->
                    <input type="tel" name="tel-area-code" placeholder="080" value="{{ old('tel-area-code') }}" />
                    <span>-</span>
                    <input type="tel" name="tel-local-prefix" placeholder="1234" value="{{ old('tel-local-prefix') }}" />
                    <span>-</span>
                    <input type="tel" name="tel-local-suffix" placeholder="5678" value="{{ old('tel-local-suffix') }}" />
                </div>
                <div class="form__error">
                    @if ($errors->has('tel-area-code'))
                        {{$errors->first('tel-area-code')}}
                    @elseif ($errors->has('tel-local-prefix'))
                        {{$errors->first('tel-local-prefix')}}
                    @elseif ($errors->has('tel-local-suffix'))
                        {{$errors->first('tel-local-suffix')}}
                    @endif
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">住所</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="address" placeholder="例:東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address') }}" />
                </div>
                <div class="form__error">
                    @error('address')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">建物名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="building" placeholder="例:千駄ヶ谷マンション101" value="{{ old('building') }}" />
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お問い合わせの種類</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--select">
                    <select name="category_id">
                        <option value="">選択してください</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category['id'] }}" @if( old('category_id') == $category['id'] ) selected @endif>{{ $category['content'] }}</option>
                        @endforeach
                        <!-- <option value="商品のお届けについて" @if( old('content') === '商品のお届けについて' ) selected @endif>商品のお届けについて</option>
                        <option value="商品の交換について" @if( old('content') === '商品の交換について' ) selected @endif>商品の交換について</option>
                        <option value="商品トラブル" @if( old('content') === '商品トラブル' ) selected @endif>商品トラブル</option>
                        <option value="ショップへのお問い合わせ" @if( old('content') === 'ショップへのお問い合わせ' ) selected @endif>ショップへのお問い合わせ</option>
                        <option value="その他" @if( old('content') === 'その他' ) selected @endif>その他</option> -->
                    </select>
                </div>
                <div class="form__error">
                    @error('content')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お問い合わせ内容</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--textarea">
                    <textarea name="detail" placeholder="お問い合わせ内容をご記載ください">{{ old('detail') }}</textarea>
                </div>
                <div class="form__error">
                    @error('detail')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">送信</button>
        </div>
    </form>
</div>
@endsection