<?php
/*
Template Name: 関連サイト
*/
$slug = 'related';
get_header();
?>
<article class="related__wrapper">
  <div class="related__bg"></div>
  <p class="common__bread">
    <span><a href="<?php echo esc_url(home_url('/')); ?>">TOP</a></span><span>関連サイト</span>
  </p>
  <h1 class="related__h1">関連サイト</h1>
  <section class="related__section link">
    <h2 class="event__h2">協賛企業・団体</h2>
    <a href="/sponsors/list/" class="related__btn">
      <span>協賛企業・団体一覧はこちら</span>
    </a>
  </section>
  <section class="related__section">
    <?php
    // 関連サイト（related）一覧を取得
    $args = array(
      'post_type'      => 'related',
      'posts_per_page' => -1,
      'post_status'    => 'publish',
      'orderby'        => 'menu_order',
      'order'          => 'ASC',
    );
    $related_query = new WP_Query($args);
    ?>
    <?php if (! $related_query->have_posts()) : ?>
    <p class="related__zero-txt">該当するイベントはありませんでした。</p>
    <?php else : ?>
    <ul class="related__list">
      <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
      <?php
        $title = get_the_title();
        $img = function_exists('get_field') ? get_field('related_img') : '';
        $img_url = '';
        $img_alt = $title;
        if (is_array($img) && !empty($img['url'])) {
          $img_url = $img['url'];
          if (!empty($img['alt'])) {
            $img_alt = $img['alt'];
          }
        }
        $link = function_exists('get_field') ? get_field('related_link') : '';
        $is_internal = false;
        if ($link) {
          $home_url = home_url();
          if (strpos($link, $home_url) === 0) {
            $is_internal = true;
          }
        }
      ?>
      <li class="related__list--item">
        <?php if ($link) : ?>
        <a class="related__llst--link" href="<?php echo esc_url($link); ?>" <?php if (!$is_internal) : ?>target="_blank"
          rel="noopener noreferrer" <?php endif; ?>>
          <?php else : ?>
          <a class="related__llst--link" href="javascript:void(0);">
            <?php endif; ?>
            <?php if ($img_url) : ?>
            <img class="related__list--logo" src="<?php echo esc_url($img_url); ?>"
              alt="<?php echo esc_attr($img_alt); ?>">
            <?php endif; ?>
            <p class="related__list--text"><?php echo esc_html($title); ?></p>
          </a>
      </li>
      <?php endwhile; wp_reset_postdata(); ?>
    </ul>
    <?php endif; ?>
  </section>
</article>
<?php get_footer(); ?>