<?php
/**
 * 投稿のアーカイブ (/news/)
 */
$slug = 'news';
get_header();

$cat_slug = isset($_GET['cat']) ? sanitize_text_field($_GET['cat']) : '';

$args = [
  'post_type'      => 'post',
  'posts_per_page' => 10,
  'paged'          => $paged,
];

if ($cat_slug !== '') {
  $args['tax_query'] = [
    [
      'taxonomy' => 'category',
      'field'    => 'slug',
      'terms'    => $cat_slug,
    ],
  ];
}

$news_query = new WP_Query($args);
?>

<article class="news__wrapper">
  <div class="news__bg"></div>
  <p class="common__bread">
    <span><a href="/">TOP</a></span><span>お知らせ</span>
  </p>
  <h1 class="news__h1">お知らせ</h1>
  <section class="news__form">
    <?php
// GETから現在のカテゴリ slug を取得
$current_cat_slug = isset($_GET['cat']) ? sanitize_text_field($_GET['cat']) : '';

// 表示用のカテゴリ名
$current_cat_name = '';
if ($current_cat_slug !== '') {
  // slug から term を取得
  $current_term = get_term_by('slug', $current_cat_slug, 'category');
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
    <div id="search"></div>
    <form class="news__form-wrapper" method="get" action="">
      <div class="news__form-flex cate">
        <!-- GET ?cat=slug -->
        <input type="hidden" name="cat" id="cateInput" value="<?php echo esc_attr($current_cat_slug); ?>">

        <div class="news__form-label cate"></div>

        <!-- ▼ 検索後はここに選択カテゴリ名が表示される -->
        <div class="news__form-box cate">
          <span class="news__form-select">
            <?php echo esc_html($current_cat_name); ?>
          </span>
        </div>

        <div class="news__form-modal cate" data-modal="modal3">
          <div class="news__modal-flex cate">
            <div class="news__form-label cate"></div>
            <div class="news__form-box cate in-modal">
              <!-- モーダル内の見出し側にも同じく表示しておく -->
              <span class="news__form-select">
                <?php echo esc_html($current_cat_name); ?>
              </span>
            </div>
          </div>

          <ul class="news__modal-cate">
            <?php if (!is_wp_error($news_cats) && !empty($news_cats)) : ?>
            <?php foreach ($news_cats as $term) : ?>
            <?php $is_active = ($current_cat_slug === $term->slug); ?>
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
  </section>
  <section class="news__section">
    <?php if (have_posts()) : ?>
    <div class="news__list">
      <?php
        $new_days   = 7;
        $now_local  = current_time('timestamp');
        while (have_posts()) :
          the_post();
          $published_local = get_post_time('U');
          $is_published    = (get_post_status() === 'publish');
          $is_new          = $is_published && (($now_local - $published_local) < ($new_days * DAY_IN_SECONDS));
          $categories = get_the_category();
          ?>
      <div class="news__box<?php echo $is_new ? ' new' : ''; ?>">
        <a href="<?php the_permalink(); ?>" class="news__link">
          <div class="news__cate">
            <?php
                if ($categories && !is_wp_error($categories)) :
                  foreach ($categories as $cat) : ?>
            <p class="<?php echo esc_attr($cat->slug); ?>">#<?php echo esc_html($cat->name); ?></p>
            <?php
                  endforeach;
                endif;
                ?>
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
    <div class="news__pagination">
      <button class="arrow-before" type="button"></button>
      <button class="active" type="button">1</button>
      <button type="button">2</button>
      <button type="button">3</button>
      <button class="small" type="button"></button>
      <button class="small" type="button"></button>
      <button class="small" type="button"></button>
      <button class="arrow-next" type="button"></button>
    </div>
    <?php else : ?>
    <p class="news__zero-txt">該当するお知らせはありませんでした。</p>
    <?php endif; ?>
  </section>
</article>
<?php get_footer(); ?>