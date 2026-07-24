# alwaysdata 公開手順（memo2026用）

## 1. PHPを設定する

alwaysdata管理画面の **Environment > PHP** を開き、PHPを **8.3以上** に設定します。

## 2. MySQLデータベースを作成する

管理画面の **Databases > MySQL** からデータベースを作成します。

例：

```text
データベース名: memo2026_memo
ユーザー名: memo2026
ホスト: mysql-memo2026.alwaysdata.net
ポート: 3306
```

実際のデータベース名・ユーザー名・パスワードは管理画面に表示された値を使ってください。

## 3. GitHubから取得する

SSH接続を有効にしてから、PCのターミナルで接続します。

```bash
ssh memo2026@ssh-memo2026.alwaysdata.net
```

初回は、alwaysdata登録時のパスワードを使用します。

接続後、GitHubからコードを取得します。

```bash
cd ~
git clone https://github.com/あなたのGitHubユーザー名/memo2026.git
cd memo2026
```

## 4. Laravelをセットアップする

```bash
composer2 install --no-dev --optimize-autoloader
cp .env.alwaysdata.example .env
php artisan key:generate
```

`.env`を編集します。

```bash
nano .env
```

最低限、次の部分を管理画面の値に変更してください。

```env
DB_DATABASE=memo2026_実際のDB名
DB_USERNAME=memo2026
DB_PASSWORD=実際のDBパスワード
```

`APP_KEY` は `php artisan key:generate` で自動生成されます。

## 5. ディレクトリとDBを準備する

```bash
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache
php artisan migrate --force
```

動作確認用のサンプルメモが必要なら、次も実行します。

```bash
php artisan db:seed --force
```

## 6. Webサイトを設定する

管理画面の **Web > Sites** で、`memo2026.alwaysdata.net` のサイトを設定します。

```text
Type: PHP
Root directory: /home/memo2026/memo2026/public
Address: memo2026.alwaysdata.net
```

HTTPからHTTPSへのリダイレクトも有効にします。

重要なのは、ルートディレクトリをプロジェクト直下ではなく、必ず `public` にすることです。

## 7. 本番用キャッシュを作る

```bash
cd ~/memo2026
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

ブラウザで次を開きます。

```text
https://memo2026.alwaysdata.net
```

## 更新するとき

GitHubへpushした後、alwaysdataへSSH接続して実行します。

```bash
cd ~/memo2026
git pull origin main
composer2 install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## よくあるエラー

### 500エラー

ログを確認します。

```bash
tail -n 100 ~/memo2026/storage/logs/laravel.log
```

alwaysdata管理画面のログも確認してください。

### No application encryption key

```bash
php artisan key:generate
php artisan config:clear
```

### SQLSTATE Access denied

`.env`のDB名、ユーザー名、パスワードを確認します。

### CSSが表示されない

Webサイトのルートが次になっているか確認します。

```text
/home/memo2026/memo2026/public
```
