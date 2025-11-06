<?php get_header(); ?>
<div id="loading" class="loading">
  <div class="loading__logo">
    <img src="/assets/img/common/logo.png" alt="">
  </div>
  <p id="loadingBar" class="loading__bar"></p>
</div>
<main class="top">
  <div class="top__bg green">
    <?php include(get_template_directory() . '/inc/top/top-banner.php'); ?>
    <?php include(get_template_directory() . '/inc/top/top-news.php'); ?>
    <?php include(get_template_directory() . '/inc/top/top-insta.php'); ?>
  </div>
  <div class="top__bg pink js-scroll">
    <?php include(get_template_directory() . '/inc/top/top-topic.php'); ?>
    <?php include(get_template_directory() . '/inc/top/top-event.php'); ?>
  </div>
  <div class="top__bg orange js-scroll">
    <?php include(get_template_directory() . '/inc/top/top-about.php'); ?>
  </div>
  <div class="top__bg blue js-scroll">
    <?php include(get_template_directory() . '/inc/top/top-area.php'); ?>
    <?php include(get_template_directory() . '/inc/top/top-map.php'); ?>
    <?php include(get_template_directory() . '/inc/top/top-gallery.php'); ?>
  </div>
  <div class="fixed js-show">
    <div class="fixed__inner">
      <a>重要なお知らせ</a>
      <p> 雨天のため、一部のイベントを中止いたします。詳しいじ情報はイベントページからご確認ください。雨天のため、一部のイベントを中止いたします。詳しいじ情報はイベントページからご確認ください。 </p>
      <button id="fixed-close">
        <span></span>
        <span></span>
      </button>
    </div>
  </div>
</main>
<?php get_footer(); ?>