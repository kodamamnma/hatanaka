# 変更履歴

## 2026-06-24 — GitHub Actions を現在のプロジェクトに最適化

### 背景
`.github/` 以下のワークフローが別プロジェクト（kawabata-wp-theme）の設定のまま残っており、このプロジェクト（畠中祐介）の構成と合っていなかった。

### 変更内容

| ファイル | 変更内容 |
|---|---|
| `.github/actions/php-syntax-check/action.yml` | PHP バージョンを `7.4`（EOL）→ `8.2`（Xserver推奨）に変更 |
| `.github/workflows/deploy-staging.yml` | `local-dir` を `./kawabata-wp-theme/` → `./php/` に修正 |
| `.github/workflows/deploy-production.yml` | `local-dir` を `./kawabata-wp-theme/` → `./php/` に修正 |
| `.github/workflows/deploy-production.yml` | バージョン取得元を `kawabata-wp-theme/style.css` → `php/style.css` に修正 |

### デプロイフロー概要
- **develop ブランチ push** → PHPシンタックスチェック → ステージングサーバーへFTPSデプロイ
- **main ブランチ push** → PHPシンタックスチェック → 本番サーバーへFTPSデプロイ → リリースドラフト作成

### 必要なGitHub Secrets
**ステージング用:**
- `STAGING_SERVER_HOST` — サーバーホスト名
- `STAGING_SERVER_USER` — FTPユーザー名
- `STAGING_SERVER_PASSWORD` — FTPパスワード
- `STAGING_THEME_PATH` — デプロイ先パス

**本番用:**
- `SERVER_HOST` — サーバーホスト名
- `SERVER_USER` — FTPユーザー名
- `SERVER_PASSWORD` — FTPパスワード
- `PRODUCTION_THEME_PATH` — デプロイ先パス
