# お問い合わせフォーム

## 環境構築
### Dokerビルド
1．git clone リンク

2．docker-compose up -d --build

* MySQLは、docker-compose.ymlファイルを編集する。

### Laravel環境構築
1．docker-compose exec php bash

2．⁠composer install

3．.env.exampleファイルから.envファイルを作成し、環境変数を変更

4．php artisan key:generate

5．⁠php artisan migrate

6．php artisan db:seed


## 使用技術(実行環境)
・PHP 7.4.9

・Laravel 8.83.8

・MySQL 8.0.26

## ER図
< - - - 作成したER図の画像 - - - >

## URL
- 例) 開発環境：http://localhost/
