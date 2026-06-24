<?php get_header(); ?>

<main class="wrap">
  <div class="article-grid">
    <article>
      <header class="article-head">
        <div class="breadcrumb">
          <a href="<?php echo esc_url( home_url('/') ); ?>">HOME</a> ／
          <a href="<?php echo esc_url( home_url('/articles/') ); ?>">記事</a> ／
          <span class="current"><?php the_title(); ?></span>
        </div>
        <h1><?php the_title(); ?></h1>
        <div class="byline">
          取材・編集　/　<?php echo esc_html( get_the_date('Y.m.d') ); ?>
          <?php $rt = get_post_meta(get_the_ID(), '_read_time', true); if ($rt) : ?>　·　<?php echo esc_html($rt); ?><?php endif; ?>
        </div>
      </header>

      <?php if ( has_post_thumbnail() ) : ?>
      <figure class="media media-lead article-lead">
        <?php the_post_thumbnail('full', ['width' => '1200', 'height' => '675', 'loading' => 'eager', 'decoding' => 'async']); ?>
        <?php $caption = get_post_meta(get_the_ID(), '_figcaption', true); if ($caption) : ?>
        <figcaption><?php echo esc_html($caption); ?></figcaption>
        <?php endif; ?>
      </figure>
      <?php endif; ?>

      <div class="article-body">
        <?php the_content(); ?>
      </div>

      <footer class="article-foot">
        <div class="reactions">
          <span>共有</span>
          <a href="<?php echo esc_url( home_url('/submit/') ); ?>">声を届ける</a>
        </div>
        <a class="btn" href="<?php echo esc_url( home_url('/submit/') ); ?>">この記事に声を寄せる　→</a>
      </footer>
    </article>

    <aside class="side-rail">
      <div>
        <h4>RELATED</h4>
        <div class="related">
          <?php
          $cats = wp_get_post_categories(get_the_ID());
          $related = new WP_Query([
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'post__not_in'   => [get_the_ID()],
            'category__in'   => $cats,
            'post_status'    => 'publish',
          ]);
          if ( $related->have_posts() ) :
            while ( $related->have_posts() ) : $related->the_post(); ?>
            <a href="<?php the_permalink(); ?>"><div class="card">
              <div class="media media-card">
                <?php if ( has_post_thumbnail() ) : ?>
                  <?php the_post_thumbnail('medium', ['width' => '800', 'height' => '600', 'loading' => 'lazy', 'decoding' => 'async']); ?>
                <?php else : ?>
                  <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/no-image.jpg" alt="" width="800" height="600" loading="lazy" decoding="async">
                <?php endif; ?>
              </div>
              <div class="meta"><span><?php echo esc_html( get_the_date('Y.m.d') ); ?></span></div>
              <h3 class="ttl"><?php the_title(); ?></h3>
            </div></a>
            <?php endwhile;
            wp_reset_postdata();
          endif; ?>
        </div>
      </div>

      <div>
        <h4>SHARE</h4>
        <div class="share-row">
          <?php $url = urlencode(get_permalink()); $title = urlencode(get_the_title()); ?>
          <a href="https://twitter.com/intent/tweet?url=<?php echo $url; ?>&text=<?php echo $title; ?>" target="_blank" rel="noopener"><span class="chip">𝕏 / Twitter</span></a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" target="_blank" rel="noopener"><span class="chip">Facebook</span></a>
          <a href="https://line.me/R/msg/text/?<?php echo $title . '%20' . $url; ?>" target="_blank" rel="noopener"><span class="chip">LINE</span></a>
          <span class="chip" data-copy-url="<?php echo esc_attr(get_permalink()); ?>">URLをコピー</span>
        </div>
      </div>

      <div class="newsletter">
        <div class="lbl">NEWSLETTER</div>
        <h4>続きが届きます。</h4>
        <p>月2回、新しい記事と届いた声のまとめをお届けします。</p>
        <?php echo do_shortcode('[newsletter_form]'); ?>
      </div>
    </aside>
  </div>

  <?php
  $comments = get_comments([
    'post_id' => get_the_ID(),
    'status'  => 'approve',
    'number'  => 10,
  ]);
  if ( $comments ) : ?>
  <section class="comments comments-bleed">
    <div class="wrap">
      <div class="comments-head">
        <h3><span class="stripe"></span>この記事への声 ( <?php echo count($comments); ?> )</h3>
        <a class="btn ghost" href="<?php echo esc_url( home_url('/submit/') ); ?>">声を寄せる　→</a>
      </div>
      <div class="list">
        <?php foreach ($comments as $comment) : ?>
        <div class="voice">
          <?php echo esc_html( $comment->comment_content ); ?>
          <span class="who">— <?php echo esc_html( $comment->comment_author ); ?></span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
