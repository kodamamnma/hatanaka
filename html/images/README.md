# 記事用画像の置き方

## フォルダ構成

```
images/
├── articles/          … 記事ごとの写真（本文・リード）
│   └── 2026-03-30-aira-station/
│       ├── lead.jpg           … 記事トップの大きい画像
│       └── shopping-street.jpg … 本文中の画像
└── thumbs/            … 一覧・カード用（小さめでOK）
    ├── traffic.jpg
    ├── food-work.jpg
    └── ...
```

## ファイル形式

- **JPG または WebP** を推奨（ファイル名は英数字とハイフン）
- リード画像: 横 1200px 前後（16:9）
- カード用: 横 800px 前後（4:3）
- 容量: 1枚 200〜500KB 程度に圧縮すると表示が速い

## HTML への挿入

### 記事のメイン画像（リード）

```html
<figure class="media media-lead">
  <img src="images/articles/2026-03-30-aira-station/lead.jpg" alt="姶良駅前の風景" width="1200" height="675" loading="eager" decoding="async">
  <figcaption>姶良駅前 · 取材当日</figcaption>
</figure>
```

### 本文の途中

```html
<figure class="media">
  <img src="images/articles/2026-03-30-aira-station/shopping-street.jpg" alt="商店街" width="1200" height="675" loading="lazy" decoding="async">
  <figcaption>駅前の商店街。空き店についての声が多かった。</figcaption>
</figure>
```

### 一覧・カード

```html
<div class="media media-card">
  <img src="images/thumbs/traffic.jpg" alt="" width="800" height="600" loading="lazy" decoding="async">
</div>
```

`alt` には写真の内容を短く書く（装飾だけの場合は空でも可）。

## いま表示している画像

ウェブ検索で **Pixabay / Pexels**（商用利用可）から選び、一部は `images/` に保存済みです。出典は `PHOTO_CREDITS.md` を参照してください。

| 保存済み（オフライン可） | CDN 参照（要ネット） |
|--------------------------|----------------------|
| `lead.jpg` | `shopping-street`（Pexels） |
| `food-work.jpg` | `traffic.jpg`（Pexels） |
| `voices.jpg` | `dialogue.jpg`（Pexels） |

## 差し替え手順

1. [O-DAN](https://o-dan.net/ja/) でキーワード検索 → 気に入った写真を元サイトからダウンロード
2. `images/articles/...` または `images/thumbs/` に保存
3. HTML の `src` を `images/.../ファイル名.jpg` に変更
4. `PHOTO_CREDITS.md` に出典を1行追加
