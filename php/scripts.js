/* ─────────────────────────────────────────────
   鹿児島を、語ろう。 — interactions
   ───────────────────────────────────────────── */

/* Submit form: stub handler (replaced when backend connected) */
(function initSubmitForm(){
  const form = document.querySelector('.submit-form');
  if(!form) return;
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    alert('プロトタイプ：実際の送信処理は接続後に動作します');
  });
})();
