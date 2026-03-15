# お問い合わせフォーム（Contact Form）

## 環境構築

### Dockerビルド

```bash
git clone git@github.com:kouki014129/mogitate-market.git
cd mogitate-market
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

### 開発環境

- 開発環境：http://localhost:85
- phpMyAdmin：http://localhost:8085

### 使用技術（実行環境）

- PHP 8.1
- Laravel 8.83.29
- MySQL 8.0.26
- nginx 1.21.1
- Docker / docker compose

### ER図

![ER図](src/public/images/er.png)
