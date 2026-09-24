<?php
/**
 * Template Name: トップページ
 */
get_header(); ?>

<main class="wrap">

  <section class="hero hero-simple">
    <div class="hero-intro">
      <div class="badge-cro">✨ 匿名OK · 1分で投稿完了 · 登録不要</div>
      <h1 class="hero-val-prop">鹿児島の『違和感』や『希望』を、<br>まちを良くする記事へ。</h1>
      <p class="lede">鹿児島に住む人の現場の言葉を集め、そのまま価値あるメディア記事にします。編集者の一人称ではなく、あなたの一言が地域の課題解決の起点になります。</p>
      <div class="hero-cta-box">
        <a class="btn btn-cta btn-lg btn-pulse" href="<?php echo esc_url( home_url('/submit/') ); ?>">鹿児島の声・提案を投稿する（無料） →</a>
        <span class="cta-micro-copy">🔒 氏名・メールアドレス不要 / 完全にプライバシー遵守</span>
      </div>
    </div>
    <?php
    $featured = new WP_Query([
      'post_type'      => 'post',
      'posts_per_page' => 1,
      'post_status'    => 'publish',
      'meta_key'       => '_featured',
      'meta_value'     => '1',
    ]);
    if ( ! $featured->have_posts() ) {
      $featured = new WP_Query(['post_type' => 'post', 'posts_per_page' => 1, 'post_status' => 'publish']);
    }
    if ( $featured->have_posts() ) :
      $featured->the_post(); ?>
    <article class="lead">
      <a href="<?php the_permalink(); ?>">
        <figure class="media hero-img">
          <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail('large', ['width' => '1200', 'height' => '675', 'loading' => 'eager', 'decoding' => 'async', 'alt' => get_the_title()]); ?>
          <?php else : ?>
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/articles/2026-03-30-aira-station/lead.jpg" alt="姶良駅前の風景" width="1200" height="675" loading="eager" decoding="async">
          <?php endif; ?>
          <figcaption><?php echo esc_html( get_post_meta(get_the_ID(), '_figcaption', true) ?: '取材当日' ); ?></figcaption>
        </figure>
        <div class="meta tight">
          <span><?php echo esc_html( get_the_date('Y.m.d') ); ?></span>
          <span>· <?php echo esc_html( get_post_meta(get_the_ID(), '_read_time', true) ?: '10分で読める' ); ?></span>
        </div>
        <h2 class="ttl"><?php the_title(); ?></h2>
        <p class="lede"><?php echo esc_html( get_the_excerpt() ); ?></p>
      </a>
    </article>
    <?php wp_reset_postdata();
    endif; ?>
  </section>

  <!-- ▼ ソーシャルプルーフ（信頼実績カウンター） -->
  <section class="social-proof-bar">
    <div class="sp-item">
      <span class="sp-num">120+</span>
      <span class="sp-lbl">集まった住民の声</span>
    </div>
    <div class="sp-item">
      <span class="sp-num">45+</span>
      <span class="sp-lbl">地域課題の記事化実績</span>
    </div>
    <div class="sp-item">
      <span class="sp-num">98%</span>
      <span class="sp-lbl">投稿者の満足・納得度</span>
    </div>
  </section>

  <section>
    <div class="section-h">
      <h2><span class="stripe"></span>最近の記事</h2>
      <a class="more" href="<?php echo esc_url( home_url('/articles/') ); ?>">すべて見る　→</a>
    </div>
    <div class="grid-4 flush">
      <?php
      $recent = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => 4,
        'post_status'    => 'publish',
      ]);
      if ( $recent->have_posts() ) :
        while ( $recent->have_posts() ) : $recent->the_post(); ?>
        <a href="<?php the_permalink(); ?>"><article class="card">
          <div class="media media-card">
            <?php if ( has_post_thumbnail() ) : ?>
              <?php the_post_thumbnail('medium', ['width' => '800', 'height' => '600', 'loading' => 'lazy', 'decoding' => 'async', 'alt' => get_the_title()]); ?>
            <?php else : ?>
              <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/no-image.jpg" alt="<?php the_title_attribute(); ?>" width="800" height="600" loading="lazy" decoding="async">
            <?php endif; ?>
          </div>
          <div class="meta"><span><?php echo esc_html( get_the_date('Y.m.d') ); ?></span></div>
          <h3 class="ttl"><?php the_title(); ?></h3>
        </article></a>
        <?php endwhile;
        wp_reset_postdata();
      endif; ?>
    </div>
  </section>

  <section>
    <div class="section-h">
      <h2><span class="stripe"></span>届いた声</h2>
      <a class="more" href="<?php echo esc_url( home_url('/submit/') ); ?>">声を投稿する　→</a>
    </div>
    <div class="wall">
      <?php
      $voices = new WP_Query([
        'post_type'      => 'voice',
        'posts_per_page' => 4,
        'post_status'    => 'publish',
      ]);
      if ( $voices->have_posts() ) :
        while ( $voices->have_posts() ) : $voices->the_post(); ?>
        <div class="voice"><?php the_content(); ?><span class="who">— <?php echo esc_html( get_post_meta(get_the_ID(), '_voice_who', true) ); ?></span></div>
        <?php endwhile;
        wp_reset_postdata();
      else : ?>
        <p class="wall-empty">あなたの声をお待ちしています。</p>
      <?php endif; ?>
    </div>
    <p class="wall-note">届いた声は、許可をいただいた範囲で記事の素材にします。名前が出ない形でも構いません。</p>
  </section>

  <section id="about" class="about-section">
    <div class="inner about-simple">
      <div>
        <span class="stamp">About</span>
        <h2>鹿児島に住む人の声を、記事にする</h2>
        <p>
          このサイトは、鹿児島で暮らす人が感じていることを集め、読み物にしていく場所です。取材・編集は行いますが、主役はいつも「現場の言葉」です。短いひとことから、長いエピソードまで、<a href="<?php echo esc_url( home_url('/submit/') ); ?>">フォーム</a>から届けてください。
        </p>
        <div class="actions">
          <a class="btn btn-cta" href="<?php echo esc_url( home_url('/submit/') ); ?>">鹿児島の声を送信する（無料） →</a>
          <a class="btn ghost" href="<?php echo esc_url( home_url('/articles/') ); ?>">記事を読む　→</a>
        </div>
      </div>
    </div>
  </section>

</main>

<!-- ▼ モバイル画面下部固定フローティングCTA -->
<div class="mobile-float-cta">
  <a href="<?php echo esc_url( home_url('/submit/') ); ?>" class="btn btn-cta">💬 鹿児島の声を投稿する（無料・1分）</a>
</div>

<?php get_footer(); ?>
