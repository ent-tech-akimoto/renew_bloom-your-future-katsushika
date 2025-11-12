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
    <?php
    $important_news = new WP_Query(array(
      'post_type'      => 'post',
      'post_status'    => 'publish',
      'posts_per_page' => 1,
      'meta_key'       => 'news__important',
      'meta_value'     => true,
      'orderby'        => 'date',
      'order'          => 'DESC',
    ));
    ?>
    <?php if ($important_news->have_posts()) : ?>
    <?php while ($important_news->have_posts()) : $important_news->the_post(); ?>
    <div class="fixed__inner">
      <a href="<?php echo esc_url(get_permalink()); ?>">重要なお知らせ</a>
      <p><?php echo esc_html(get_the_title()); ?></p>
      <button id="fixed-close" type="button" aria-label="閉じる">
        <span></span>
        <span></span>
      </button>
    </div>
    <?php endwhile; wp_reset_postdata(); ?>
    <?php endif; ?>
  </div>
</main>
<?php get_footer(); ?>