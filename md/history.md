# 変更履歴

## 2026-07-16 — 「届いた声」デモデータの完全削除・空状態メッセージ統一、最近の記事カードの余白追加

### 背景
トップページ・声を届けるページに残っていた「届いた声」のダミー投稿（渋滞・給食・霧島・能力＝金銭のデモ4件）が、実際に声が0件の場合と見分けがつかなかった。また、トップページの「最近の記事」カード4枚が `grid-4 flush` により1pxの隙間しかなく、余白が詰まって見えていた。

### 変更内容

| ファイル | 変更内容 |
|---|---|
| `index.html` | 「届いた声」のデモ4件を削除し、`<p class="wall-empty">あなたの声をお待ちしています。</p>` に置き換え |
| `php/page-top.php` | 投稿が0件のときのフォールバック（デモ4件）を同様に `wall-empty` メッセージへ置き換え |
| `submit.html` | サイドバー「最近届いた声」のデモ4件を削除し、`<p class="no-voices">あなたの声をお待ちしています。</p>` に置き換え |
| `php/page-submit.php` | 空状態メッセージの文言を「まだ届いた声はありません。最初の一声を届けてください。」→「あなたの声をお待ちしています。」に統一 |
| `style.css` | `.grid-4.flush` の `gap` を `1px`（ボーダー風の隙間）→ `24px` に変更してカード間に余白を追加。`.wall-empty` / `.no-voices` の空状態表示用スタイルを新規追加 |

---

## 2026-07-14 — トップページが素の投稿一覧になっていた問題への対応（前段でfront-page.php追加→削除、管理画面設定に一本化）

### 背景
実際のWordPressサイトのトップページが `index.html`（デザインモックアップ）/ `page-top.php`（既存のカスタムテンプレート）と見た目が異なっていた。原因は、WordPressの管理画面「表示設定」で `page-top.php` を割り当てた固定ページが静的フロントページとして設定されていなかったため、装飾のない `index.php`（タイトル・抜粋のみを並べる素のフォールバックテンプレート）がトップページとして表示されていたこと。

### 経緯
1. 一時対応として `php/front-page.php`（`page-top.php` と同一内容）を新規作成 → `front-page.php` は表示設定に関わらず常にトップページとして最優先されるため
2. しかし `front-page.php` が存在すると、管理画面で `page-top.php` を固定ページテンプレートとして選んでも無視される（実体と管理画面の設定が食い違う）ため、運用方針を確認
3. → **管理画面の「表示設定」で `page-top.php` を割り当てた固定ページを正式にホームページとして設定する運用に一本化**することに決定し、`php/front-page.php` は削除

### 変更内容

| ファイル | 変更内容 |
|---|---|
| `php/front-page.php` | 作成 → 削除（運用を管理画面設定に一本化したため不要に） |

### 必要なWordPress管理画面での設定（要対応）
1. 固定ページを新規作成（本文は空でよい）
2. 「ページ属性」→ テンプレートを `トップページ`（`page-top.php`）に設定して公開
3. 設定 → 表示設定 → 「ホームページの表示」を「固定ページ」にし、手順1で作成したページを選択

---

## 2026-07-14 — Aboutページ新規作成・プライバシーポリシーページのヘッダー追加

### 背景
サイトマップ上は `/about/` がPhase 1必須ページとされていたが未作成で、ヘッダー・フッターの「About」リンクはトップページ内の `#about` アンカーに仮置きされていた。また `page-privacy.php` は独自の `<html>` を持つ単独ページで、サイト共通のナビゲーションヘッダーが表示されない状態だった。

### 変更内容

| ファイル | 変更内容 |
|---|---|
| `php/page-about.php` | Aboutページ新規作成（WordPressカスタムテンプレート）。編集長プロフィール・編集方針・お問い合わせを掲載。`get_header()`/`get_footer()` を使用し既存の共通ヘッダー・フッターに準拠 |
| `php/header.php` | ナビゲーションの「About」リンクを `/#about` → `/about/` に変更、`is_page('about')` でカレント表示 |
| `php/footer.php` | フッターの「About」リンクを `/#about` → `/about/` に変更 |
| `php/page-privacy.php` | 独自ページ内に共通ヘッダー（`.siteh` ナビゲーション）を追加。既存の独自スタイルとは別に `.siteh` 用CSSを追記 |

### WordPress設定
- Aboutページ テンプレート名：`About`
- 推奨スラッグ：`/about`

---

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
