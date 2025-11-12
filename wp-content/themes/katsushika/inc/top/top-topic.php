<?php
$topic_query = new WP_Query(array(
  'post_type'      => 'top_topic',
  'post_status'    => 'publish',
  'posts_per_page' => -1,
  'orderby'        => array('menu_order' => 'ASC', 'date' => 'DESC'),
));
?>

<section class="common-section top-topic">
  <h2 class="common_h2 top-topic__ttl">トピックス</h2>
  <?php if ($topic_query->have_posts()) : ?>
  <div class="top-topic__swiper swiper">
    <div class="top-topic__swiper-wrapper swiper-wrapper">
      <?php
      while ($topic_query->have_posts()) :
        $topic_query->the_post();
        // ACF値
        $img = get_field('top_topic_img');
        $int = get_field('top_topic_internal_link');
        $ext = get_field('top_topic_external_link');

        if (empty($img)) continue;
        $img_url = is_array($img) && !empty($img['url']) ? esc_url($img['url']) : '';
        $img_alt = is_array($img) && isset($img['alt']) && $img['alt'] !== '' ? esc_attr($img['alt']) : esc_attr(get_the_title());
        // 内部リンクURL判断
        $internal_url = '';
        if (!empty($int)) {
          if (is_string($int)) {
            $internal_url = $int;
          } elseif (is_array($int) && !empty($int['url'])) {
            $internal_url = $int['url'];
          } elseif ($int instanceof WP_Post) {
            $internal_url = get_permalink($int);
          } else {
            $internal_id = intval($int);
            if ($internal_id) $internal_url = get_permalink($internal_id);
          }
        }
        $link_url = '';
        $is_external = false;
        if ($internal_url && !$ext) {
          $link_url = esc_url($internal_url);
          $is_external = false;
        } elseif ($ext && !$internal_url) {
          $link_url = esc_url($ext);
          $is_external = true;
        }

        $slide_classes = array('top-topic__swiper-slide', 'swiper-slide');
        if (!$link_url) $slide_classes[] = 'no-link';
      ?>
      <div class="<?php echo esc_attr(implode(' ', $slide_classes)); ?>">
        <img src="<?php echo $img_url; ?>" alt="<?php echo $img_alt; ?>">
        <div class="top-topic__slide-box">
          <p class="title"><?php echo esc_html(get_the_title()); ?></p>
          <?php if ($link_url): ?>
          <a class="common__btn-w" href="<?php echo $link_url; ?>"
            <?php echo $is_external ? ' target="_blank"' : ''; ?>>
            <span>詳細はこちら</span>
          </a>
          <?php else: ?>
          <span class="common__btn-w is-disabled" aria-disabled="true">
            <span>詳細はこちら</span>
          </span>
          <?php endif; ?>
        </div>
      </div>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
  <?php if ($topic_query->post_count > 1) : ?>
  <div class="top-topic__swiper-nav">
    <div class="top-topic__swiper-btn--prev swiper-button-prev sp-none" aria-label="前へ"></div>
    <div class="top-topic__swiper-pagination swiper-pagination"></div>
    <div class="top-topic__swiper-btn--next swiper-button-next sp-none" aria-label="次へ"></div>
  </div>
  <?php endif; ?>
</section>
<?php endif; ?>