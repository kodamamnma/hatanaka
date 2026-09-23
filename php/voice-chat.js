/*!
 * voice-chat.js — 「鹿児島を、語ろう。」声を届けるチャット
 *
 * 既存の投稿フォーム（/submit/）をそのまま使い、チャットで集めた回答を
 * フォームの各項目に入れて送信する。送信処理・保存先・「届いた声」の表示は変更しない。
 *
 * 設定を変えたいときは、このファイルより前に window.VoiceChatConfig = {...} を置く。
 */
(function () {
  'use strict';

  var DEFAULTS = {
    topics: [
      { label: '違和感・困りごと', tag: '違和感', followup: 'それを感じたのは、どんな場面でしたか？' },
      { label: '希望・やってみたいこと', tag: '希望', followup: 'それが実現したら、まちの何が変わりそうですか？' },
      { label: 'まちへの提案', tag: '提案', followup: '誰に、どう動いてほしいですか？' },
      { label: 'エピソード・体験', tag: 'エピソード', followup: 'そのとき、どんな気持ちになりましたか？' },
      { label: '記事の感想', tag: '感想', followup: 'どの記事についてですか？ 印象に残ったところも教えてください。' },
      { label: 'その他', tag: '', followup: 'もう少し詳しく聞かせてもらえますか？' }
    ],
    prefixTopic: true,          // 声の先頭に［希望］のようなテーマを付ける
    typingDelay: 550,           // 返信までの間（ミリ秒）
    storageKey: 'vc-draft-v1',
    articlesUrl: '/articles/'
  };
  var CFG = Object.assign({}, DEFAULTS, window.VoiceChatConfig || {});

  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ------------------------------------------------------------------ */
  /* 既存フォームの読み取り                                                */
  /* ------------------------------------------------------------------ */
  function findForm() {
    var el = document.querySelector('form.submit-form') ||
             document.querySelector('.submit-form form') ||
             document.querySelector('.submit-form');
    if (el && el.tagName !== 'FORM') el = el.closest('form') || el.querySelector('form');
    if (el) return el;
    var forms = document.querySelectorAll('form');
    for (var i = 0; i < forms.length; i++) if (forms[i].querySelector('textarea')) return forms[i];
    return null;
  }

  function optionTexts(select) {
    var out = [];
    Array.prototype.forEach.call(select.options, function (o) {
      var t = (o.textContent || '').trim();
      if (!o.value || /選んで|選択/.test(t)) return;
      out.push({ label: t, value: o.value });
    });
    return out;
  }

  function mapFields(form) {
    var f = {
      form: form,
      voice: form.querySelector('textarea'),
      age: null, area: null,
      nickname: null,
      consent: form.querySelector('input[type="checkbox"]'),
      submit: form.querySelector('[type="submit"]') || form.querySelector('button:not([type="button"])')
    };
    Array.prototype.forEach.call(form.querySelectorAll('select'), function (s) {
      var txt = s.textContent || '';
      if (!f.age && /10代|20代|60代/.test(txt)) f.age = s;
      else if (!f.area && /鹿児島市|県外|県内/.test(txt)) f.area = s;
    });
    var texts = form.querySelectorAll('input[type="text"], input:not([type])');
    for (var i = 0; i < texts.length; i++) {
      var inp = texts[i];
      var hint = (inp.name + ' ' + inp.id + ' ' + inp.placeholder + ' ' + labelOf(inp)).toLowerCase();
      if (/nick|name|ニックネーム|名前/.test(hint)) { f.nickname = inp; break; }
    }
    if (!f.nickname && texts.length) f.nickname = texts[texts.length - 1];
    return f;
  }

  function labelOf(el) {
    if (el.id) {
      var l = document.querySelector('label[for="' + el.id + '"]');
      if (l) return l.textContent || '';
    }
    var p = el.closest('.field, label, p, div');
    return p ? (p.textContent || '') : '';
  }

  function setValue(el, value) {
    if (!el) return;
    el.value = value;
    el.dispatchEvent(new Event('input', { bubbles: true }));
    el.dispatchEvent(new Event('change', { bubbles: true }));
  }

  /* ------------------------------------------------------------------ */
  /* 下書き（ページ再読み込みをまたいで保持）                              */
  /* ------------------------------------------------------------------ */
  function saveDraft(d) { try { sessionStorage.setItem(CFG.storageKey, JSON.stringify(d)); } catch (e) {} }
  function loadDraft() { try { return JSON.parse(sessionStorage.getItem(CFG.storageKey) || 'null'); } catch (e) { return null; } }
  function clearDraft() { try { sessionStorage.removeItem(CFG.storageKey); } catch (e) {} }

  /* ------------------------------------------------------------------ */
  /* UI                                                                   */
  /* ------------------------------------------------------------------ */
  function h(tag, attrs, children) {
    var el = document.createElement(tag);
    if (attrs) Object.keys(attrs).forEach(function (k) {
      if (k === 'class') el.className = attrs[k];
      else if (k === 'text') el.textContent = attrs[k];
      else if (k.indexOf('on') === 0) el.addEventListener(k.slice(2), attrs[k]);
      else el.setAttribute(k, attrs[k]);
    });
    (children || []).forEach(function (c) { if (c) el.appendChild(typeof c === 'string' ? document.createTextNode(c) : c); });
    return el;
  }

  function sleep(ms) { return new Promise(function (r) { setTimeout(r, reduceMotion ? 0 : ms); }); }

  function Chat(fields) {
    this.f = fields;
    this.data = { topic: null, voice: '', followup: '', age: '', area: '', nickname: '', consent: false };
    this.totalSteps = 6;
    this.build();
  }

  Chat.prototype.build = function () {
    var self = this;
    var form = this.f.form;

    this.progress = h('span', { class: 'vc-progress', 'aria-hidden': 'true' });
    this.switchBtn = h('button', { type: 'button', class: 'vc-switch', text: 'フォームで書く', onclick: function () { self.toggleForm(); } });

    this.log = h('div', { class: 'vc-log', role: 'log', 'aria-live': 'polite', 'aria-label': 'チャットの履歴' });
    this.choices = h('div', { class: 'vc-choices' });

    this.textarea = h('textarea', { class: 'vc-text', rows: '1', 'aria-label': 'メッセージを入力' });
    this.sendBtn = h('button', { type: 'submit', class: 'vc-send', text: '送る' });
    this.hint = h('p', { class: 'vc-hint' });
    this.inputForm = h('form', { class: 'vc-input', hidden: '' }, [
      h('div', { class: 'vc-input-row' }, [this.textarea, this.sendBtn]),
      this.hint
    ]);

    this.root = h('section', { class: 'vc', 'aria-label': '声を届けるチャット' }, [
      h('header', { class: 'vc-head' }, [
        h('div', { class: 'vc-head-l' }, [
          h('span', { class: 'vc-stamp', text: 'VOICE CHAT' }),
          this.progress
        ]),
        this.switchBtn
      ]),
      this.log,
      h('div', { class: 'vc-dock' }, [this.choices, this.inputForm])
    ]);

    form.parentNode.insertBefore(this.root, form);
    form.classList.add('vc-hidden-form');
    form.setAttribute('hidden', '');

    this.textarea.addEventListener('input', function () { self.autosize(); });
    this.textarea.addEventListener('keydown', function (e) {
      if (e.key !== 'Enter' || e.isComposing || e.keyCode === 229) return;   // 日本語変換中の Enter は無視
      if (self.multiline ? (e.metaKey || e.ctrlKey) : !e.shiftKey) {
        e.preventDefault();
        self.inputForm.requestSubmit ? self.inputForm.requestSubmit() : self.sendBtn.click();
      }
    });
  };

  Chat.prototype.toggleForm = function () {
    var form = this.f.form;
    var showingForm = !form.hasAttribute('hidden');
    if (showingForm) {
      form.setAttribute('hidden', '');
      this.log.parentNode.classList.remove('vc-collapsed');
      this.switchBtn.textContent = 'フォームで書く';
    } else {
      form.removeAttribute('hidden');
      this.log.parentNode.classList.add('vc-collapsed');
      this.switchBtn.textContent = 'チャットに戻る';
      var first = form.querySelector('textarea');
      if (first) first.focus();
    }
  };

  Chat.prototype.setStep = function (n) {
    this.progress.textContent = n ? ('STEP ' + n + ' / ' + this.totalSteps) : '';
  };

  Chat.prototype.autosize = function () {
    var t = this.textarea;
    t.style.height = 'auto';
    t.style.height = Math.min(t.scrollHeight, this.multiline ? 220 : 120) + 'px';
  };

  Chat.prototype.scroll = function () {
    var log = this.log;
    log.scrollTop = log.scrollHeight;
  };

  Chat.prototype.bubble = function (who, content) {
    var b = h('div', { class: 'vc-msg vc-' + who });
    if (typeof content === 'string') {
      content.split('\n').forEach(function (line, i) {
        if (i) b.appendChild(h('br'));
        b.appendChild(document.createTextNode(line));
      });
    } else b.appendChild(content);
    this.log.appendChild(b);
    this.scroll();
    return b;
  };

  Chat.prototype.say = function (text) {
    var self = this;
    var typing = h('div', { class: 'vc-msg vc-bot vc-typing', 'aria-hidden': 'true' }, [h('span'), h('span'), h('span')]);
    this.log.appendChild(typing);
    this.scroll();
    var ms = CFG.typingDelay + Math.min(String(text.textContent || text).length * 12, 600);
    return sleep(ms).then(function () {
      typing.remove();
      self.bubble('bot', text);
    });
  };

  /* 選択肢で聞く。opts: { choices:[{label,value}], skip:'文言' } */
  Chat.prototype.choose = function (opts) {
    var self = this;
    return new Promise(function (resolve) {
      self.inputForm.setAttribute('hidden', '');
      self.choices.innerHTML = '';
      var list = opts.choices.slice();
      if (opts.skip) list.push({ label: opts.skip, value: '', skip: true });
      list.forEach(function (c, i) {
        var btn = h('button', {
          type: 'button',
          class: 'vc-chip' + (c.skip ? ' vc-chip-skip' : '') + (c.primary ? ' vc-chip-primary' : ''),
          text: c.label,
          onclick: function () {
            self.choices.innerHTML = '';
            self.bubble('user', c.label);
            resolve(c);
          }
        });
        self.choices.appendChild(btn);
        if (i === 0) setTimeout(function () { btn.focus({ preventScroll: true }); }, 0);
      });
      self.scroll();
    });
  };

  /* 文章で聞く。opts: { multiline, required, skip, placeholder, value, maxlength } */
  Chat.prototype.write = function (opts) {
    var self = this;
    return new Promise(function (resolve) {
      self.choices.innerHTML = '';
      if (opts.skip) {
        self.choices.appendChild(h('button', {
          type: 'button', class: 'vc-chip vc-chip-skip', text: opts.skip,
          onclick: function () { finish(null, opts.skip); }
        }));
      }
      self.multiline = !!opts.multiline;
      self.textarea.value = opts.value || '';
      self.textarea.placeholder = opts.placeholder || '';
      self.textarea.rows = opts.multiline ? 3 : 1;
      if (opts.maxlength) self.textarea.maxLength = opts.maxlength; else self.textarea.removeAttribute('maxlength');
      self.hint.textContent = opts.multiline
        ? '改行は Enter／送信は「送る」ボタン（Ctrl+Enter でも送れます）'
        : 'Enter で送信';
      self.inputForm.removeAttribute('hidden');
      self.autosize();
      self.textarea.focus({ preventScroll: true });
      self.scroll();

      function onSubmit(e) {
        e.preventDefault();
        var v = self.textarea.value.replace(/\s+$/, '').replace(/^\s+/, '');
        if (!v) {
          if (opts.required) {
            self.textarea.classList.add('vc-shake');
            setTimeout(function () { self.textarea.classList.remove('vc-shake'); }, 400);
            return;
          }
          return;
        }
        finish(v, v);
      }
      function finish(value, shown) {
        self.inputForm.removeEventListener('submit', onSubmit);
        self.inputForm.setAttribute('hidden', '');
        self.choices.innerHTML = '';
        self.textarea.value = '';
        self.bubble('user', shown);
        resolve(value);
      }
      self.inputForm.addEventListener('submit', onSubmit);
    });
  };

  /* ------------------------------------------------------------------ */
  /* 会話の流れ                                                           */
  /* ------------------------------------------------------------------ */
  Chat.prototype.start = function () {
    var self = this;
    var msg = document.querySelector('.form-msg');
    var draft = loadDraft();

    if (msg && msg.classList.contains('success')) {
      clearDraft();
      return this.thanks();
    }
    if (msg && msg.classList.contains('error') && draft) {
      this.data = draft;
      return this.say('送信できませんでした。' + (msg.textContent || '').trim())
        .then(function () { return self.say('入力した内容は残っています。確認してもう一度送ってください。'); })
        .then(function () { return self.confirm(); });
    }
    return this.run();
  };

  Chat.prototype.run = function () {
    var self = this, d = this.data, f = this.f;
    this.log.innerHTML = '';

    return Promise.resolve()
      .then(function () { self.setStep(1); return self.say('こんにちは。「鹿児島を、語ろう。」編集部です。'); })
      .then(function () { return self.say('鹿児島で暮らしていて感じていることを、聞かせてください。名前は出さなくて大丈夫です。'); })
      .then(function () { return self.say('まず、どんな話ですか？'); })
      .then(function () { return self.choose({ choices: CFG.topics.map(function (t) { return { label: t.label, value: t }; }) }); })
      .then(function (c) { d.topic = c.value; return self.askVoice(); })
      .then(function () {
        self.setStep(3);
        return self.say(d.topic.followup + '\n（なければ飛ばして大丈夫です）');
      })
      .then(function () { return self.write({ multiline: true, skip: '特にない', placeholder: '思いついたことを、そのまま' }); })
      .then(function (v) { d.followup = v || ''; })
      .then(function () { return self.askProfile(); })
      .then(function () { return self.askConsent(); })
      .then(function () { return self.confirm(); });
  };

  Chat.prototype.askVoice = function (prefill) {
    var self = this, d = this.data;
    self.setStep(2);
    var q = prefill != null ? '書き直してください。' : '「' + d.topic.label + '」ですね。\nひとことでも、長いエピソードでも大丈夫です。';
    return self.say(q)
      .then(function () {
        return self.write({
          multiline: true, required: true, value: prefill || '',
          placeholder: '例）子ども食堂の話が気になります。近所にもあるのかな…',
          maxlength: self.f.voice && self.f.voice.maxLength > 0 ? self.f.voice.maxLength : null
        });
      })
      .then(function (v) { d.voice = v; });
  };

  Chat.prototype.askProfile = function () {
    var self = this, d = this.data, f = this.f;
    var p = Promise.resolve();
    if (f.age) {
      p = p.then(function () { self.setStep(4); return self.say('ありがとうございます。差し支えなければ、年代を教えてください。'); })
        .then(function () { return self.choose({ choices: optionTexts(f.age), skip: '答えない' }); })
        .then(function (c) { d.age = c.value; d.ageLabel = c.skip ? '' : c.label; });
    }
    if (f.area) {
      p = p.then(function () { return self.say('お住まいは？'); })
        .then(function () { return self.choose({ choices: optionTexts(f.area), skip: '答えない' }); })
        .then(function (c) { d.area = c.value; d.areaLabel = c.skip ? '' : c.label; });
    }
    if (f.nickname) {
      p = p.then(function () { self.setStep(5); return self.say('記事や「届いた声」に載るときのニックネームがあれば教えてください。'); })
        .then(function () { return self.write({ skip: 'なしでOK', placeholder: '例）さつまいも' , maxlength: f.nickname.maxLength > 0 ? f.nickname.maxLength : 30 }); })
        .then(function (v) { d.nickname = v || ''; });
    }
    return p;
  };

  Chat.prototype.askConsent = function () {
    var self = this, d = this.data, f = this.f;
    if (!f.consent) return Promise.resolve();
    self.setStep(6);
    var required = f.consent.required;
    var choices = [{ label: '掲載に同意する', value: true, primary: true }];
    if (!required) choices.push({ label: '編集部が読むだけにしてほしい', value: false });
    return self.say('届いた声は、個人が特定されない形で、抜粋して記事に載せることがあります。')
      .then(function () { return self.choose({ choices: choices }); })
      .then(function (c) { d.consent = c.value; });
  };

  Chat.prototype.composedVoice = function () {
    var d = this.data;
    var text = d.voice;
    if (CFG.prefixTopic && d.topic && d.topic.tag) text = '［' + d.topic.tag + '］' + text;
    if (d.followup) text += '\n\n' + d.followup;
    return text;
  };

  Chat.prototype.summary = function () {
    var d = this.data;
    var dl = h('dl', { class: 'vc-summary' });
    function row(k, v) { dl.appendChild(h('dt', { text: k })); dl.appendChild(h('dd', { text: v || '—' })); }
    row('あなたの声', this.composedVoice());
    if (this.f.age) row('年代', d.ageLabel);
    if (this.f.area) row('お住まい', d.areaLabel);
    if (this.f.nickname) row('ニックネーム', d.nickname);
    if (this.f.consent) row('掲載', d.consent ? '同意する' : '読むだけ');
    return h('div', null, [h('p', { class: 'vc-summary-lead', text: 'この内容で届けます。' }), dl]);
  };

  Chat.prototype.confirm = function () {
    var self = this;
    self.setStep(0);
    return self.say(self.summary())
      .then(function () {
        return self.choose({ choices: [
          { label: '送信する', value: 'send', primary: true },
          { label: '声を書き直す', value: 'edit' },
          { label: '最初からやり直す', value: 'restart' }
        ] });
      })
      .then(function (c) {
        if (c.value === 'send') return self.send();
        if (c.value === 'edit') return self.askVoice(self.data.voice).then(function () { return self.confirm(); });
        self.data = { topic: null, voice: '', followup: '', age: '', area: '', nickname: '', consent: false };
        return self.run();
      });
  };

  Chat.prototype.send = function () {
    var self = this, f = this.f, d = this.data;
    setValue(f.voice, this.composedVoice());
    if (f.age) setValue(f.age, d.age || '');
    if (f.area) setValue(f.area, d.area || '');
    if (f.nickname) setValue(f.nickname, d.nickname || '');
    if (f.consent) { f.consent.checked = !!d.consent; f.consent.dispatchEvent(new Event('change', { bubbles: true })); }
    saveDraft(d);

    // 必須項目などの検証に引っかかった場合はフォームを表示して知らせる
    if (f.form.checkValidity && !f.form.checkValidity()) {
      return self.say('送信できない項目がありました。下のフォームで確認してください。').then(function () {
        if (f.form.hasAttribute('hidden')) self.toggleForm();
        f.form.reportValidity();
      });
    }

    Array.prototype.forEach.call(document.querySelectorAll('.form-msg'), function (m) { m.remove(); });

    var sending = h('div', { class: 'vc-msg vc-bot vc-typing', 'aria-hidden': 'true' }, [h('span'), h('span'), h('span')]);
    this.log.appendChild(sending);
    this.scroll();

    // Ajax で送るフォームだった場合に備え、結果メッセージの出現を監視する
    var done = false;
    var mo = new MutationObserver(function () {
      var msg = document.querySelector('.form-msg');
      if (!msg || done) return;
      done = true; mo.disconnect(); sending.remove();
      if (msg.classList.contains('error')) {
        self.say('送信できませんでした。' + (msg.textContent || '').trim()).then(function () { return self.confirm(); });
      } else { clearDraft(); self.thanks(); }
    });
    mo.observe(document.body, { childList: true, subtree: true });

    if (f.form.requestSubmit) f.form.requestSubmit(f.submit || undefined);
    else if (f.submit) f.submit.click();
    else f.form.submit();
    return Promise.resolve();
  };

  Chat.prototype.thanks = function () {
    var self = this;
    this.setStep(0);
    return self.say('届きました。ありがとうございます。')
      .then(function () { return self.say('一通ずつ目を通しています。返信できないこともありますが、必ず読んでいます。'); })
      .then(function () {
        return self.choose({ choices: [
          { label: 'もうひとつ届ける', value: 'again', primary: true },
          { label: '記事を読む', value: 'read' }
        ] });
      })
      .then(function (c) {
        if (c.value === 'read') { window.location.href = CFG.articlesUrl; return; }
        self.data = { topic: null, voice: '', followup: '', age: '', area: '', nickname: '', consent: false };
        var old = document.querySelector('.form-msg');
        if (old) old.remove();
        return self.run();
      });
  };

  /* ------------------------------------------------------------------ */
  function init() {
    var form = findForm();
    if (!form) return;
    var fields = mapFields(form);
    if (!fields.voice) return;
    new Chat(fields).start();
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
