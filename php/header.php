<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="google-site-verification" content="PCK9dbG3aEMN5AvjUiUahyEIjsXTE63ArtvKe-UyMM8" />
<title><?php wp_title('—', true, 'right'); ?><?php bloginfo('name'); ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@400;500;700;900&family=Zen+Old+Mincho:wght@400;500;700;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="siteh">
  <div class="wrap">
    <a class="brand" href="<?php echo esc_url( home_url('/') ); ?>">鹿児島を、語ろう<span class="dot">。</span><small>KAGOSHIMA · KATAROU</small></a>
    <ul class="nav">
      <li><a href="<?php echo esc_url( home_url('/') ); ?>"<?php if ( is_front_page() ) echo ' aria-current="page"'; ?>>HOME</a></li>
      <li><a href="<?php echo esc_url( home_url('/articles/') ); ?>"<?php if ( is_page('articles') ) echo ' aria-current="page"'; ?>>記事</a></li>
      <li><a href="<?php echo esc_url( home_url('/submit/') ); ?>"<?php if ( is_page('submit') ) echo ' aria-current="page"'; ?>>声を届ける</a></li>
      <li><a href="<?php echo esc_url( home_url('/about/') ); ?>"<?php if ( is_page('about') ) echo ' aria-current="page"'; ?>>About</a></li>
    </ul>
  </div>
</header>
