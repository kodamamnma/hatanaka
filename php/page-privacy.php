<?php
/**
 * Template Name: プライバシーポリシー
 */
?><!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>プライバシーポリシー — 鹿児島を、語ろう。</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@400;500;700;900&family=Zen+Old+Mincho:wght@500;700;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<style>
  :root{
    --bg:#fafaf7;--paper:#fff;--bg-2:#f4eedf;--bg-3:#ebe3d0;
    --ink:#14110d;--ink-2:#4a4038;--mute:#8a7f72;
    --line:#e6dfd0;--line-2:#cbc1ad;
    --red:#7a1018;--red-deep:#5a0a12;--red-pale:#f3dadd;
    --mincho:'Zen Old Mincho',serif;
    --gothic:'Zen Kaku Gothic New','Hiragino Kaku Gothic ProN',sans-serif;
    --mono:'Space Mono',monospace;
  }
  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}
  body{background:var(--bg);color:var(--ink);font-family:var(--gothic);font-size:14.5px;line-height:1.85;-webkit-font-smoothing:antialiased;}
  .wrap{max-width:800px;margin:0 auto;padding:0 32px;}
  a{color:var(--red);text-decoration:none;border-bottom:1px solid var(--red-pale);}
  a:hover{background:var(--red-pale);}

  /* ヘッダー */
  .cover{background:var(--ink);color:#fff;padding:60px 0 50px;border-bottom:6px solid var(--red);}
  .cover .stamp{display:inline-block;font-family:var(--mono);font-size:11px;color:#f3c0c4;border:1.5px solid #f3c0c4;padding:3px 10px;letter-spacing:.18em;font-weight:700;}
  .cover h1{font-family:var(--mincho);font-weight:900;font-size:42px;margin:18px 0 8px;line-height:1.2;letter-spacing:-.005em;}
  .cover .sub{font-family:var(--mono);font-size:12px;color:#9d9486;margin:0;letter-spacing:.08em;}

  /* 本文エリア */
  .body{padding:56px 0 80px;}

  /* 目次 */
  .toc{background:var(--bg-2);border:1px solid var(--line-2);padding:22px 26px;margin-bottom:48px;}
  .toc h4{font-family:var(--mono);font-size:11px;letter-spacing:.18em;color:var(--red);margin:0 0 10px;font-weight:700;}
  .toc ol{margin:0;padding-left:1.2em;font-family:var(--mincho);font-size:14.5px;}
  .toc ol li{margin-bottom:5px;}
  .toc ol li a{color:var(--ink);border:none;}
  .toc ol li a:hover{color:var(--red);background:none;}

  /* 各セクション */
  .sec{padding:40px 0;border-bottom:1px solid var(--line);}
  .sec:last-of-type{border-bottom:none;}
  .sec h2{font-family:var(--mincho);font-weight:900;font-size:24px;margin:0 0 16px;border-left:5px solid var(--red);padding-left:14px;line-height:1.35;}
  .sec h2 .num{font-family:var(--mono);font-size:11px;color:var(--red);margin-right:12px;letter-spacing:.18em;vertical-align:4px;font-weight:700;}
  .sec p{margin:0 0 14px;color:var(--ink-2);}
  .sec p:last-child{margin-bottom:0;}
  .sec ul{margin:10px 0 14px;padding-left:1.3em;color:var(--ink-2);}
  .sec ul li{margin-bottom:6px;}

  /* コールアウト */
  .call{background:var(--bg-2);border:1px solid var(--line-2);border-left:4px solid var(--red);padding:18px 22px;margin:20px 0;}
  .call h4{font-family:var(--mono);font-size:11px;letter-spacing:.18em;color:var(--red);margin:0 0 6px;font-weight:700;}
  .call p{margin:0;font-size:14px;line-height:1.85;color:var(--ink);}

  /* 改定履歴テーブル */
  table{width:100%;border-collapse:collapse;background:var(--paper);border:1px solid var(--line-2);font-size:13.5px;margin:14px 0 0;}
  th,td{border-bottom:1px solid var(--line);padding:10px 14px;text-align:left;vertical-align:top;line-height:1.7;}
  th{background:var(--bg-2);font-weight:700;font-family:var(--mono);font-size:11px;letter-spacing:.1em;color:var(--ink-2);}
  tr:last-child td{border-bottom:none;}

  /* フッター */
  footer.foot{background:var(--ink);color:#9d9486;padding:30px 0;font-family:var(--mono);font-size:11px;letter-spacing:.08em;}
  footer.foot .wrap-full{max-width:1080px;margin:0 auto;padding:0 32px;display:flex;justify-content:space-between;flex-wrap:wrap;gap:14px;}
  footer.foot a{color:#f3c0c4;border:none;}

  @media(max-width:600px){
    .cover h1{font-size:30px;}
    .wrap{padding:0 20px;}
  }
</style>
<?php wp_head(); ?>
</head>
<body>

<header class="cover">
  <div class="wrap">
    <span class="stamp">PRIVACY POLICY · 個人情報保護方針</span>
    <h1>プライバシー<br>ポリシー</h1>
    <p class="sub">最終改定：2026年6月24日</p>
  </div>
</header>

<div class="wrap body">

  <div class="toc">
    <h4>CONTENTS · 目次</h4>
    <ol>
      <li><a href="#s1">基本方針</a></li>
      <li><a href="#s2">収集する情報</a></li>
      <li><a href="#s3">情報の利用目的</a></li>
      <li><a href="#s4">第三者への提供</a></li>
      <li><a href="#s5">情報の管理・安全対策</a></li>
      <li><a href="#s6">Cookieとアクセス解析</a></li>
      <li><a href="#s7">投稿・意見フォームについて</a></li>
      <li><a href="#s8">開示・訂正・削除の請求</a></li>
      <li><a href="#s9">ポリシーの変更</a></li>
      <li><a href="#s10">お問い合わせ</a></li>
    </ol>
  </div>

  <section class="sec" id="s1">
    <h2><span class="num">01</span>基本方針</h2>
    <p>「鹿児島を、語ろう。」（以下「当サイト」）は、鹿児島県内の課題や魅力を発信し、住民の声を集めるオウンドメディアです。当サイトを運営するにあたり、ご利用者の個人情報を適切に保護することを重要な責務と認識しています。</p>
    <p>当サイトは個人情報の保護に関する法律（個人情報保護法）を遵守し、以下の方針に基づいて個人情報を取り扱います。</p>
  </section>

  <section class="sec" id="s2">
    <h2><span class="num">02</span>収集する情報</h2>
    <p>当サイトでは、以下の情報を収集する場合があります。</p>
    <ul>
      <li>お名前・ニックネーム（任意）</li>
      <li>メールアドレス（お問い合わせ時）</li>
      <li>年代・居住地域（意見投稿フォーム内、任意）</li>
      <li>ご意見・ご投稿の内容</li>
      <li>IPアドレス、ブラウザ情報（アクセスログとして自動取得）</li>
      <li>Cookie等の識別情報</li>
    </ul>
    <div class="call">
      <h4>匿名投稿について</h4>
      <p>意見投稿フォームへの投稿はニックネームでも構いません。氏名・メールアドレスは任意項目です。投稿内容を記事に掲載する際は、掲載前にご確認をお願いする場合があります。</p>
    </div>
  </section>

  <section class="sec" id="s3">
    <h2><span class="num">03</span>情報の利用目的</h2>
    <p>収集した情報は、以下の目的にのみ使用します。</p>
    <ul>
      <li>お問い合わせへの返信・対応</li>
      <li>投稿内容の確認・モデレーション</li>
      <li>記事・コンテンツへの掲載（ご同意を得た場合）</li>
      <li>サービスの改善・新機能の開発</li>
      <li>イベント・タウンミーティングの案内（ご希望者のみ）</li>
      <li>サイト利用状況の統計分析（個人を特定しない形で）</li>
      <li>スパム・不正アクセスの防止</li>
      <li>法令上の義務への対応</li>
    </ul>
  </section>

  <section class="sec" id="s4">
    <h2><span class="num">04</span>第三者への提供</h2>
    <p>当サイトは、以下の場合を除き、ご本人の同意なく個人情報を第三者に提供しません。</p>
    <ul>
      <li>法令に基づく場合</li>
      <li>人の生命・身体・財産の保護のために必要がある場合</li>
      <li>公衆衛生の向上または児童の健全育成のために必要な場合</li>
      <li>国の機関または地方公共団体が法令の定める事務を遂行する上で必要な場合</li>
    </ul>
    <p>なお、当サイトはGoogle Analytics（Google LLC）によるアクセス解析を利用しています。Googleのデータ収集・利用については、<a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Googleプライバシーポリシー</a>をご参照ください。</p>
  </section>

  <section class="sec" id="s5">
    <h2><span class="num">05</span>情報の管理・安全対策</h2>
    <p>当サイトは、収集した個人情報の漏洩・紛失・改ざん・不正アクセスを防止するために、以下の対策を実施しています。</p>
    <ul>
      <li>SSL/TLS による通信の暗号化（HTTPS）</li>
      <li>管理画面へのアクセス制限・二段階認証</li>
      <li>定期的なデータバックアップ（日次）</li>
      <li>スパム対策（reCAPTCHA等）</li>
    </ul>
  </section>

  <section class="sec" id="s6">
    <h2><span class="num">06</span>Cookieとアクセス解析</h2>
    <p>当サイトはCookieを使用しています。Cookieはブラウザに保存される小さなデータファイルで、サイトの利便性向上や利用状況の把握に使用します。ブラウザの設定でCookieを無効にすることができますが、一部機能が利用できなくなる場合があります。</p>
    <p>アクセス解析にはGoogle Analytics（GA4）を使用しています。収集されるデータはIPアドレスが匿名化されており、個人を特定しない統計情報として利用します。</p>
  </section>

  <section class="sec" id="s7">
    <h2><span class="num">07</span>投稿・意見フォームについて</h2>
    <p>「声を届ける」フォームから送信された投稿内容は、当サイト運営者が内容を確認のうえ、モデレーションを行います。</p>
    <ul>
      <li>投稿内容は、記事・コンテンツへの掲載にあたってご本人の確認をお願いする場合があります</li>
      <li>掲載の際は、個人が特定されないよう適切に加工します</li>
      <li>誹謗中傷・差別的表現・不適切と判断された投稿は非公開とします</li>
      <li>投稿内容の二次利用（記事化・SNS共有等）については、投稿フォーム内の同意事項でご確認いただきます</li>
    </ul>
  </section>

  <section class="sec" id="s8">
    <h2><span class="num">08</span>開示・訂正・削除の請求</h2>
    <p>当サイトが保有する個人情報について、ご本人から開示・訂正・利用停止・削除の請求があった場合は、速やかに対応します。ご本人確認のうえ、合理的な期間内（原則14日以内）に書面またはメールにてご回答します。</p>
    <p>ご請求は下記お問い合わせ先までご連絡ください。</p>
  </section>

  <section class="sec" id="s9">
    <h2><span class="num">09</span>ポリシーの変更</h2>
    <p>当サイトは、法令の改正やサービス内容の変更に伴い、本プライバシーポリシーを改定することがあります。改定後のポリシーは、本ページに掲載した時点から効力を生じます。重要な変更がある場合はサイト上でお知らせします。</p>

    <table>
      <tr><th>改定日</th><th>内容</th></tr>
      <tr><td>2026年6月24日</td><td>初版制定</td></tr>
    </table>
  </section>

  <section class="sec" id="s10">
    <h2><span class="num">10</span>お問い合わせ</h2>
    <p>本ポリシーに関するお問い合わせ、個人情報の開示・訂正・削除のご請求は、以下までご連絡ください。</p>
    <div class="call">
      <h4>CONTACT · 運営者情報</h4>
      <p>
        サイト名：鹿児島を、語ろう。<br>
        運営者：畠中祐介<br>
        所在地：鹿児島県姶良市<br>
        お問い合わせ：<a href="mailto:kagoshima_kataro@hatabox126.net">kagoshima_kataro@hatabox126.net</a>
      </p>
    </div>
  </section>

</div>

<footer class="foot">
  <div class="wrap-full">
    <div>PRIVACY POLICY — 鹿児島を、語ろう。</div>
    <div><a href="<?php echo esc_url( home_url('/') ); ?>">← トップへ戻る</a></div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
