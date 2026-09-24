# README.md — 案件仕様書（常に最新の状態に上書きする）

このファイルは **「今どうなっているか」** を定義する。
案件ごとに全項目を埋める。決まっていない項目は消さず `未定` と書く。
過去の経緯は書かない（→ `history.md`）。ルールは書かない（→ `CLAUDE.md`）。

---

## 1. 案件概要

| 項目 | 内容 |
|---|---|
| クライアント名 | 畠中さま（鹿児島県姶良市） |
| 担当者 / 連絡手段 | 未定 |
| サイト名 | 鹿児島を、語ろう。（プロジェクト名：KATAROU） |
| 本番URL | 未定 |
| ステージング/ローカルURL | 未定（ステージングは GitHub Secrets の `STAGING_*` に設定済みの前提） |
| 制作範囲 | 新規制作（WordPress オリジナルテーマ） |
| 納期・マイルストーン | 未定（要件定義書では「7月中旬 第1回タウンミーティング連動公開」を仮置き） |
| 公開後の更新担当 | 畠中さま（非エンジニア。記事作成・「届いた声」の承認を管理画面で行う） |

## 2. サイトの目的（優先順位つき）

1. 鹿児島に住む人から意見（声）を集める — **北極星指標：月50件の意見投稿**
2. 集まった声・取材をもとに、県内の課題と楽しさを記事として発信する
3. タウンミーティング・SNS・LINE への集客動線になる

**コンバージョン定義**：声の投稿（/submit/ または全ページ右下のチャットからの送信）
**主なターゲット**：鹿児島在住の10〜40代の現役世代（特に若者）。流入は畠中さまのSNS・LINE・記事の拡散。スマホ優先

## 3. サイトマップ

| ページ | パス | 役割 | 状態 |
|---|---|---|---|
| トップ | `/` | 新着・特集・届いた声・投稿への誘導（`page-top.php`） | 完了 |
| 記事一覧 | `/articles/` | カテゴリ別の回遊（`page-articles.php`） | 完了 |
| 個別記事 | 投稿のURL | 本文・関連記事（`single.php`） | 完了 |
| 声を届ける | `/submit/` | 投稿フォーム＋チャット（`page-submit.php`） | 完了 |
| About | `/about/` | 編集長プロフィール・媒体の理念（`page-about.php`） | 完了 |
| プライバシーポリシー | `/privacy/` | `page-privacy.php` | 完了 |
| 要件定義書 | 未定 | 社内・クライアント確認用（`page-requirements.php`。一般公開は想定しない） | 完了 |
| お問い合わせ | `/contact/` | 取材・登壇依頼の窓口（要件定義書 Phase 1） | 未着手 |
| イベント / 声一覧 / 検索 | `/event/` `/voices/` `/search/` | 要件定義書 Phase 2 | 未着手 |

## 4. 技術構成

| 項目 | 内容 |
|---|---|
| 構成 | WordPress 自作テーマ（`php/` がテーマ本体）。`html/` は初期の静的デザインモック |
| 使用ライブラリ | なし（素のJSのみ）。Webフォントは Google Fonts（Zen Kaku Gothic New / Zen Old Mincho / Space Mono） |
| フォーム | 自作。`admin-post.php`（action=`submit_voice`）→ `functions.php` の `katarou_handle_voice_submit()` がカスタム投稿「voice」に **承認待ち** で保存し、管理者にメール通知 |
| CMS・カスタム投稿 | 通常投稿＝記事。カスタム投稿 `voice`（管理画面名「届いた声」）＝読者の声。トップページは管理画面「表示設定」で `page-top.php` の固定ページを指定 |
| サーバー / デプロイ方法 | GitHub Actions → FTPS。`develop` push でステージング、`main` push で本番（`php/` の中身をテーマフォルダへ） |
| 解析ツール | Google Search Console（サイト確認タグ設置済み）。GA4 は未定 |

## 5. ディレクトリ構造

```
hatanaka/
├─ .claude/            CLAUDE.md（作業ルール）/ README.md（本書）/ history.md（変更履歴）
├─ .github/
│  ├─ workflows/deploy-staging.yml      develop → ステージング
│  ├─ workflows/deploy-production.yml   main → 本番 + リリースノート
│  ├─ actions/php-syntax-check/         デプロイ前の PHP 構文チェック
│  └─ release-drafter.yml
├─ _archive/           初期HTMLのzip（参照用）
├─ html/               静的デザインモック（本番には使われない）
└─ php/                ★WordPressテーマ本体（ここがデプロイされる）
   ├─ style.css        テーマ情報 + 全体のCSS（:root にデザイントークン）
   ├─ functions.php    読み込み・声の投稿処理・カスタム投稿voice・SEOヘルパー
   ├─ header.php       meta / OGP / 構造化データ / グローバルナビ
   ├─ footer.php       フッター + 右下の声を届けるチャット（/submit/ 以外）
   ├─ index.php        フォールバック（通常は表示されない）
   ├─ page-top.php / page-articles.php / page-submit.php / page-about.php / page-privacy.php / page-requirements.php
   ├─ single.php       個別記事
   ├─ voice-form.php   声の投稿フォーム（/submit/ と右下パネルで共用）
   ├─ voice-chat.js / voice-chat.css   声を届けるチャット
   ├─ scripts.js       サイト共通JS（現状ほぼ空）
   └─ images/          articles/（記事写真）・thumbs/（カード用）。置き方は images/README.md
```

## 6. デザイントークン

CSS変数として定義し、**ここに無い値をコードに直書きしない**（`php/style.css` の `:root`）。

```css
:root {
  /* Color */
  --bg:       #fafaf7;   /* ページ背景（オフホワイト） */
  --paper:    #fff;      /* カード・入力欄の背景 */
  --bg-2:     #f4eedf;
  --bg-3:     #ebe3d0;
  --ink:      #14110d;   /* 本文・見出し（インクブラック） */
  --ink-2:    #4a4038;
  --mute:     #8a7f72;   /* 補足テキスト */
  --line:     #e6dfd0;
  --line-2:   #cbc1ad;
  --red:      #7a1018;   /* メインカラー（暗赤）・CTA */
  --red-deep: #5a0a12;   /* 赤のホバー */
  --red-pale: #f3dadd;
  --blue:     #2a5fd0;   /* アクセント */
  --blue-deep:#0f2d6b;
  --green:    #1f7a4a;
  --amber:    #a8730e;
  /* Font */
  --mincho:   'Zen Old Mincho', serif;                                    /* 見出し */
  --gothic:   'Zen Kaku Gothic New', 'Hiragino Kaku Gothic ProN', sans-serif; /* 本文 */
  --mono:     'Space Mono', monospace;                                     /* ラベル・メタ情報 */
  /* Space / Radius：未定義（トークン化されていない） */
}
```

| 項目 | 値 |
|---|---|
| ブレークポイント | SP: 〜600px / TB: 601〜960px / PC: 961px〜。既存の style.css は `max-width: 960px / 600px` で上書きするPC基準。新規追加分はモバイルファーストで `min-width: 601px / 961px` を使う |
| コンテンツ最大幅 | 1120px（`.wrap`） |
| ビジュアル方針 | マガジン型・大判写真。畠中さま撮影の鹿児島写真を優先（現状は Pixabay / Pexels の素材。出典は `images/PHOTO_CREDITS.md`） |
| トーン | 情熱的・骨太・編集。「当事者の言葉をそのまま載せる」 |

## 7. コンポーネント一覧

| 名称 | クラス名 | 使用ページ | 備考 |
|---|---|---|---|
| ヘッダー / ナビ | `.siteh` / `.nav` | 全ページ | 「声・提案を届ける」は `.btn-nav-cta` |
| フッター | `.foot` | 全ページ | |
| ボタン | `.btn` / `.btn-cta` / `.btn-pulse` / `.lg` | 全ページ | |
| 信頼バッジ | `.badge-cro` / `.form-trust-badges` | トップ / 声を届ける | 「匿名OK・1分」などの訴求 |
| 実績カウンター | `.social-proof-bar` | トップ | 数値（120+ / 45+ / 98%）は直書き |
| スマホ追従CTA | `.mobile-float-cta` | トップ | 600px以下のみ表示 |
| 届いた声の一覧 | `.wall` / `.voice` | トップ / 声を届ける | 0件時は `.wall-empty` / `.no-voices` |
| 投稿フォーム | `.submit-form`（`voice-form.php`） | 声を届ける / 全ページ右下 | 項目を変えるときはこのファイルだけ直す |
| 声を届けるチャット | `.vc`（`voice-chat.css` / `voice-chat.js`） | 声を届ける | フォームを隠して回答を流し込み、そのまま送信。JSが動かない環境では元のフォームが出る |
| 右下チャットパネル | `.vc-float`（`footer.php`） | /submit/ 以外の全ページ | スマホは全画面、PCは右下 400px。送信後は自動で開いてお礼を表示 |

## 8. ローカル確認手順

```bash
# ローカルに PHP / WordPress 環境は無い（未整備）
# デザイン確認のみ：html/ の各 .html をブラウザで直接開く
# PHP の構文チェックは develop / main への push 時に GitHub Actions で実行される
```

## 9. 公開・デプロイ手順

1. ステージング：`develop` ブランチへ push → PHP構文チェック → `php/` をステージングのテーマフォルダへFTPS転送
   - GitHub Secrets：`STAGING_SERVER_HOST` / `STAGING_SERVER_USER` / `STAGING_SERVER_PASSWORD` / `STAGING_THEME_PATH`
2. 本番：`main` ブランチへ push → PHP構文チェック → 本番テーマフォルダへFTPS転送 → `style.css` の `Version` でリリースノート作成
   - GitHub Secrets：`SERVER_HOST` / `SERVER_USER` / `SERVER_PASSWORD` / `PRODUCTION_THEME_PATH`
3. 新しい固定ページテンプレートを追加したときは、管理画面で固定ページを作ってテンプレートを割り当てる

## 10. 更新手順（非エンジニア向け）

| やりたいこと | 手順 |
|---|---|
| 記事を追加する | 管理画面「投稿」→ 新規追加。タイトル・本文・カテゴリ・アイキャッチ画像を設定して公開 |
| 届いた声を公開する | 管理画面「届いた声」→ 承認待ちの声を開いて「公開」。公開した声がトップ・声を届けるページに出る |
| 画像を差し替える | 記事はアイキャッチ画像で差し替え。テーマ内の画像は `php/images/README.md` の手順 |
| 文言を直す | 固定ページの文言は各 `page-*.php`、チャットの質問文は `voice-chat.js` 冒頭の `topics` と「会話の流れ」 |

## 11. 未決事項 / TODO

- [ ] 本番URL・ステージングURL・担当者連絡先の確定
- [ ] favicon が未設定（`header.php`）
- [ ] GA4 の導入（要件定義書で MUST）
- [ ] 投稿フォームのスパム対策（reCAPTCHA / Turnstile。要件定義書で MUST）
- [ ] トップの実績カウンター（120+ / 45+ / 98%）の数値根拠をクライアントに確認
- [ ] 右下チャットからの送信を WordPress 実機でテスト
- [ ] お問い合わせページ（/contact/）の制作
- [ ] robots.txt / XMLサイトマップの本番確認
- [ ] 要件定義書 Q1〜Q14（政治活動の扱い・運用体制・更新頻度・コミュニティの場 など）の回答
- [ ] 余白・角丸のデザイントークン化

## 12. 素材・共有物

| 種類 | 場所 |
|---|---|
| ロゴ・写真 | `php/images/`（出典：`php/images/PHOTO_CREDITS.md`）。畠中さま撮影写真は未搬入 |
| 原稿 | 未定（記事は WordPress 管理画面） |
| ヒアリングシート | 要件定義書 `php/page-requirements.php`（v1.0 / 2026.05.09） |
