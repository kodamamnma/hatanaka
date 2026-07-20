<?php

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('katarou-style', get_stylesheet_uri(), [], '1.0');
    wp_enqueue_script('katarou-scripts', get_template_directory_uri() . '/scripts.js', [], '1.0', true);
});

// 声の投稿フォーム処理
add_action('admin_post_nopriv_submit_voice', 'katarou_handle_voice_submit');
add_action('admin_post_submit_voice', 'katarou_handle_voice_submit');

function katarou_handle_voice_submit() {
    if ( ! isset($_POST['voice_nonce']) || ! wp_verify_nonce($_POST['voice_nonce'], 'submit_voice') ) {
        wp_die('不正なリクエストです。');
    }

    $body = sanitize_textarea_field($_POST['voice_body'] ?? '');
    if ( empty($body) ) {
        wp_redirect( add_query_arg('error', '1', wp_get_referer()) );
        exit;
    }

    $age  = sanitize_text_field($_POST['voice_age']  ?? '');
    $area = sanitize_text_field($_POST['voice_area'] ?? '');
    $name = sanitize_text_field($_POST['voice_name'] ?? '') ?: '匿名';
    $who  = implode(' / ', array_filter([$age, $area]));

    $post_id = wp_insert_post([
        'post_type'    => 'voice',
        'post_status'  => 'pending',
        'post_title'   => mb_substr($body, 0, 30),
        'post_content' => $body,
        'post_author'  => 1,
    ]);

    if ( $post_id && ! is_wp_error($post_id) ) {
        update_post_meta($post_id, '_voice_who', $who ? "{$name} / {$who}" : $name);
        // 管理者へメール通知
        wp_mail(
            get_option('admin_email'),
            '【鹿児島を、語ろう。】新しい声が届きました',
            "名前: {$name}\n年代・地域: {$who}\n\n{$body}\n\n管理画面: " . admin_url('edit.php?post_type=voice')
        );
    }

    wp_redirect( add_query_arg('sent', '1', wp_get_referer()) );
    exit;
}

// カスタム投稿タイプ「voice」の登録
add_action('init', function () {
    register_post_type('voice', [
        'labels'        => ['name' => '届いた声', 'singular_name' => '声'],
        'public'        => true,
        'show_in_menu'  => true,
        'supports'      => ['title', 'editor'],
        'menu_icon'     => 'dashicons-format-quote',
    ]);
});

// SEO: meta description
function katarou_meta_description() {
    if ( is_singular() ) {
        $excerpt = get_the_excerpt();
        if ( $excerpt ) {
            return wp_strip_all_tags( $excerpt );
        }
    }
    $tagline = get_bloginfo('description');
    return $tagline ?: '鹿児島に住む人の声を集め、そのまま記事にしていくメディア「鹿児島を、語ろう。」です。';
}

// SEO: OGP用タイトル
function katarou_og_title() {
    return is_singular() ? get_the_title() : get_bloginfo('name');
}

// SEO: OGP/カード用の画像URL
function katarou_og_image() {
    if ( is_singular() && has_post_thumbnail() ) {
        return get_the_post_thumbnail_url( get_the_ID(), 'large' );
    }
    return get_template_directory_uri() . '/images/no-image.jpg';
}

// SEO: 現在URL（正規化用）
function katarou_current_url() {
    return is_singular() ? get_permalink() : home_url( add_query_arg( null, null ) );
}
