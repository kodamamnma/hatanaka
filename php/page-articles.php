<?php
/**
 * Template Name: 記事一覧
 */
get_header(); ?>

<main class="wrap">

  <section class="list-head">
    <div class="row">
      <div>
        <span class="stamp dark">記事一覧</span>
        <h1>記事を読む</h1>
      </div>
      <div class="meta-right">
        住んでいる人の声からつくった記事<br>
        <span class="dim">並び順: 新着 ▾</span>
      </div>
    </div>
  </section>

  <section>
    <?php
    $paged = get_query_var('paged') ?: 1;
    $posts = new WP_Query([
      'post_type'      => 'post',
      'posts_per_page' => 9,
      'paged'          => $paged,
      'post_status'    => 'publish',
    ]);
    $num = $posts->found_posts;
    $i   = $num - ( ($paged - 1) * 9 );

    if ( $posts->have_posts() ) :
      while ( $posts->have_posts() ) : $posts->the_post(); ?>
      <a href="<?php the_permalink(); ?>"><div class="list-row">
        <div class="num"><?php echo str_pad($i--, 2, '0', STR_PAD_LEFT); ?></div>
        <div class="media media-row">
          <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail([800, 500], ['loading' => 'lazy', 'decoding' => 'async', 'alt' => get_the_title()]); ?>
          <?php else : ?>
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/no-image.jpg" alt="<?php the_title_attribute(); ?>" width="800" height="500" loading="lazy" decoding="async">
          <?php endif; ?>
        </div>
        <div class="body">
          <div class="meta">
            <span><?php echo esc_html( get_the_date('Y.m.d') ); ?></span>
            <?php $rt = get_post_meta(get_the_ID(), '_read_time', true); if ($rt) : ?><span>· <?php echo esc_html($rt); ?></span><?php endif; ?>
          </div>
          <h3><?php the_title(); ?></h3>
          <p><?php echo esc_html( get_the_excerpt() ); ?></p>
        </div>
        <div class="actions"><span class="btn ghost">読む　→</span></div>
      </div></a>
      <?php endwhile;
      wp_reset_postdata();
    endif; ?>
  </section>

  <?php if ( $posts->max_num_pages > 1 ) : ?>
  <div class="pager">
    <?php
    for ( $p = 1; $p <= $posts->max_num_pages; $p++ ) :
      $active = ($p === $paged) ? ' solid' : '';
      $url    = get_pagenum_link($p);
      echo '<a href="' . esc_url($url) . '"><span class="chip' . $active . '">' . $p . '</span></a>';
    endfor;
    if ( $paged < $posts->max_num_pages ) :
      echo '<a href="' . esc_url( get_pagenum_link($paged + 1) ) . '"><span class="chip">→</span></a>';
    endif;
    ?>
  </div>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
