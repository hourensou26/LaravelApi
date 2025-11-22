# Laravel + React 認証システム

[![Laravel](https://img.shields.io/badge/Laravel-12.0-red.svg)](https://laravel.com)
[![React](https://img.shields.io/badge/React-19.1-blue.svg)](https://react.dev)
[![PHP](https://img.shields.io/badge/PHP-8.2-purple.svg)](https://php.net)
[![TypeScript](https://img.shields.io/badge/TypeScript-5.9-blue.svg)](https://www.typescriptlang.org)
[![Docker](https://img.shields.io/badge/Docker-Compose-2496ED.svg)](https://www.docker.com)

Laravel APIバックエンド + React SPAフロントエンドによるトークンベース認証システム

## 📋 目次

- [特徴](#-特徴)
- [技術スタック](#-技術スタック)
- [システム構成](#-システム構成)
- [前提条件](#-前提条件)
- [セットアップ](#-セットアップ)
- [使い方](#-使い方)
- [API仕様](#-api仕様)
- [開発](#-開発)
- [テスト](#-テスト)
- [トラブルシューティング](#-トラブルシューティング)
- [セキュリティ](#-セキュリティ)
- [ライセンス](#-ライセンス)

## ✨ 特徴

- 🔐 **Laravel Sanctum**によるトークンベース認証
- ⚛️ **React 19** + **TypeScript**によるモダンなSPA
- 🐳 **Docker Compose**による開発環境の簡単構築
- 🚀 **Vite**による高速な開発サーバー
- 🔒 パスワードのbcrypt暗号化
- 📝 API動作確認エンドポイント
- 🎨 クリーンなコード構成

## 🛠 技術スタック

### バックエンド
- **Laravel 12** - PHPフレームワーク
- **PHP 8.2** - プログラミング言語
- **Laravel Sanctum** - API認証
- **MySQL 8.0** - データベース
- **Redis** - キャッシュ・セッション管理
- **Nginx** - Webサーバー

### フロントエンド
- **React 19** - UIライブラリ
- **TypeScript 5.9** - 型安全な開発
- **Vite 7** - ビルドツール
- **ESLint** - コード品質管理

### インフラ
- **Docker** - コンテナ化
- **Docker Compose** - マルチコンテナ管理

## 🏗 システム構成

```
┌─────────────┐      ┌──────────────┐      ┌─────────┐
│   Browser   │◄────►│    Nginx     │◄────►│ Laravel │
│  (React)    │      │  (Reverse    │      │   API   │
│   :5173     │      │   Proxy)     │      │  :9000  │
└─────────────┘      │    :8081     │      └────┬────┘
                     └──────────────┘           │
                                         ┌──────┴──────┐
                                         │             │
                                    ┌────▼────┐   ┌───▼────┐
                                    │  MySQL  │   │ Redis  │
                                    │  :3306  │   │ :6379  │
                                    └─────────┘   └────────┘
```

### ディレクトリ構成

```
laravelApi/
├── backend/              # Laravel APIアプリケーション
│   ├── app/
│   │   ├── Http/
│   │   │   └── Controllers/
│   │   │       └── AuthController.php
│   │   └── Models/
│   │       └── User.php
│   ├── routes/
│   │   └── api.php
│   ├── database/
│   │   └── migrations/
│   └── composer.json
├── frontend/             # React SPAアプリケーション
│   ├── src/
│   │   ├── App.tsx
│   │   └── main.tsx
│   ├── package.json
│   └── vite.config.ts
├── docker/               # Docker設定
│   ├── nginx/
│   │   └── default.conf
│   ├── php/
│   │   └── Dockerfile
│   └── frontend/
│       └── Dockerfile
├── docker-compose.yml
├── .env
└── README.md
```

## 📦 前提条件

以下がインストールされている必要があります：

- **Docker Desktop** (最新版推奨)
- **Git**
- **WSL2** (Windows環境の場合)

### ポート要件

以下のポートが利用可能である必要があります：

- `5173` - React開発サーバー
- `8081` - Nginx (Laravel API)
- `3306` - MySQL
- `6379` - Redis

## 🚀 セットアップ

### 1. リポジトリのクローン

```bash
git clone https://github.com/hourensou26/LaravelApi.git
cd LaravelApi
```

### 2. 環境変数の設定

```bash
# .envファイルを作成
echo "LOCAL_UID=$(id -u)" > .env
echo "LOCAL_GID=$(id -g)" >> .env
```

### 3. Dockerコンテナの起動

```bash
# コンテナをビルド・起動
docker-compose up -d

# ログを確認（オプション）
docker-compose logs -f
```

### 4. バックエンドのセットアップ

```bash
# 依存パッケージのインストール
docker-compose exec backend composer install

# アプリケーションキーの生成
docker-compose exec backend cp .env.example .env
docker-compose exec backend php artisan key:generate

# データベースマイグレーション
docker-compose exec backend php artisan migrate

# シーダー実行（オプション）
docker-compose exec backend php artisan db:seed
```

### 5. フロントエンドのセットアップ

```bash
# 依存パッケージのインストール
docker-compose exec frontend npm install
```

### 6. 動作確認

```bash
# APIの動作確認
curl http://localhost:8081/api/test
# 期待される出力: {"message":"API動作確認OK"}
```

ブラウザで以下にアクセス：
- **フロントエンド**: http://localhost:5173
- **バックエンドAPI**: http://localhost:8081/api

## 💻 使い方

### API エンドポイント

#### 動作確認

```bash
GET http://localhost:8081/api/test
```

#### ユーザー登録

```bash
curl -X POST http://localhost:8081/api/Auth/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "山田太郎",
    "email": "taro@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

**レスポンス例 (201 Created):**
```json
{
  "message": "ユーザー登録が完了しました",
  "user": {
    "name": "山田太郎",
    "email": "taro@example.com"
  },
  "token": "1|abcdefghijklmnopqrstuvwxyz1234567890"
}
```

#### ログイン

```bash
curl -X POST http://localhost:8081/api/Auth/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "taro@example.com",
    "password": "password123"
  }'
```

**レスポンス例 (200 OK):**
```json
{
  "token": "2|abcdefghijklmnopqrstuvwxyz1234567890"
}
```

#### ユーザー情報取得（認証必須）

```bash
curl -X GET http://localhost:8081/api/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

**レスポンス例 (200 OK):**
```json
{
  "name": "山田太郎",
  "email": "taro@example.com"
}
```

#### ログアウト（認証必須）

```bash
curl -X POST http://localhost:8081/api/logout \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

**レスポンス例 (200 OK):**
```json
{
  "message": "ログアウトしました"
}
```

## 📚 API仕様

### エンドポイント一覧

| メソッド | パス | 認証 | 説明 |
|---------|------|------|------|
| GET | `/api/test` | 不要 | API動作確認 |
| POST | `/api/Auth/register` | 不要 | 新規ユーザー登録 |
| POST | `/api/Auth/login` | 不要 | ログイン |
| GET | `/api/me` | 必須 | 認証ユーザー情報取得 |
| POST | `/api/logout` | 必須 | ログアウト |

### 認証方式

**Laravel Sanctum**によるトークンベース認証

**ヘッダー形式:**
```
Authorization: Bearer {token}
```

### バリデーションルール

#### 登録
- `name`: 必須、文字列、最大255文字
- `email`: 必須、メール形式、最大255文字、ユニーク
- `password`: 必須、文字列、最小8文字
- `password_confirmation`: 必須、passwordと一致

#### ログイン
- `email`: 必須、メール形式
- `password`: 必須

## 🔧 開発

### コンテナの操作

```bash
# コンテナの起動
docker-compose up -d

# コンテナの停止
docker-compose down

# コンテナの再起動
docker-compose restart

# ログの確認
docker-compose logs -f [service_name]

# コンテナに入る
docker-compose exec backend bash
docker-compose exec frontend sh
```

### Laravel コマンド

```bash
# マイグレーション
docker-compose exec backend php artisan migrate

# マイグレーションのロールバック
docker-compose exec backend php artisan migrate:rollback

# キャッシュクリア
docker-compose exec backend php artisan cache:clear
docker-compose exec backend php artisan config:clear
docker-compose exec backend php artisan route:clear

# Tinker (REPL)
docker-compose exec backend php artisan tinker
```

### データベース操作

```bash
# MySQLに接続
docker-compose exec db mysql -u root -proot react_app

# データベースのバックアップ
docker-compose exec db mysqldump -u root -proot react_app > backup.sql

# データベースのリストア
docker-compose exec -T db mysql -u root -proot react_app < backup.sql
```

### React開発

```bash
# フロントエンドコンテナに入る
docker-compose exec frontend sh

# 依存関係の追加
npm install [package-name]

# ビルド
npm run build

# Lint実行
npm run lint
```

## 🧪 テスト

### バックエンドテスト

```bash
# PHPUnit実行
docker-compose exec backend php artisan test

# カバレッジ付き
docker-compose exec backend php artisan test --coverage

# Laravel Pint (コードスタイル)
docker-compose exec backend ./vendor/bin/pint

# セキュリティ監査
docker-compose exec backend composer audit
```

### フロントエンドテスト

```bash
# ESLint実行
docker-compose exec frontend npm run lint

# TypeScript型チェック
docker-compose exec frontend npx tsc --noEmit

# ビルドテスト
docker-compose exec frontend npm run build
```

## 🐛 トラブルシューティング

### ポート競合エラー

```bash
# 使用中のポートを確認
sudo lsof -i :5173
sudo lsof -i :8081
sudo lsof -i :3306

# プロセスを終了
sudo kill -9 [PID]
```

### パーミッションエラー

```bash
# ユーザーIDの確認
id -u
id -g

# .envファイルを更新
echo "LOCAL_UID=$(id -u)" > .env
echo "LOCAL_GID=$(id -g)" >> .env

# コンテナ再ビルド
docker-compose down
docker-compose up -d --build
```

### データベース接続エラー

```bash
# コンテナの状態確認
docker-compose ps

# データベースログ確認
docker-compose logs db

# データベース再起動
docker-compose restart db
```

### キャッシュ問題

```bash
# Laravelキャッシュクリア
docker-compose exec backend php artisan cache:clear
docker-compose exec backend php artisan config:clear
docker-compose exec backend php artisan route:clear
docker-compose exec backend php artisan view:clear

# Composerキャッシュクリア
docker-compose exec backend composer clear-cache

# npmキャッシュクリア
docker-compose exec frontend npm cache clean --force
```

### 完全リセット

```bash
# 全コンテナとボリュームを削除
docker-compose down -v

# イメージも削除
docker-compose down --rmi all -v

# 再構築
docker-compose build --no-cache
docker-compose up -d
```

## 🔒 セキュリティ

### 実装済みのセキュリティ対策

- ✅ パスワードのbcrypt暗号化
- ✅ トークンベース認証（Laravel Sanctum）
- ✅ CSRF保護
- ✅ HTTPOnlyクッキー
- ✅ SameSite属性
- ✅ メールアドレスの一意性制約
- ✅ パスワード最小長（8文字）
- ✅ パスワード確認フィールド
- ✅ SQLインジェクション対策（Eloquent ORM）

### 推奨される追加対策

- ⚠️ CORS設定の明示化
- ⚠️ トークン有効期限の設定
- ⚠️ レート制限の実装
- ⚠️ メール確認機能
- ⚠️ パスワードリセット機能
- ⚠️ 2要素認証
- ⚠️ セキュリティヘッダーの追加
- ⚠️ HTTPS設定（本番環境）

### 本番環境での推奨事項

1. **環境変数の適切な管理**
   - `.env`ファイルをGitにコミットしない
   - 本番環境では強力なパスワードを使用

2. **HTTPS化**
   - Let's Encryptの使用
   - 全通信の暗号化

3. **データベースバックアップ**
   - 定期的な自動バックアップ
   - 複数世代の保持

4. **ログ監視**
   - エラーログの定期確認
   - 不審なアクセスの検知

## 📄 ライセンス

このプロジェクトはMITライセンスの下でライセンスされています。

## 👥 コントリビューター

- **hourensou26** - [GitHub](https://github.com/hourensou26)

## 🔗 関連リンク

- [Laravel公式ドキュメント](https://laravel.com/docs/12.x)
- [Laravel Sanctum](https://laravel.com/docs/12.x/sanctum)
- [React公式ドキュメント](https://react.dev)
- [Docker Compose](https://docs.docker.com/compose/)
- [TypeScript](https://www.typescriptlang.org)

## 📞 サポート

問題や質問がある場合は、[GitHub Issues](https://github.com/hourensou26/LaravelApi/issues)で報告してください。

---

**Last Updated**: 2025年11月22日  
**Version**: 1.0.0  
**Status**: 開発中
