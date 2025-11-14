<?php
/**
 * カスタム投稿タイプ「sponsors」のアーカイブ
 */
$slug = 'sponsors';
get_header();

?>

<article class="sponsors__wrapper">
  <div class="sponsors__bg"></div>
  <p class="common__bread l-page">
    <span><a href="<?php echo esc_url(home_url('/')); ?>">TOP</a></span><span>募集情報</span>
  </p>
  <h1 class="sponsors__h1">募集情報</h1>
  <nav class="sponsors__nav">
    <ul class="sponsors__nav--list">
      <li class="sponsors__nav--item">
        <a href="#anchor-individual">個人向け</a>
      </li>
      <li class="sponsors__nav--item">
        <a href="#anchor-group">企業・団体向け</a>
      </li>
    </ul>
  </nav>
  <a href="/sponsors-list/" class="sponsors__btn">
    <span>協力企業・団体一覧はこちら</span>
  </a>

  <?php
  // 個人向け
  $individual_args = [
    'post_type'      => 'sponsors',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'meta_query'     => [
      [
        'key'     => 'sponsors_category',
        'value'   => 'individual',
        'compare' => '=',
      ],
    ],
    'meta_key'       => 'sponsors_pickup',
    'orderby'        => [
      'meta_value' => 'DESC',
      'date'       => 'DESC',
    ],
  ];
  $individual_query = new WP_Query($individual_args);
  ?>
  <section id="anchor-individual" class="sponsors__section">
    <h2 class="sponsors__h2">
      <span>個人向け</span>
    </h2>
    <p class="sponsors__text">
      個人向けの説明入ります個人向けの説明入ります個人向けの説明入ります個人向けの説明入ります個人向けの説明入ります個人向けの説明入ります個人向けの説明入ります個人向けの説明入ります個人向けの説明入ります個人向けの説明入ります個人向けの説明入ります個人向けの説明入ります個人向けの説明入ります
      個人向けの説明入ります個人向けの説明入ります個人向けの説明入ります個人向けの説明入ります個人向けの説明入ります
    </p>
    <?php if ($individual_query->have_posts()) : ?>
    <p class="sponsors__zero-txt" style="display:none;">該当する募集はありませんでした。</p>
    <ul class="sponsors__box-list">
      <?php while ($individual_query->have_posts()) : $individual_query->the_post(); ?>
      <?php
      // ACF: サムネイル
      $thumb = function_exists('get_field') ? get_field('sponsors_thumbnail') : '';
      $thumb_url = (is_array($thumb) && !empty($thumb['url'])) ? $thumb['url'] : '';
      // ACF: 募集期間
      $period = function_exists('get_field') ? get_field('sponsors_period') : '';
      // NEW判定
      $new_days   = 7;
      $now_local  = current_time('timestamp');
      $published  = get_post_time('U');
      $is_new     = ($now_local - $published) < ($new_days * DAY_IN_SECONDS);
      // ピックアップ判定
      $is_pickup = function_exists('get_field') ? get_field('sponsors_pickup') : false;
      // aタグにpickup
      $a_classes = 'sponsors__box-item';
      if ($is_pickup) {
        $a_classes .= ' pickup';
      }
      // 画像ラッパーにnew
      $img_classes = 'sponsors__box-img';
      if ($is_new) {
        $img_classes .= ' new';
      }
      ?>
      <li>
        <a class="<?php echo esc_attr($a_classes); ?>" href="<?php the_permalink(); ?>">
          <div class="<?php echo esc_attr($img_classes); ?>">
            <?php if ($thumb_url) : ?>
            <img src="<?php echo esc_url($thumb_url); ?>" alt="">
            <?php else : ?>
            <img src="/assets/img/common/thumbnail.png" alt="">
            <?php endif; ?>
          </div>
          <p class="sponsors__box-date">
            <?php echo $period ? esc_html($period) : esc_html(get_the_date('Y年 n月j日')); ?>
          </p>
          <h4 class="sponsors__box-ttl"><?php the_title(); ?></h4>
        </a>
      </li>
      <?php endwhile; wp_reset_postdata(); ?>
    </ul>
    <?php else : ?>
    <p class="sponsors__zero-txt">該当する募集はありませんでした。</p>
    <?php endif; ?>
  </section>
  <?php
  // 企業・団体向け
  $group_args = [
    'post_type'      => 'sponsors',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'meta_query'     => [
      [
        'key'     => 'sponsors_category',
        'value'   => 'group',
        'compare' => '=',
      ],
    ],
    'meta_key'       => 'sponsors_pickup',
    'orderby'        => [
      'meta_value' => 'DESC',
      'date'       => 'DESC',
    ],
  ];
  $group_query = new WP_Query($group_args);
  ?>
  <section id="anchor-group" class="sponsors__section">
    <h2 class="sponsors__h2">
      <span>企業・団体向け</span>
    </h2>
    <p class="sponsors__text">
      開催テーマに基づき、多種多様な団体や企業に出典募集します。<br>
      また来場者の興味やニーズに合わせた出典内容にすることで、本フェアの統一感を高め、出店者のみならず主催者、来場者等の一体感を高めます。<br>
      これらの協賛展示により、新たなコミュニティを形成し、本フェア終了後も活動や購入等の継続を目指します。
    </p>

    <?php if ($group_query->have_posts()) : ?>
    <p class="sponsors__zero-txt" style="display:none;">該当する募集はありませんでした。</p>
    <ul class="sponsors__box-list">
      <?php while ($group_query->have_posts()) : $group_query->the_post(); ?>
      <?php
      // ACF: サムネイル
      $thumb = function_exists('get_field') ? get_field('sponsors_thumbnail') : '';
      $thumb_url = (is_array($thumb) && !empty($thumb['url'])) ? $thumb['url'] : '';
      // ACF: 募集期間
      $period = function_exists('get_field') ? get_field('sponsors_period') : '';
      // NEW判定
      $new_days   = 7;
      $now_local  = current_time('timestamp');
      $published  = get_post_time('U');
      $is_new     = ($now_local - $published) < ($new_days * DAY_IN_SECONDS);
      // ピックアップ判定
      $is_pickup = function_exists('get_field') ? get_field('sponsors_pickup') : false;
      // aタグにpickup
      $a_classes = 'sponsors__box-item';
      if ($is_pickup) {
        $a_classes .= ' pickup';
      }
      // 画像ラッパーにnew
      $img_classes = 'sponsors__box-img';
      if ($is_new) {
        $img_classes .= ' new';
      }
      ?>
      <li>
        <a class="<?php echo esc_attr($a_classes); ?>" href="<?php the_permalink(); ?>">
          <div class="<?php echo esc_attr($img_classes); ?>">
            <?php if ($thumb_url) : ?>
            <img src="<?php echo esc_url($thumb_url); ?>" alt="">
            <?php else : ?>
            <img src="/assets/img/common/thumbnail.png" alt="">
            <?php endif; ?>
          </div>
          <p class="sponsors__box-date">
            <?php echo $period ? esc_html($period) : esc_html(get_the_date('Y年 n月j日')); ?>
          </p>
          <h4 class="sponsors__box-ttl"><?php the_title(); ?></h4>
        </a>
      </li>
      <?php endwhile; wp_reset_postdata(); ?>
    </ul>
    <?php else : ?>
    <p class="sponsors__zero-txt">該当する募集はありませんでした。</p>
    <?php endif; ?>
  </section>
</article>
<?php get_footer(); ?>