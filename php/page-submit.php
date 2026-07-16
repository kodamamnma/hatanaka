<?php
/**
 * Template Name: 声を届ける
 */
get_header(); ?>

<section class="submit-hero">
  <div class="wrap">
    <span class="stamp">Your Voice</span>
    <h1>鹿児島で感じていることを、<br>聞かせてください。</h1>
    <p>名前は出さなくていい。違和感、希望、提案、エピソード — 届いた声は、許可をいただいた範囲で記事の素材にします。</p>
  </div>
</section>

<main class="wrap">
  <div class="submit-grid">
    <form class="submit-form" method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
      <?php wp_nonce_field('submit_voice', 'voice_nonce'); ?>
      <input type="hidden" name="action" value="submit_voice">

      <div class="field">
        <label for="voice_body">あなたの声 <span class="req">*</span></label>
        <textarea id="voice_body" name="voice_body" placeholder="怒り、希望、エピソード、思いつき。何でも、そのまま。" required></textarea>
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
        <button type="submit" class="btn lg">声を届ける　→</button>
      </div>
    </form>

    <?php if ( isset($_GET['sent']) ) : ?>
      <div class="form-msg success">ありがとうございます。声を受け取りました。必ず読みます。</div>
    <?php endif; ?>

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
