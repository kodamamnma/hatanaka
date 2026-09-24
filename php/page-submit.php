<?php
/**
 * Template Name: 声を届ける
 */
get_header(); ?>

<section class="submit-hero">
  <div class="wrap">
    <div class="badge-cro dark">🔒 完全匿名OK · 所要時間 約1分 · 秘密厳守</div>
    <h1>鹿児島で感じている違和感・希望を、<br>直接メディアに届ける。</h1>
    <p>名前や個人情報の登録は一切不要。日常のちょっとした違和感、希望、提案、体験エピソードを気軽にお書きください。</p>
  </div>
</section>

<main class="wrap">
  <div class="submit-grid">
    <!-- ▼ 投稿エリア（voice-chat.js がこの中にチャットを差し込むため、左カラムを1つの要素にまとめる） -->
    <div class="submit-main">
      <div class="form-trust-badges">
        <span class="tb-item">🛡️ 匿名での投稿OK</span>
        <span class="tb-item">⚡ 入力目安 1分</span>
        <span class="tb-item">🔒 個人特定はありません</span>
      </div>

    <?php get_template_part('voice-form'); ?>
    </div>

    <aside class="submit-side">
      <h4>最近届いた声</h4>
      <div class="recent">
        <?php
        $voices = new WP_Query([
          'post_type'      => 'voice',
          'posts_per_page' => 4,
          'post_status'    => 'publish',
        ]);
        if ( $voices->have_posts() ) :
          while ( $voices->have_posts() ) : $voices->the_post(); ?>
          <div class="voice">
            <?php the_content(); ?>
            <span class="who">— <?php echo esc_html( get_post_meta(get_the_ID(), '_voice_who', true) ); ?></span>
          </div>
          <?php endwhile;
          wp_reset_postdata();
        else : ?>
          <p class="no-voices">あなたの声をお待ちしています。</p>
        <?php endif; ?>
      </div>

      <div class="editor-note">
        <div class="lbl">NOTE</div>
        <p>
          届いた声は一通ずつ目を通し、記事化の可否を確認します。返信できないこともありますが、必ず読んでいます。
        </p>
      </div>
    </aside>
  </div>
</main>

<?php get_footer(); ?>
