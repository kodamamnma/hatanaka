<footer class="foot">
  <div class="wrap">
    <div>
      <div class="brand">鹿児島を、語ろう<span class="dot">。</span><small>KAGOSHIMA · KATAROU</small></div>
      <p>鹿児島に住む人の声から、記事をつくるメディア。</p>
    </div>
    <div>
      <h5>サイト</h5>
      <ul>
        <li><a href="<?php echo esc_url( home_url('/articles/') ); ?>">記事一覧</a></li>
        <li><a href="<?php echo esc_url( home_url('/submit/') ); ?>">声を届ける</a></li>
        <li><a href="<?php echo esc_url( home_url('/about/') ); ?>">About</a></li>
        <li><a href="<?php echo esc_url( home_url('/privacy/') ); ?>">プライバシーポリシー</a></li>
      </ul>
    </div>
  </div>
  <div class="wrap copy">
    <div>© <?php echo date('Y'); ?> 鹿児島を、語ろう。</div>
  </div>
</footer>

<?php if ( ! is_page_template('page-submit.php') ) : // 投稿ページはページ内にチャットがあるので出さない ?>
<!-- ▼ 声を届けるチャット（全ページ右下） -->
<div class="vc-float">
  <button type="button" class="vc-float__launcher" aria-expanded="false" aria-controls="vc-float-panel">
    <svg class="vc-float__icon" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" focusable="false"><path d="M4 4h16v12H8l-4 4z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
    <span>声を届ける</span>
  </button>
  <div class="vc-float__panel" id="vc-float-panel" role="dialog" aria-label="声を届けるチャット" hidden>
    <div class="vc-float__bar">
      <span class="vc-float__title">声を届ける（匿名OK・約1分）</span>
      <button type="button" class="vc-float__close" aria-label="チャットを閉じる">×</button>
    </div>
    <div class="vc-float__body">
      <?php get_template_part('voice-form'); ?>
    </div>
  </div>
</div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
