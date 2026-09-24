<?php
/**
 * 声の投稿フォーム（/submit/ ページと、全ページ右下のチャットパネルで共用）
 * voice-chat.js はこのフォームを見つけてチャットに置き換える。項目を変えるときはここだけ直す。
 */
?>
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
