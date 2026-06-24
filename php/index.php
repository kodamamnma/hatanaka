<?php get_header(); ?>

<main class="wrap">
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article>
      <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <div class="meta"><span><?php echo esc_html( get_the_date('Y.m.d') ); ?></span></div>
      <p><?php echo esc_html( get_the_excerpt() ); ?></p>
    </article>
  <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>
