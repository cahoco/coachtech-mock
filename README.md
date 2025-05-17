# coachtech-mock

このリポジトリは、Laravel を用いた模擬フリマアプリのプロジェクトです。

## 📦 使用技術

- PHP 8.x
- Laravel 10.x
- MySQL
- Docker / Docker Compose
- Laravel Fortify（認証）
- PHPUnit（テスト）
- Mailhog（メール認証テスト用）

## 🚀 セットアップ手順

### 1. リポジトリをクローン

```bash
git clone git@github.com:cahoco/coachtech-mock.git
cd coachtech-mock
code .

```

### 2. Docker を起動

```
docker compose up -d
```

### 3. コンテナ内でセットアップ

```
docker compose exec php bash
composer install
cp .env.example .env
```

.env ファイルの修正
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

```
php artisan key:generate
php artisan config:clear
php artisan migrate --seed
```

### 4. メール認証テスト（Mailhog）

ブラウザで http://localhost:8025 にアクセス

## テスト実行

```
php artisan test
```

#### 注意事項

※ `.env.testing` は Git 履歴から削除済みです。今後コミットしないよう `.gitignore` に追加済み。
