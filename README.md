# coachtech-mock

このリポジトリは、Laravel を用いた模擬フリマアプリのプロジェクトです。

## 環境構築

#### Dockerビルド

1. ```git clone git@github.com:cahoco/coachtech-mock.git```
2. ```cd coachtech-mock```
3. DockerDesktopアプリを立ち上げる
4. ```docker compose up -d```

#### Laravel 環境構築

1. ```docker compose exec php bash```

2. ```composer install```

3. ```cp .env.example .env```

4. env に以下の環境変数を追加

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
```
MAIL_FROM_ADDRESS=test@example.com
MAIL_FROM_NAME="Laravel App"
```
```
STRIPE_KEY=pk_test_***
STRIPE_SECRET=sk_test_***
```

5. アプリケーションキーの作成

```
php artisan key:generate
```

6. マイグレーションの実行

```
php artisan migrate
```

7. シーディングの実行

```
php artisan db:seed
```

8. シンボリックリンク作成

```
php artisan storage:link
```

## ログイン

ブラウザで http://localhost/ にアクセス

- メールアドレス：test@example.com
- パスワード：00000000


## テスト実行

```
php artisan test
```

## 使用技術

- PHP 8.2.28
- Laravel 8.83.29
- MySQL 8.0.26 
- Docker / Docker Compose
- Laravel Fortify（認証）v1.19.1
- PHPUnit（テスト）
- Mailhog（メール認証テスト用）

## テーブル設計

<img width="421" alt="coachtech-mock-table" src="https://github.com/user-attachments/assets/62a9a110-14fb-4e44-b4cd-ce3fe9e23e53" />

## ER図

<img width="578" alt="coachtech-mock-er" src="https://github.com/user-attachments/assets/362e0fe8-2170-4688-a340-aae130e6e8df" />

## URL

* 開発環境：http://localhost/
* phpMyAdmin:：http://localhost:8080/

#### メッセージ

* `.env.testing` は Git 履歴から削除済みです。今後コミットしないよう `.gitignore` に追加済み。  
* ブランド名は分からない場合もあると思うので入力必須にしていません。
* 建物名はない場合もあると思ったのですが、基本設計書の指定に従い入力必須にしました。
* レスポンシブ対応はPC(1400-1540px)とタブレット(768-850px)のみでスマホは対応していません。
* 画面定義では、?pageを?tabに変更しています。その他も変更あり。（齋藤コーチに確認済み）
* テスト後はシーディングを実行して再度初期データを入れてください。
