<?php
/*
Template Name: 協賛企業・団体一覧
*/
$slug = 'sponsors-list';
get_header();
?>
<article class="sponsors__wrapper">
  <div class="sponsors__bg"></div>
  <p class="common__bread l-page">
    <span><a href="<?php echo esc_url(home_url('/')); ?>">TOP</a></span><span>協賛企業・団体一覧</span>
  </p>
  <h1 class="sponsors__h1">協賛企業・団体一覧</h1>
  <section class="sponsors__section list">
    <h2 class="sponsors__h2">
      <span>全国みどりと花のフェアかつしか<br>協賛企業・団体</span>
    </h2>
    <h3 class="sponsors__h3">
      <span>特別協賛</span>
    </h3>
    <div class="sponsors__special">
      <ul class="sponsors__special--list">
        <?php
        // 特別協賛（sponsors_special）の一覧取得
        $special_args = array(
          'post_type'      => 'sponsors_special',
          'posts_per_page' => -1,
          'post_status'    => 'publish',
          'orderby'        => 'menu_order',
          'order'          => 'ASC',
        );
        $special_query = new WP_Query($special_args);
        if ($special_query->have_posts()) :
          while ($special_query->have_posts()) :
            $special_query->the_post();
            $logo = function_exists('get_field') ? get_field('sponsors_list_logo') : '';
            $logo_url = '';
            $logo_alt = get_the_title();
            if (is_array($logo) && !empty($logo['url'])) {
              $logo_url = $logo['url'];
              if (!empty($logo['alt'])) {
                $logo_alt = $logo['alt'];
              }
            }
          $link = function_exists('get_field') ? get_field('sponsors_list_link') : '';
          $href = $link ? $link : '#';
        ?>
        <li class="sponsors__special--item">
          <a class="sponsors__special--link" href="<?php echo esc_url($href); ?>" <?php if ($link) : ?>target="_blank"
            rel="noopener noreferrer" <?php endif; ?>>
            <?php if ($logo_url) : ?>
            <img class="sponsors__special--logo" src="<?php echo esc_url($logo_url); ?>"
              alt="<?php echo esc_attr($logo_alt); ?>">
            <?php endif; ?>
            <p class="sponsors__special--text"><?php the_title(); ?></p>
          </a>
        </li>
        <?php endwhile; wp_reset_postdata(); endif; ?>
      </ul>
    </div>
    <h3 class="sponsors__h3">
      <span>資金協賛</span>
    </h3>
    <?php // 資金協賛（sponsors_funds）の一覧取得
    // パートナー種別の設定classname
    $funds_partner_blocks = array(
      'platinum' => array(
        'type_class' => 'platinum',
        'list_class' => 'lv1',
        'en'         => 'PLATINUM',
        'ja'         => 'プラチナパートナー',
      ),
      'gold' => array(
        'type_class' => 'gold',
        'list_class' => 'lv2',
        'en'         => 'GOLD',
        'ja'         => 'ゴールドパートナー',
      ),
      'silver' => array(
        'type_class' => 'silver',
        'list_class' => 'lv3',
        'en'         => 'SILVER',
        'ja'         => 'シルバーパートナー',
      ),
      'bronze' => array(
        'type_class' => 'bronze',
        'list_class' => 'lv4',
        'en'         => 'BRONZE',
        'ja'         => 'ブロンズパートナー',
      ),
      'supporter' => array(
        'type_class' => 'blue',
        'list_class' => 'lv5',
        'en'         => 'SUPPORTER',
        'ja'         => 'サポーター',
      ),
    );
    // ラベルごとの投稿ID
    $grouped_funds = array();
    foreach ($funds_partner_blocks as $key => $conf) {
      $grouped_funds[$key] = array();
    }

    $funds_args = array(
      'post_type'      => 'sponsors_funds',
      'posts_per_page' => -1,
      'post_status'    => 'publish',
      'orderby'        => 'menu_order',
      'order'          => 'ASC',
    );

    $funds_query = new WP_Query($funds_args);

    if ($funds_query->have_posts()) :
      while ($funds_query->have_posts()) :
        $funds_query->the_post();
        // ACF: sponsors_label
        $label_raw = function_exists('get_field') ? get_field('sponsors_label') : '';
        $label = '';
        if (is_array($label_raw)) {
          if (isset($label_raw['value'])) {
            $label = $label_raw['value'];   //例: platinum
          } elseif (isset($label_raw['label'])) {
            $label = $label_raw['label'];   // 例: "プラチナパートナー"
          }
        } else {
          $label = $label_raw;
        }

        if ($label === '') {
          continue;
        }
        if (!isset($grouped_funds[$label])) {
          $grouped_funds[$label] = array();
        }
        $grouped_funds[$label][] = get_the_ID();
      endwhile; wp_reset_postdata(); endif;
    ?>
    <?php
    // パートナー名ごとにブロック出力
    foreach ($funds_partner_blocks as $label_key => $conf) :
      if (empty($grouped_funds[$label_key])) {
        continue;
      }
      ?>
    <div class="sponsors__list">
      <h4 class="sponsors__list--type <?php echo esc_attr($conf['type_class']); ?>">
        <span><?php echo esc_html($conf['en']); ?></span>
      </h4>
      <h5 class="sponsors__list--name">
        <span><?php echo esc_html($conf['ja']); ?></span>
      </h5>
      <ul class="sponsors__list--list <?php echo esc_attr($conf['list_class']); ?>">
        <?php foreach ($grouped_funds[$label_key] as $post_id) : ?>
        <?php
            $title = get_the_title($post_id);
            // ロゴ画像
            $logo = function_exists('get_field') ? get_field('sponsors_list_logo', $post_id) : '';
            $logo_url = '';
            $logo_alt = $title;
            if (is_array($logo) && !empty($logo['url'])) {
              $logo_url = $logo['url'];
              if (!empty($logo['alt'])) {
                $logo_alt = $logo['alt'];
              }
            }
            // リンク先
            $link = function_exists('get_field') ? get_field('sponsors_list_link', $post_id) : '';
            ?>
        <li class="sponsors__list--item">
          <?php if ($link) : ?>
          <!-- リンクありパターン（PLATINUM / GOLD / SILVER / BRONZE 相当） -->
          <a class="sponsors__list--link" href="<?php echo esc_url($link); ?>" target="_blank"
            rel="noopener noreferrer">
            <?php if ($logo_url) : ?>
            <img class="sponsors__list--logo" src="<?php echo esc_url($logo_url); ?>"
              alt="<?php echo esc_attr($logo_alt); ?>">
            <?php endif; ?>
            <p class="sponsors__list--text"><?php echo esc_html($title); ?></p>
          </a>
          <?php else : ?>
          <!-- リンクなしパターン（SUPPORTER 相当）。ロゴがあれば表示 -->
          <?php if ($logo_url) : ?>
          <img class="sponsors__list--logo" src="<?php echo esc_url($logo_url); ?>"
            alt="<?php echo esc_attr($logo_alt); ?>">
          <?php endif; ?>
          <p class="sponsors__list--text"><?php echo esc_html($title); ?></p>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endforeach; ?>
    <h3 class="sponsors__h3">
      <span>物品等協賛</span>
    </h3>
    <?php
    // 物品等協賛（sponsors_goods）の一覧取得
    $goods_partner_blocks = array(
      'special' => array(
        'type_class' => 'gold',
        'list_class' => 'lv2',
        'en'         => 'SPECIAL',
        'ja'         => 'スペシャルサプライヤー',
      ),
      'supplier' => array(
        'type_class' => 'bronze',
        'list_class' => 'lv4',
        'en'         => 'SUPPLIER',
        'ja'         => 'サプライヤー',
      ),
    );
    $grouped_goods = array();
    foreach ($goods_partner_blocks as $key => $conf) {
      $grouped_goods[$key] = array();
    }
    $goods_args = array(
      'post_type'      => 'sponsors_goods',
      'posts_per_page' => -1,
      'post_status'    => 'publish',
      'orderby'        => 'menu_order',
      'order'          => 'ASC',
    );
    $goods_query = new WP_Query($goods_args);
    if ($goods_query->have_posts()) :
      while ($goods_query->have_posts()) :
        $goods_query->the_post();
        $label_raw = function_exists('get_field') ? get_field('sponsors_label') : '';
        $label = '';
        if (is_array($label_raw)) {
          if (isset($label_raw['value'])) {
            $label = $label_raw['value'];
          } elseif (isset($label_raw['label'])) {
            $label = $label_raw['label'];
          }
        } else {
          $label = $label_raw;
        }
        if ($label === '') {
          continue;
        }
        if ($label === 'スペシャルサプライヤー') {
          $label = 'special';
        } elseif ($label === 'サプライヤー') {
          $label = 'supplier';
        }
        if (!isset($grouped_goods[$label])) {
          $grouped_goods[$label] = array();
        }
        $grouped_goods[$label][] = get_the_ID();
      endwhile; wp_reset_postdata(); endif;
    ?>
    <?php foreach ($goods_partner_blocks as $label_key => $conf) :
      if (empty($grouped_goods[$label_key])) {
        continue;
      }
    ?>
    <div class="sponsors__list">
      <h4 class="sponsors__list--type <?php echo esc_attr($conf['type_class']); ?>">
        <span><?php echo esc_html($conf['en']); ?></span>
      </h4>
      <h5 class="sponsors__list--name">
        <span><?php echo esc_html($conf['ja']); ?></span>
      </h5>
      <ul class="sponsors__list--list <?php echo esc_attr($conf['list_class']); ?>">
        <?php foreach ($grouped_goods[$label_key] as $post_id) : ?>
        <?php
          $title = get_the_title($post_id);
          $logo  = function_exists('get_field') ? get_field('sponsors_list_logo', $post_id) : '';
          $logo_url = '';
          $logo_alt = $title;
          if (is_array($logo) && !empty($logo['url'])) {
            $logo_url = $logo['url'];
            if (!empty($logo['alt'])) {
              $logo_alt = $logo['alt'];
            }
          }
          $link = function_exists('get_field') ? get_field('sponsors_list_link', $post_id) : '';
        ?>
        <li class="sponsors__list--item">
          <?php if ($link) : ?>
          <a class="sponsors__list--link" href="<?php echo esc_url($link); ?>" target="_blank"
            rel="noopener noreferrer">
            <?php if ($logo_url) : ?>
            <img class="sponsors__list--logo" src="<?php echo esc_url($logo_url); ?>"
              alt="<?php echo esc_attr($logo_alt); ?>">
            <?php endif; ?>
            <p class="sponsors__list--text"><?php echo esc_html($title); ?></p>
          </a>
          <?php else : ?>
          <?php if ($logo_url) : ?>
          <img class="sponsors__list--logo" src="<?php echo esc_url($logo_url); ?>"
            alt="<?php echo esc_attr($logo_alt); ?>">
          <?php endif; ?>
          <p class="sponsors__list--text"><?php echo esc_html($title); ?></p>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endforeach; ?>
    <h3 class="sponsors__h3">
      <span>広告協賛</span>
    </h3>
    <?php
    // 広告協賛（sponsors_advertise）の一覧取得
    $ad_partner_blocks = array(
      'special' => array(
        'type_class' => 'gold',
        'list_class' => 'lv2',
        'en'         => 'SPECIAL',
        'ja'         => 'スペシャルメディアパートナー',
      ),
      'media' => array(
        'type_class' => 'bronze',
        'list_class' => 'lv4',
        'en'         => 'MEDIA PARTNER',
        'ja'         => 'メディアパートナー',
      ),
    );
    $grouped_ads = array();
    foreach ($ad_partner_blocks as $key => $conf) {
      $grouped_ads[$key] = array();
    }
    $ad_args = array(
      'post_type'      => 'sponsors_advertise',
      'posts_per_page' => -1,
      'post_status'    => 'publish',
      'orderby'        => 'menu_order',
      'order'          => 'ASC',
    );
    $ad_query = new WP_Query($ad_args);
    if ($ad_query->have_posts()) :
      while ($ad_query->have_posts()) :
        $ad_query->the_post();
        $label_raw = function_exists('get_field') ? get_field('sponsors_label') : '';
        $label = '';
        if (is_array($label_raw)) {
          if (isset($label_raw['value'])) {
            $label = $label_raw['value'];
          } elseif (isset($label_raw['label'])) {
            $label = $label_raw['label'];
          }
        } else {
          $label = $label_raw;
        }
        if ($label === '') {
          continue;
        }
        if ($label === 'スペシャルメディアパートナー') {
          $label = 'special';
        } elseif ($label === 'メディアパートナー') {
          $label = 'media';
        }
        if (!isset($grouped_ads[$label])) {
          $grouped_ads[$label] = array();
        }
        $grouped_ads[$label][] = get_the_ID();
      endwhile; wp_reset_postdata(); endif;
    ?>
    <?php foreach ($ad_partner_blocks as $label_key => $conf) :
      if (empty($grouped_ads[$label_key])) {
        continue;
      }
    ?>
    <div class="sponsors__list">
      <h4 class="sponsors__list--type <?php echo esc_attr($conf['type_class']); ?>">
        <span><?php echo esc_html($conf['en']); ?></span>
      </h4>
      <h5 class="sponsors__list--name">
        <span><?php echo esc_html($conf['ja']); ?></span>
      </h5>
      <ul class="sponsors__list--list <?php echo esc_attr($conf['list_class']); ?>">
        <?php foreach ($grouped_ads[$label_key] as $post_id) : ?>
        <?php
          $title = get_the_title($post_id);
          $logo  = function_exists('get_field') ? get_field('sponsors_list_logo', $post_id) : '';
          $logo_url = '';
          $logo_alt = $title;
          if (is_array($logo) && !empty($logo['url'])) {
            $logo_url = $logo['url'];
            if (!empty($logo['alt'])) {
              $logo_alt = $logo['alt'];
            }
          }
          $link = function_exists('get_field') ? get_field('sponsors_list_link', $post_id) : '';
        ?>
        <li class="sponsors__list--item">
          <?php if ($link) : ?>
          <a class="sponsors__list--link" href="<?php echo esc_url($link); ?>" target="_blank"
            rel="noopener noreferrer">
            <?php if ($logo_url) : ?>
            <img class="sponsors__list--logo" src="<?php echo esc_url($logo_url); ?>"
              alt="<?php echo esc_attr($logo_alt); ?>">
            <?php endif; ?>
            <p class="sponsors__list--text"><?php echo esc_html($title); ?></p>
          </a>
          <?php else : ?>
          <?php if ($logo_url) : ?>
          <img class="sponsors__list--logo" src="<?php echo esc_url($logo_url); ?>"
            alt="<?php echo esc_attr($logo_alt); ?>">
          <?php endif; ?>
          <p class="sponsors__list--text"><?php echo esc_html($title); ?></p>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endforeach; ?>
  </section>
</article>
<?php get_footer(); ?>