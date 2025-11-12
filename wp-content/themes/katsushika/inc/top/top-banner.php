<?php
$banner_query = new WP_Query(array(
  'post_type'      => 'top_banner',
  'post_status'    => 'publish',
  'posts_per_page' => 8,
  'orderby'        => array('menu_order' => 'ASC', 'date' => 'DESC'),
));
?>
<?php if ($banner_query->have_posts()) : ?>
<section class="top-banner">
  <div class="top-banner__swiper swiper">
    <div class="top-banner__swiper-wrapper swiper-wrapper">

      <?php
      $i = 0;
      while ($banner_query->have_posts()) :
        $banner_query->the_post();
        // ACF値
        $img   = get_field('top_banner_img');
        $title = get_field('top_banner_title');
        $lead  = get_field('top_banner_lead');
        $int   = get_field('top_link_internal');
        $ext   = get_field('top_link_external');

        if (empty($img)) continue;
        $img_url = is_array($img) && !empty($img['url']) ? esc_url($img['url']) : '';
        $img_alt = is_array($img) && isset($img['alt']) && $img['alt'] !== '' ? esc_attr($img['alt']) : esc_attr($title ?: get_the_title());
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
        if ($internal_url && !$ext) {
          $link_url = esc_url($internal_url);
        } elseif ($ext && !$internal_url) {
          $link_url = esc_url($ext);
        }

        $slide_classes = array('top-banner__swiper-slide', 'swiper-slide');
        if (!$link_url) $slide_classes[] = 'no-link';

        $loading = ($i === 0) ? 'eager' : 'lazy';
      ?>
      <div class="<?php echo esc_attr(implode(' ', $slide_classes)); ?>">
        <div class="top-banner__atten">
          <h5 class="top-banner__atten-ttl">会場</h5>
          <p class="top-banner__atten-txt">葛飾にいじゅくみらい公園<span>ほか</span></p>
        </div>
        <?php
        $img_tag = sprintf(
          '<img class="top-banner__img" src="%1$s" alt="%2$s" loading="%3$s">',
          $img_url,
          $img_alt,
          esc_attr($loading)
        );
        if ($link_url) {
          $is_external = (strpos($link_url, home_url()) !== 0);
          $target_rel  = $is_external ? ' target="_blank"' : '';
          echo '<a href="' . $link_url . '"' . $target_rel . '>' . $img_tag . '</a>';
        } else {
          echo $img_tag;
        }
        ?>
        <?php if ($title || $lead): ?>
        <div class="top-banner__text">
          <?php if ($title): ?>
          <h5 class="title"><?php echo esc_html($title); ?></h5>
          <?php endif; ?>
          <?php if ($lead): ?>
          <p class="text"><?php echo esc_html($lead); ?></p>
          <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="top-banner__progress"></div>
      </div>
      <?php $i++; endwhile; wp_reset_postdata();?>
    </div>
  </div>
  <div class="top-banner__swiper-pagination swiper-pagination"></div>
  <div class="top-banner__swiper-btn--next swiper-button-next hover" aria-label="次のバナーへ"></div>
  <div class="top-banner__swiper-btn--prev swiper-button-prev hover" aria-label="前のバナーへ"></div>
</section>
<?php endif; ?>