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

    <form class="submit-form" method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
      <?php wp_nonce_field('submit_voice', 'voice_nonce'); ?>
      <input type="hidden" name="action" value="submit_voice">

      <div class="field">
        <label for="voice_body">あなたの声・ご意見 <span class="req">*</span></label>
        <textarea id="voice_body" name="voice_body" placeholder="「この道路の混雑を何とかしてほしい」「こういうイベントがあったら良い」「地域の〇〇で困っている」など何でも歓迎です。" required></textarea>
      </div>

      <div class="row">
        <div class="field">
          <label for="voice_age">年代</label>
          <select id="voice_age" name="voice_age">
            <option value="">選んでください</option>
            <option>10代</option><option>20代</option><option>30代</option>
            <option>40代</option><option>50代</option><option>60代以上</option>
          </select>
        </div>
        <div class="field">
          <label for="voice_area">お住まい</label>
          <select id="voice_area" name="voice_area">
            <option value="">選んでください</option>
            <option>鹿児島市</option><option>姶良市</option><option>霧島市</option>
            <option>鹿屋市</option><option>出水市</option><option>その他県内</option>
            <option>県外</option>
          </select>
        </div>
        <div class="field">
          <label for="voice_name">ニックネーム</label>
          <input type="text" id="voice_name" name="voice_name" placeholder="匿名でもOK">
        </div>
      </div>

      <div class="field">
        <label class="checkbox">
          <input type="checkbox" name="voice_consent" value="1" checked required>
          <span>記事の素材として、抜粋して掲載されることに同意します（個人が特定されない形で）。</span>
        </label>
      </div>

      <?php if ( isset($_GET['error']) ) : ?>
        <div class="form-msg error">内容を入力してから送信してください。</div>
      <?php endif; ?>

      <div class="actions">
        <button type="submit" class="btn btn-cta lg btn-pulse">鹿児島の声を送信する（無料） →</button>
      </div>
    </form>

    <?php if ( isset($_GET['sent']) ) : ?>
      <div class="form-msg success">ありがとうございます。声を受け取りました。必ず読みます。</div>
    <?php endif; ?>
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
