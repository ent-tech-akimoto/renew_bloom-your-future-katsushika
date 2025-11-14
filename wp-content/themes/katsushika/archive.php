<?php
/**
 * 投稿のアーカイブ (/news/)
 */
$slug = 'news';
get_header();

$paged = 1;
if (isset($_GET['page'])) {
  $paged = max(1, (int) $_GET['page']);
}

$cat_param = isset($_GET['cat']) ? sanitize_text_field($_GET['cat']) : '';
$cat_ids   = [];

if ($cat_param !== '') {
  $cat_ids = array_map('intval', explode(',', $cat_param));
  $cat_ids = array_values(array_filter($cat_ids, function($v) {
    return $v > 0;
  }));
}

$args = [
  'post_type'      => 'post',
  'posts_per_page' => 10,
  'paged'          => $paged,
];

if (!empty($cat_ids)) {
  $args['tax_query'] = [
    [
      'taxonomy' => 'category',
      'field'    => 'term_id',
      'terms'    => $cat_ids,
      'operator' => 'IN',//いずれかに属する投稿を取得
    ],
  ];
}

$news_query = new WP_Query($args);
$total_pages = (int) $news_query->max_num_pages;
?>

<article class="news__wrapper">
  <div class="news__bg"></div>
  <p class="common__bread">
    <span><a href="/">TOP</a></span><span>お知らせ</span>
  </p>
  <h1 class="news__h1">お知らせ</h1>
  <div id="search"></div>
  <section class="news__form">
    <?php
    $current_cat_param = isset($_GET['cat']) ? sanitize_text_field($_GET['cat']) : '';
    $current_cat_name = '';
    if ($current_cat_param !== '') {
      $first_part = explode(',', $current_cat_param)[0];
      if (ctype_digit($first_part)) {
        $current_term = get_term((int) $first_part, 'category');
      } else {
        $current_term = get_term_by('slug', $first_part, 'category');
      }
      if ($current_term && !is_wp_error($current_term)) {
        $current_cat_name = $current_term->name;
      }
    }
    // 投稿カテゴリ一覧
    $news_cats = get_terms([
      'taxonomy'   => 'category',
      'hide_empty' => false,
      'orderby'    => 'term_id',
      'order'      => 'ASC',
    ]);
    ?>
    <form class="news__form-wrapper" method="get" action="#search">
      <div class="news__form-flex cate">
        <input type="hidden" name="cat" id="cateInput" value="<?php echo esc_attr($current_cat_param); ?>">
        <div class="news__form-label cate"></div>
        <div class="news__form-box cate">
          <?php if (!is_wp_error($news_cats) && !empty($news_cats)) : ?>
          <?php foreach ($news_cats as $term) : ?>
          <span class="news__form-select" data-cat="<?php echo esc_attr($term->slug); ?>"
            data-id="<?php echo esc_attr($term->term_id); ?>">
            <?php echo esc_html($term->name); ?>
          </span>
          <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <div class="news__form-modal cate" data-modal="modal3">
          <div class="news__modal-flex cate">
            <div class="news__form-label cate"></div>
            <div class="news__form-box cate in-modal">
              <span class="news__form-select">
                <?php echo esc_html($current_cat_name); ?>
              </span>
            </div>
          </div>
          <ul class="news__modal-cate">
            <?php if (!is_wp_error($news_cats) && !empty($news_cats)) : ?>
            <?php foreach ($news_cats as $term) : ?>
            <?php
              $selected_ids = [];
              if ($current_cat_param !== '') {
                $selected_ids = array_map('intval', explode(',', $current_cat_param));
              }
              $is_active = in_array((int) $term->term_id, $selected_ids, true);
              ?>
            <li class="cat-btn<?php echo $is_active ? ' js-active' : ''; ?>"
              data-cat="<?php echo esc_attr($term->slug); ?>" data-id="<?php echo esc_attr($term->term_id); ?>">
              <?php echo esc_html($term->name); ?>
            </li>
            <?php endforeach; ?>
            <?php endif; ?>
          </ul>
          <button class="common__btn-i news__modal-btn" type="submit">検索する</button>
          <button class="news__modal-close" type="button">
            <span></span>
            <span></span>
          </button>
        </div>
      </div>
    </form>
    <a class="news__form-btn" href="/news#search">条件を初期化</a>
  </section>
  <section class="news__section">
    <?php if ($news_query->have_posts()) : ?>
    <div class="news__list">
      <?php
        $new_days   = 7;
        $now_local  = current_time('timestamp');

        while ($news_query->have_posts()) :
          $news_query->the_post();

          $published_local = get_post_time('U');
          $is_published    = (get_post_status() === 'publish');
          $is_new          = $is_published && (($now_local - $published_local) < ($new_days * DAY_IN_SECONDS));
          $categories      = get_the_category();
        ?>
      <div class="news__box<?php echo $is_new ? ' new' : ''; ?>">
        <a href="<?php the_permalink(); ?>" class="news__link">
          <div class="news__cate">
            <?php
            if ($categories && !is_wp_error($categories)) :
              foreach ($categories as $cat) : ?>
            <p class="<?php echo esc_attr($cat->slug); ?>">#<?php echo esc_html($cat->name); ?></p>
            <?php endforeach; endif; ?>
          </div>
          <div class="news__txt">
            <div class="news__date">
              <span><?php echo esc_html(get_the_date('Y年')); ?></span>
              <span><?php echo esc_html(get_the_date('n月j日')); ?></span>
            </div>
            <p><?php the_title(); ?></p>
          </div>
        </a>
      </div>
      <?php endwhile; ?>
    </div>
    <?php
    // ページネーション
    if ($total_pages > 1) :
      $current  = (int) $paged;
      $base_url = home_url('/news/');
      $base_args = [];
      if (!empty($current_cat_param)) {
        $base_args['cat'] = $current_cat_param;
      }
      $show_max = 3;
      $start = max(1, $current - 1);
      $end   = min($total_pages, $start + $show_max - 1);
      if (($end - $start + 1) < $show_max) {
        $start = max(1, $end - $show_max + 1);
      }
    ?>
    <div class="news__pagination">
      <?php
      // ← 前へ
      if ($current > 1) {
        $prev_args = $base_args;
        $prev_args['page'] = $current - 1;
        $prev_url  = add_query_arg($prev_args, $base_url);
        echo '<button class="arrow-before" type="button" onclick="location.href=\'' . esc_url($prev_url) . '\'"></button>';
      }
      // 番号ボタン
      for ($i = $start; $i <= $end; $i++) {
        $page_args = $base_args;
        $page_args['page'] = $i;
        $page_url  = add_query_arg($page_args, $base_url);
        $active    = ($i === $current) ? 'active' : '';
        echo '<button class="' . esc_attr($active) . '" type="button" onclick="location.href=\'' . esc_url($page_url) . '\'">' . esc_html($i) . '</button>';
      }
      if ($end < $total_pages) {
        echo '<button class="small" type="button"></button>';
        echo '<button class="small" type="button"></button>';
        echo '<button class="small" type="button"></button>';
      }
      // → 次へ
      if ($current < $total_pages) {
        $next_args = $base_args;
        $next_args['page'] = $current + 1;
        $next_url  = add_query_arg($next_args, $base_url);
        echo '<button class="arrow-next" type="button" onclick="location.href=\'' . esc_url($next_url) . '\'"></button>';
      }
    ?>
    </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
    <?php else : ?>
    <p class="news__zero-txt">該当するお知らせはありませんでした。</p>
    <?php endif; ?>
  </section>
</article>
<?php get_footer(); ?>