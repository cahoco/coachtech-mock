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

9.

```
php artisan config:clear
```

### テスト実行

```
php artisan test
```

### ログイン

ブラウザで http://localhost/ にアクセス

#### テストユーザー

- メールアドレス：test@example.com
- パスワード：0000

## 📦 使用技術

- PHP 8.x
- Laravel 10.x
- MySQL
- Docker / Docker Compose
- Laravel Fortify（認証）
- PHPUnit（テスト）
- Mailhog（メール認証テスト用）

#### 注意事項

※ `.env.testing` は Git 履歴から削除済みです。今後コミットしないよう `.gitignore` に追加済み。
