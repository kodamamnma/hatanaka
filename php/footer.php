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
        <li><a href="<?php echo esc_url( home_url('/#about') ); ?>">About</a></li>
        <li><a href="<?php echo esc_url( home_url('/privacy/') ); ?>">プライバシーポリシー</a></li>
      </ul>
    </div>
  </div>
  <div class="wrap copy">
    <div>© <?php echo date('Y'); ?> 鹿児島を、語ろう。</div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
