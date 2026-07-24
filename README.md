# Memo 2026

PHP / Laravel / MySQLで作成した、シンプルなメモアプリ。

## 機能

- メモの一覧表示
- メモの登録・編集・削除
- タイトル・本文のキーワード検索
- 10件ごとのページネーション
- バリデーション
- レスポンシブデザイン
- PHPUnitによるCRUDテスト
- GitHub Actionsによる自動テスト

## 使用技術

- PHP 8.3以上
- Laravel 13
- MySQL / MariaDB（本番）
- SQLite（ローカル開発・テスト）
- Blade / CSS

## ローカルで動かす

PHP 8.3以上とComposerをインストールしてから実行します。

```bash
composer install
cp .env.example .env
php artisan key:generate
```

SQLiteファイルを作ります。

### Windows PowerShell

```powershell
New-Item database/database.sqlite -ItemType File -Force
```

### macOS / Linux

```bash
touch database/database.sqlite
```

最初の `composer install` で `composer.lock` が作成された場合は、そのファイルもGitHubへコミットしてください。

続いてDBを作成して起動します。

```bash
php artisan migrate
php artisan serve
```

ブラウザで `http://localhost:8000` を開きます。

サンプルメモも作成する場合は次を実行します。

```bash
php artisan db:seed
```

## テスト

```bash
composer test
```

## GitHubへ登録する

GitHubで空のリポジトリ `memo2026` を作成してから、プロジェクトのフォルダで実行します。

```bash
git init
git add .
git commit -m "Create Laravel memo app"
git branch -M main
git remote add origin https://github.com/pipy/memo2026.git
git push -u origin main
```

`.env` は `.gitignore` に入っているため、DBパスワードやAPP_KEYはGitHubへ送信されません。

> [!WARNING]
> この初期版にはログイン機能がありません。インターネットへ公開すると、URLを知っている人はメモの閲覧・登録・編集・削除ができます。個人的な情報は保存せず、次の段階で認証機能を追加してください。

ライセンスを先に作ってpushできない場合
```bash
git checkout --theirs LICENSE
git add LICENSE
git commit -m "Merge GitHub initial commit"
git push -u origin main
```


## alwaysdataへ公開する

詳しい手順は [DEPLOY_ALWAYSDATA.md](DEPLOY_ALWAYSDATA.md) を参照してください。

公開URL

```text
https://memo2026.alwaysdata.net/notes
```

## 自動デプロイ

`.github/workflows/deploy-alwaysdata.yml.example` は、自動デプロイ用のひな型です。
最初は手動で公開し、動作確認が終わってから `.example` を外して使用してください。


## 自動デプロイ用Secrets

自動デプロイを使う場合は、GitHubの **Settings > Secrets and variables > Actions** に次を登録します。

```text
ALWAYSDATA_SSH_HOST=ssh-memo2026.alwaysdata.net
ALWAYSDATA_SSH_USER=memo2026
ALWAYSDATA_DEPLOY_PATH=/home/memo2026/memo2026
ALWAYSDATA_SSH_PRIVATE_KEY=SSH秘密鍵の内容
```

秘密鍵と対になる公開鍵は、alwaysdata側の `~/.ssh/authorized_keys` に登録します。
