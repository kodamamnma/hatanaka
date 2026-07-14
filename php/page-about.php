<?php
/**
 * Template Name: About
 */
get_header(); ?>

<section class="submit-hero">
  <div class="wrap">
    <span class="stamp">About</span>
    <h1>鹿児島を、<br>当事者の言葉で語る場所に。</h1>
    <p>「鹿児島を、語ろう。」は、鹿児島に暮らす人が感じていることを集め、そのまま記事にしていくメディアです。</p>
  </div>
</section>

<main class="wrap">

  <section style="padding:56px 0 0;">
    <div class="section-h">
      <h2><span class="stripe"></span>編集長について</h2>
    </div>
    <div class="about-simple">
      <span class="stamp">畠中 祐介</span>
      <p>
        鹿児島県姶良市在住。東京で12年間、飲食業に携わったのち、コロナ禍を機に鹿児島へ帰郷。現在は地元の病院・給食委託の仕事をしながら、このサイトを運営しています。
      </p>
      <p>
        現場で働くなかで、日々耳にする違和感や困りごとが、なかなか外に届かないことにもどかしさを感じてきました。「鹿児島を、語ろう。」は、そうした声を集め、記事という形で外へ届けるための場所です。
      </p>
    </div>
  </section>

  <section>
    <div class="section-h">
      <h2><span class="stripe"></span>編集方針</h2>
    </div>
    <div class="about-simple">
      <p>
        大切にしているのは「足を運んで、自分で見る」という一次情報主義です。伝聞や推測ではなく、実際に現場へ足を運び、当事者の言葉をできるだけそのまま記事にします。
      </p>
      <p>
        投稿フォームから届いた声は、匿名のままでも構いません。掲載する場合は、個人が特定されない形に配慮したうえで、記事や特集の素材として活用します。
      </p>
    </div>
  </section>

  <section style="padding-bottom:64px;">
    <div class="section-h">
      <h2><span class="stripe"></span>お問い合わせ</h2>
    </div>
    <div class="editor-note">
      <div class="lbl">CONTACT</div>
      <p>
        取材・登壇のご依頼や、サイトへのご意見等は下記までご連絡ください。<br>
        サイト名：鹿児島を、語ろう。<br>
        運営者：畠中祐介<br>
        所在地：鹿児島県姶良市<br>
        お問い合わせ：<a href="mailto:kagoshima_kataro@hatabox126.net">kagoshima_kataro@hatabox126.net</a>
      </p>
    </div>
    <div class="actions" style="display:flex;gap:12px;flex-wrap:wrap;margin-top:20px;">
      <a class="btn" href="<?php echo esc_url( home_url('/submit/') ); ?>">声を届ける　→</a>
      <a class="btn ghost" href="<?php echo esc_url( home_url('/articles/') ); ?>">記事を読む　→</a>
    </div>
  </section>

</main>

<?php get_footer(); ?>
