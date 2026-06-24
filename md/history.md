# 変更履歴

## 2026-06-24 — 声を届けるページのデモデータ削除・送信フィードバック追加

### 背景
`page-submit.php` のサイドバーに架空の声がハードコードされており、実データがない状態でもデモ表示されていた。また送信後・エラー時にユーザーへのフィードバックメッセージがなかった。

### 変更内容

| ファイル | 変更内容 |
|---|---|
| `php/page-submit.php` | デモデータ（架空の声4件）を削除 → 空のときは「まだ届いた声はありません」に変更 |
| `php/page-submit.php` | 送信成功時（`?sent=1`）・エラー時（`?error=1`）のメッセージ表示を追加 |
| `php/style.css` | `.form-msg`（success / error）・`.no-voices` のスタイルを追加 |

### フォームの仕組み（変更なし・確認済み）
- `functions.php` にハンドラ実装済み（nonce検証・サニタイズ・`voice` カスタム投稿として保存・管理者メール通知）
- 投稿は `pending`（承認待ち）で保存され、管理画面で承認後に公開される

---

## 2026-06-24 — プライバシーポリシーページ新規作成

### 背景
`/privacy` ページが未作成だったため、要件定義書のサイトマップに沿って新規作成。参考サイト（yokoito-kagoshima.jp/privacy）の構成を参考に、このサイトの用途（意見投稿フォーム・匿名投稿）に合わせた内容に調整。

### 変更内容

| ファイル | 変更内容 |
|---|---|
| `php/page-privacy.php` | プライバシーポリシーページ新規作成（WordPressカスタムテンプレート） |

### ページ構成（全10項目）
1. 基本方針
2. 収集する情報（匿名投稿コールアウト付き）
3. 情報の利用目的
4. 第三者への提供（Google Analytics記載含む）
5. 情報の管理・安全対策
6. CookieとGoogle Analytics（GA4）
7. 投稿・意見フォームについて（サイト固有）
8. 開示・訂正・削除の請求
9. ポリシーの変更（改定履歴テーブル付き）
10. お問い合わせ

### 運営者情報
- 運営者：畠中祐介
- 所在地：鹿児島県姶良市
- 連絡先：kagoshima_kataro@hatabox126.net

### WordPress設定
- テンプレート名：`プライバシーポリシー`
- 推奨スラッグ：`/privacy`



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
