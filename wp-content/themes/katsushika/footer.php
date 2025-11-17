<?php
  if (is_front_page()) {
    $page_id = 'top';
  } elseif (is_archive() && !is_post_type_archive('event') && !is_post_type_archive('sponsors')) {
    $page_id = 'news';
  } elseif (is_post_type_archive('event')) {
    $page_id = 'event';
  } elseif (is_post_type_archive('sponsors')) {
    $page_id = 'sponsors';
  } elseif (is_page('event-calendar')) {
    $page_id = 'calendar';
  } elseif (is_page('sponsors-list')) {
    $page_id = 'sponsors-list';
  } elseif (is_singular('event')) {
    $page_id = 'event-detail';
  } elseif (is_singular('sponsors')) {
    $page_id = 'sponsors-detail';
  } else {
    $page_id = '';
  }
?>
<footer class="footer <?php echo esc_js($page_id); ?>">
  <div class="footer___sponsors">
    <h2 class="footer___sponsors--title">
      <span>スポンサー</span>
    </h2>
    <div class="footer___sponsors--contents">
      <ul class="footer___sponsors--main">
        <li class="footer___sponsors--main-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_mitsui-fudosan.webp" alt="">
          </a>
        </li>
        <li class="footer___sponsors--main-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_fujitsu.webp" alt="">
          </a>
        </li>
        <li class="footer___sponsors--main-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_wako-sangyo.webp" alt="">
          </a>
        </li>
        <li class="footer___sponsors--main-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_yokohama-bank.webp" alt="">
          </a>
        </li>
        <li class="footer___sponsors--main-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_tokyu-fudosan.webp" alt="">
          </a>
        </li>
        <li class="footer___sponsors--main-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_odakyu.webp" alt="">
          </a>
        </li>
        <li class="footer___sponsors--main-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_ja-ceresa-kawasaki.webp" alt="">
          </a>
        </li>
        <li class="footer___sponsors--main-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_mitsubishi-kouki.webp" alt="">
          </a>
        </li>
      </ul>
      <ul class="footer___sponsors--sub">
        <li class="footer___sponsors--sub-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_mitsui-fudosan.webp" alt="">
          </a>
        </li>
        <li class="footer___sponsors--sub-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_fujitsu.webp" alt="">
          </a>
        </li>
        <li class="footer___sponsors--sub-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_wako-sangyo.webp" alt="">
          </a>
        </li>
        <li class="footer___sponsors--sub-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_yokohama-bank.webp" alt="">
          </a>
        </li>
        <li class="footer___sponsors--sub-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_tokyu-fudosan.webp" alt="">
          </a>
        </li>
        <li class="footer___sponsors--sub-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_odakyu.webp" alt="">
          </a>
        </li>
        <li class="footer___sponsors--sub-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_ja-ceresa-kawasaki.webp" alt="">
          </a>
        </li>
        <li class="footer___sponsors--sub-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_mitsubishi-kouki.webp" alt="">
          </a>
        </li>
        <li class="footer___sponsors--sub-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_mitsui-fudosan.webp" alt="">
          </a>
        </li>
        <li class="footer___sponsors--sub-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_fujitsu.webp" alt="">
          </a>
        </li>
        <li class="footer___sponsors--sub-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_wako-sangyo.webp" alt="">
          </a>
        </li>
        <li class="footer___sponsors--sub-item">
          <a href="" target="_blank">
            <img src="/assets/data/webp/common/logo/logo_yokohama-bank.webp" alt="">
          </a>
        </li>
      </ul>
      <a class="footer___sponsors--btn" href="/sponsors/list/"><span>協賛企業・団体一覧はこちら</span></a>
    </div>
  </div>
  <div class="footer__main">
    <button id="pageTop" class="footer__main--pagetop" aria-label="TOPへもどる" type="button">
      <picture>
        <source srcset="/assets/data/webp/common/footer/pagetop_pc.webp" media="(min-width: 768px)">
        <img src="/assets/data/webp/common/footer/pagetop.webp" alt="TOPへもどる">
      </picture>
    </button>
    <div class="footer__main--bg">
      <div class="footer__main--contents">
        <div class="footer__block">
          <p class="footer__block--tit">Contents</p>
          <nav class="footer__nav">
            <a href="">開催概要</a>
            <a href="">開催エリア</a>
            <a href="/event/">イベント情報</a>
            <a href="/sponsors/">募集情報</a>
            <a href="/sponsors/list/">協賛募集</a>
            <a href="">アクセス情報</a>
            <a href="/news/">お知らせ</a>
            <a href="">関連サイト</a>
            <a href="">お問い合わせ</a>
          </nav>
          <nav class="footer__subnav">
            <a href="">利用規約</a>
            <a href="">プライバシーポリシー</a>
            <a href="">運用ポリシーサイトマップ</a>
          </nav>
          <p class="footer__block--tit">Follow us</p>
          <div class="footer__sns">
            <a class="footer__sns--item -x" href="https://x.com/katsu_midohana" target="_blank">
              <img src="/assets/data/webp/common/sns_x.webp" alt="X">
            </a>
            <a class="footer__sns--item -insta" href="https://www.instagram.com/katsushika_midorihanafair/"
              target="_blank">
              <img src="/assets/data/webp/common/sns_insta.webp" alt="Instagram">
            </a>
            <a class="footer__sns--item -fb" href="https://www.facebook.com/profile.php?id=61576628410141"
              target="_blank">
              <img src="/assets/data/webp/common/sns_fb.webp" alt="facebook">
            </a>
          </div>
          <p class="footer__block--tit"> Contact us </p>
          <div class="footer__contact">
            <p class="footer__contact--tel"> TEL <a href="tel:03-5654-6774">03-5654-6774</a><br>
              <span>＊午前8時30分から午後5時（土日祝、年末年始を除く）</span>
            </p>
            <a class="footer__contact--katsushika" href="https://www.city.katsushika.lg.jp/" target="_blank">
              <img src="/assets/data/webp/common/footer/katsushika-ku.webp" alt="葛飾区公式サイト">
            </a>
          </div>
        </div>
        <div class="footer__img">
          <p class="footer__img--sakase-mirai">
            <img src="/assets/data/webp/common/footer/sakase-mirai.webp" alt="サカセみらい">
          </p>
          <a class="footer__img--logo" href="/">
            <img src="/assets/data/webp/common/logo.webp" alt="Bloom Your Future Katsushika">
          </a>
        </div>
      </div>
      <p class="footer__copyright">&copy; 全国みどりと花のフェアかつしか実行委員会</p>
    </div>
  </div>
</footer>
</div>
<script>
window.pageID = '<?php echo esc_js($page_id); ?>';
</script>
<script src="/assets/js/project.js?v=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/js/project.js'); ?>">
</script>
<script type="text/javascript">
document.getElementById('js-header-btn').addEventListener('click', function() {
  this.classList.toggle('is-active');
  document.getElementById('js-header-nav').classList.toggle('is-open');
});

function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'ja',
    includedLanguages: 'en,ko,zh-CN,zh-TW,th',
    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
  }, 'google_translate_element');
}
</script>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<?php if (is_post_type_archive('event') || is_singular('event')) : ?>
<script
  src="/assets/js/word_suggest.js?v=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/js/word_suggest.js'); ?>">
</script>
<?php endif; ?>
<?php wp_footer(); ?>
</body>

</html>