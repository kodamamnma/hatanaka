<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="google-site-verification" content="PCK9dbG3aEMN5AvjUiUahyEIjsXTE63ArtvKe-UyMM8" />
<title><?php wp_title('—', true, 'right'); ?><?php bloginfo('name'); ?></title>
<?php
$katarou_desc     = katarou_meta_description();
$katarou_title    = katarou_og_title();
$katarou_image    = katarou_og_image();
$katarou_url      = katarou_current_url();
$katarou_is_post  = is_singular('post');
?>
<meta name="description" content="<?php echo esc_attr( $katarou_desc ); ?>">
<link rel="canonical" href="<?php echo esc_url( $katarou_url ); ?>">
<meta property="og:type" content="<?php echo $katarou_is_post ? 'article' : 'website'; ?>">
<meta property="og:site_name" content="<?php bloginfo('name'); ?>">
<meta property="og:title" content="<?php echo esc_attr( $katarou_title ); ?>">
<meta property="og:description" content="<?php echo esc_attr( $katarou_desc ); ?>">
<meta property="og:url" content="<?php echo esc_url( $katarou_url ); ?>">
<meta property="og:image" content="<?php echo esc_url( $katarou_image ); ?>">
<?php if ( $katarou_is_post ) : ?>
<meta property="article:published_time" content="<?php echo esc_attr( get_the_date('c') ); ?>">
<meta property="article:modified_time" content="<?php echo esc_attr( get_the_modified_date('c') ); ?>">
<?php endif; ?>
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo esc_attr( $katarou_title ); ?>">
<meta name="twitter:description" content="<?php echo esc_attr( $katarou_desc ); ?>">
<meta name="twitter:image" content="<?php echo esc_url( $katarou_image ); ?>">
<script type="application/ld+json">
<?php
$katarou_ld = [
    '@context' => 'https://schema.org',
    '@graph'   => [
        [
            '@type' => 'WebSite',
            '@id'   => home_url('/#website'),
            'name'  => get_bloginfo('name'),
            'url'   => home_url('/'),
        ],
    ],
];
if ( $katarou_is_post ) {
    $katarou_ld['@graph'][] = [
        '@type'         => 'Article',
        'headline'      => get_the_title(),
        'description'   => $katarou_desc,
        'image'         => $katarou_image,
        'datePublished' => get_the_date('c'),
        'dateModified'  => get_the_modified_date('c'),
        'author'        => [
            '@type' => 'Person',
            'name'  => get_the_author() ?: '畠中祐介',
        ],
        'publisher'     => [
            '@type' => 'Organization',
            'name'  => get_bloginfo('name'),
        ],
        'mainEntityOfPage' => $katarou_url,
    ];
    $katarou_ld['@graph'][] = [
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            [ '@type' => 'ListItem', 'position' => 1, 'name' => 'HOME', 'item' => home_url('/') ],
            [ '@type' => 'ListItem', 'position' => 2, 'name' => '記事', 'item' => home_url('/articles/') ],
            [ '@type' => 'ListItem', 'position' => 3, 'name' => get_the_title(), 'item' => $katarou_url ],
        ],
    ];
}
echo wp_json_encode( $katarou_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
?>
</script>
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
