# flea-market-app(フリマアプリ)

## 環境構築

### Docker ビルド
```bash
git clone git@github.com:yuno-zawa/flea-market-app.git
cd flea-market-app
docker compose up -d --build
```
### Laravel環境構築
```bash
docker compose exec php bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
```

## ログイン情報
環境構築の手順にて`php artisan db:seed` を実行することで、以下のテスト用アカウントが作成されます。
※現段階で利用できる機能に違いはありません。

### 一般ユーザー
- メールアドレス: user@example.com
- パスワード: password

### 管理者ユーザー
- メールアドレス: admin@example.com
- パスワード: password

### Stripeの設定
Stripe公式サイトでテスト用アカウントを作成し、`.env`に以下のキーを設定してください。
- STRIPE_KEY（または STRIPE_PUBLIC_KEY）
- STRIPE_SECRET_KEY

### 使用技術(実行環境)
* PHP 8.1.34
* Laravel 8.83.29
* MySQL 8.0互換 (MariaDB 11.8.3)
* nginx 1.21.1
* Docker 28.3.3
* Stripe API (決済機能用)
* MailHog (メール送信テスト)

### ER図

### URL
* 開発環境: http://localhost
* phpMyAdmin: http://localhost:8080
* MailHog: http://localhost:8025