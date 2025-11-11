<?php
$featured_events = new WP_Query([
  'post_type'      => 'event',
  'posts_per_page' => 3,
  'post_status'    => 'publish',
  'meta_query'     => [
    [
      'key'     => 'event_featured',
      'value'   => '1',
      'compare' => '=',
    ],
  ],
  'meta_key'       => 'event_start_date',
  'orderby'        => 'meta_value',
  'order'          => 'ASC',
]);
?>
<section class="common-section top-event">
  <h2 class="common-h2 top-event__ttl">注目イベント</h2>
  <div class="top-event__wrapper">
    <?php if ($featured_events->have_posts()) : ?>
    <?php while ($featured_events->have_posts()) : $featured_events->the_post(); ?>
    <?php
      if (has_post_thumbnail()) {
        $thumb_html = get_the_post_thumbnail(get_the_ID(), 'medium', ['class' => '']);
      } else {
        $thumb_html = '<img src="/assets/img/common/thumbnail.png" alt="">';
      }
      $area_terms = get_the_terms(get_the_ID(), 'event_area');
      $area_slug  = '';
      $area_name  = '';
      if ($area_terms && ! is_wp_error($area_terms)) {
        $area_slug = $area_terms[0]->slug;
        $area_name = $area_terms[0]->name;
      }
      $desc = wp_trim_words(strip_tags(get_the_content()), 60, '…');
    ?>
    <div class="top-event__box">
      <div class="top-event__img">
        <?php echo $thumb_html; ?>
      </div>
      <div class="top-event__content">
        <h3><?php the_title(); ?></h3>
        <p><?php echo esc_html($desc); ?></p>
        <?php if ($area_name) : ?>
        <span class="<?php echo esc_attr($area_slug); ?>">
          <?php echo esc_html($area_name); ?>
        </span>
        <?php endif; ?>
        <a class="common__btn-w top-event__btn" href="<?php the_permalink(); ?>">
          <span>詳細はこちら</span>
        </a>
      </div>
    </div>
    <?php endwhile; wp_reset_postdata(); ?>
    <?php else : ?>
    <!-- 注目イベントがなかったときに何か出したければここ -->
    <p>現在、注目イベントはありません。</p>
    <?php endif; ?>
  </div>
</section>