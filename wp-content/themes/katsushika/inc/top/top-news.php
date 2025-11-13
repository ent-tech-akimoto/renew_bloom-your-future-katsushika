<?php
$news_query = new WP_Query(array(
  'post_type'      => 'post',
  'post_status'    => 'publish',
  'posts_per_page' => 4,
  'orderby'        => 'date',
  'order'          => 'DESC',
));
?>

<section class="common__section top-news">
  <h2 class="common_h2 top-news__ttl">お知らせ</h2>
  <div class="top-news__wrapper">
    <?php if ($news_query->have_posts()) : ?>
    <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
    <?php
      $new_days = 7;
      $now_local = current_time('timestamp');
      $published_local = get_post_time('U');
      $is_published = (get_post_status() === 'publish');
      $is_new = $is_published && (($now_local - $published_local) < ($new_days * DAY_IN_SECONDS));
      $categories = get_the_category();
      $year  = get_the_date('Y年');
      $month_day = get_the_date('n月j日');
      $excerpt = get_the_excerpt() ?: get_the_title();
      $permalink = get_permalink();
      ?>
    <div class="top-news__box <?php echo $is_new ? ' new' : ''; ?>">
      <a href="<?php echo esc_url($permalink); ?>" class="top-news__link">
        <div class="top-news__cate">
          <?php if ($categories) : ?>
          <?php foreach ($categories as $cat) : ?>
          <p class="<?php echo esc_attr($cat->slug); ?>">#<?php echo esc_html($cat->name); ?></p>
          <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <div class="top-news__txt">
          <div class="top-news__date">
            <span><?php echo esc_html($year); ?></span>
            <span><?php echo esc_html($month_day); ?></span>
          </div>
          <p><?php echo esc_html(get_the_title()); ?></p>
        </div>
      </a>
    </div>
    <?php endwhile; wp_reset_postdata(); ?>
  </div>
  <div class="common__btn-i top-news__btn">
    <a href="/news/"><span>お知らせ一覧はこちら</span></a>
  </div>
</section>
<?php endif; ?>