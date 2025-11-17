<?php
/*
Template Name: イベントカレンダー
*/
$slug = 'calendar';
get_header();

$paged = 1;
if ( isset($_GET['paged']) && (int) $_GET['paged'] > 1 ) {
  $paged = (int) $_GET['paged'];
}

// パラメータを拾う ?y=2025&mo=12&area=14,15
$year  = isset($_GET['y'])  ? (int) $_GET['y']  : (int) current_time('Y');
$month = isset($_GET['mo']) ? (int) $_GET['mo'] : (int) current_time('m');
$area_param = isset($_GET['area']) ? sanitize_text_field($_GET['area']) : '';
$area_order = isset($_GET['area_order']) ? sanitize_text_field($_GET['area_order']) : '';
$base_url   = get_permalink();
$area_ids = [];
if ($area_param !== '') {
  $area_ids = array_map('intval', explode(',', $area_param));
  $area_ids = array_values(array_filter($area_ids, function($v){
    return $v > 0;
  }));
}
// Ymd format
$start_of_month_date = sprintf('%04d-%02d-01', $year, $month);
$end_of_month_date   = date('Y-m-t', strtotime($start_of_month_date));
$start_of_month = date('Ymd', strtotime($start_of_month_date));
$end_of_month   = date('Ymd', strtotime($end_of_month_date));
// クエリ「終了日が月初以降」かつ「開始日が月末以前」ならその月にかぶっているとみなす
$meta_query = [
  'relation' => 'AND',
  [
    'key'     => 'event_end_date',
    'value'   => $start_of_month,
    'compare' => '>=',
    'type'    => 'NUMERIC',
  ],
  [
    'key'     => 'event_start_date',
    'value'   => $end_of_month,
    'compare' => '<=',
    'type'    => 'NUMERIC',
  ],
];

// WP_Query
$args = [
  'post_type'      => 'event',
  'post_status'    => 'publish',
  'posts_per_page' => 9,
  'paged'          => $paged,
  'orderby'        => 'meta_value_num',
  'meta_key'       => 'event_start_date',
  'order'          => 'ASC',
  'meta_query'     => $meta_query,
];
// エリア絞る
if (!empty($area_ids)) {
  $args['tax_query'] = [
    [
      'taxonomy' => 'event_area',
      'field'    => 'term_id',
      'terms'    => $area_ids,
    ],
  ];
}

// 現在地
global $event_area_order_for_archive;
$event_area_order_for_archive = $area_ids;
if (!empty($area_ids) && $area_order === 'nearby') {
  add_filter('posts_clauses', 'my_event_order_by_area_tax', 10, 2);
}
$event_query  = new WP_Query($args);
if (!empty($area_ids) && $area_order === 'nearby') {
  remove_filter('posts_clauses', 'my_event_order_by_area_tax', 10);
}
$found_posts  = $event_query->found_posts;
$total_pages  = (int) $event_query->max_num_pages;

// 前月・次月のURL
$prev_ts = strtotime('-1 month', strtotime($start_of_month_date));
$next_ts = strtotime('+1 month', strtotime($start_of_month_date));

$prev_args = [
  'y'  => date('Y', $prev_ts),
  'mo' => date('n', $prev_ts),
];
if ($area_param !== '') {
  $prev_args['area'] = $area_param;
}
if ($area_order === 'nearby') {
  $prev_args['area_order'] = 'nearby';
}
$prev_url = add_query_arg($prev_args, $base_url);

$next_args = [
  'y'  => date('Y', $next_ts),
  'mo' => date('n', $next_ts),
];
if ($area_param !== '') {
  $next_args['area'] = $area_param;
}
if ($area_order === 'nearby') {
  $next_args['area_order'] = 'nearby';
}
$next_url = add_query_arg($next_args, $base_url);

// エリア一覧（表示用）
$areas = get_terms([
  'taxonomy'   => 'event_area',
  'hide_empty' => false,
  'orderby'    => 'term_id',
  'order'      => 'ASC',
]);
?>
<article class="event__wrapper">
  <div class="event__bg"></div>
  <p class="common__bread l-page">
    <span><a href="<?php echo esc_url(home_url('/')); ?>">TOP</a></span><span>イベントカレンダー</span>
  </p>
  <h1 class="common__h1 event__h1">イベントカレンダー</h1>
  <div id="search"></div>
  <form class="event__calendar-search" action="<?php echo esc_url($base_url); ?>#search" method="get">
    <div class="event__calendar-flex top">
      <input type="hidden" name="y" value="<?php echo esc_attr($year); ?>">
      <input type="hidden" name="mo" value="<?php echo esc_attr($month); ?>">
      <p class="before">
        <a href="<?php echo esc_url($prev_url); ?>">＜<?php echo esc_html(date('n', $prev_ts)); ?>月/<?php echo esc_html(date('Y', $prev_ts)); ?>
        </a>
      </p>
      <strong><?php echo esc_html($month); ?>月</strong>
      <p class="after">
        <a href="<?php echo esc_url($next_url); ?>">
          <?php echo esc_html(date('n',$next_ts)); ?>月/<?php echo esc_html(date('Y',$next_ts)); ?>＞</a>
      </p>
    </div>
    <div id="search"></div>
    <div class="event__calendar-flex area bot pc-none">
      <input type="hidden" name="area" id="areaInput" value="<?php echo esc_attr($area_param); ?>">
      <input type="hidden" name="area_order" id="areaOrderInput"
        value="<?php echo $area_order === 'nearby' ? 'nearby' : ''; ?>">
      <div class="event__calendar-label"></div>
      <div class="event__calendar-box area">
        <?php if (!is_wp_error($areas) && !empty($areas)): ?>
        <?php foreach ($areas as $area_term): ?>
        <?php
          $is_active = empty($area_ids) || in_array($area_term->term_id, $area_ids, true);
        ?>
        <span class="event__calendar-select--area<?php echo $is_active ? ' js-active' : ''; ?>"
          data-area="<?php echo esc_attr($area_term->slug); ?>" data-id="<?php echo esc_attr($area_term->term_id); ?>">
          <?php echo esc_html($area_term->name); ?>
        </span>
        <?php endforeach; ?>
        <?php else: ?>
        <span class="event__calendar-select--area">エリア</span>
        <?php endif; ?>
      </div>
      <div class="event__form-modal area" data-modal="modal1">
        <h5 class="pc-none">イベントエリア</h5>
        <div class="event__modal-flex area pc-none">
          <div class="event__form-label area" for="eventArea"></div>
          <div class="event__form-box area in-modal">
            <?php if (!is_wp_error($areas) && !empty($areas)): ?>
            <?php foreach ($areas as $area_term): ?>
            <?php $is_active = empty($area_ids) || in_array($area_term->term_id, $area_ids, true); ?>
            <span class="event__form-select--area<?php echo $is_active ? ' js-active' : ''; ?>"
              data-area="<?php echo esc_attr($area_term->slug); ?>"
              data-id="<?php echo esc_attr($area_term->term_id); ?>">
              <?php echo esc_html($area_term->name); ?>
            </span>
            <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
        <div class="event__modal-map">
          <picture>
            <img src="/assets/img/event/modal_area.png" alt="">
          </picture>
          <ul>
            <?php if (!is_wp_error($areas) && !empty($areas)): ?>
            <?php foreach ($areas as $area_term): ?>
            <?php $is_active = empty($area_ids) || in_array($area_term->term_id, $area_ids, true); ?>
            <li class="map-btn<?php echo $is_active ? ' js-active' : ''; ?>"
              data-area="<?php echo esc_attr($area_term->slug); ?>"
              data-id="<?php echo esc_attr($area_term->term_id); ?>">
              <?php echo esc_html($area_term->name); ?>
            </li>
            <?php endforeach; ?>
            <?php endif; ?>
          </ul>
          <div class="event__modal-map--loading">
            <span>現在位置を取得しています</span>
          </div>
        </div>
        <button class="event__modal-map-btn" type="button">現在地付近</button>
        <button class="common__btn-i event__modal-btn" type="submit">検索する</button>
        <button class="event__modal-next" type="button">スキップする＞</button>
        <button class="event__modal-close" type="button">
          <span></span>
          <span></span>
        </button>
      </div>
    </div>
  </form>
  <a class="event__form-btn" href="/event-calendar#search">条件を初期化</a>
  <section class="event__box">
    <h3 class="event__h3">検索結果<span><?php echo esc_html($found_posts); ?></span>件</h3>
    <ul class="event__box-list">
      <?php if ($event_query->have_posts()) : ?>
      <?php while ($event_query->have_posts()) : $event_query->the_post(); ?>
      <?php
          $area_terms = get_the_terms(get_the_ID(), 'event_area');
          $area_slug  = '';
          $area_name  = '';
          if ($area_terms && !is_wp_error($area_terms)) {
            $area_slug = $area_terms[0]->slug;
            $area_name = $area_terms[0]->name;
          }
          $cat_terms = get_the_terms(get_the_ID(), 'event_cat');
          $start_raw = get_post_meta(get_the_ID(), 'event_start_date', true);
          $end_raw   = get_post_meta(get_the_ID(), 'event_end_date', true);
          $date_str = '';
          if ($start_raw) {
            $date_str = date_i18n('Y年 n月j日', strtotime($start_raw));
          }
          if ($end_raw && $end_raw !== $start_raw) {
            $date_str .= '（～' . date_i18n('n月j日', strtotime($end_raw)) . '）';
          }
          ?>
      <li>
        <a class="event__box-item" href="<?php the_permalink(); ?>">
          <div class="event__box-img">
            <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('medium'); ?>
            <?php else: ?>
            <img src="/assets/img/common/thumbnail.png" alt="">
            <?php endif; ?>
          </div>
          <p class="event__box-date">
            <?php
            $event_period = function_exists('get_field') ? get_field('event_period') : '';
            if (!empty($event_period)) {
              echo esc_html($event_period);
            } else {
              echo esc_html(get_the_date('Y年n月j日'));
            }
            ?>
          </p>
          <h4 class="event__box-ttl"><?php the_title(); ?></h4>
          <?php if ($cat_terms && !is_wp_error($cat_terms)) : ?>
          <div class="event__box-cat">
            <?php foreach ($cat_terms as $ct) : ?>
            <span>#<?php echo esc_html($ct->name); ?></span>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
          <?php if ($area_name) : ?>
          <span class="<?php echo esc_attr($area_slug); ?>"><?php echo esc_html($area_name); ?></span>
          <?php endif; ?>
        </a>
      </li>
      <?php endwhile; wp_reset_postdata(); ?>
      <?php else: ?>
      <li class="event__zero-txt">この月のイベントはありません。</li>
      <?php endif; ?>
    </ul>
    <?php
    // ページネーション
    if ($total_pages > 1) :
      $current = (int) $paged;
    // ベースURL（/event-calendar/）
    $base_url = get_permalink();
    // 今のクエリ文字列を丸ごとベースにする（area, area_order など全部含める）
    $base_args = $_GET;
    // page / paged はこれから上書きするので削除
    unset($base_args['paged'], $base_args['paged']);
    $base_args['y']  = $year;
    $base_args['mo'] = $month;
    if ($area_param !== '') {
      $base_args['area'] = $area_param;
    }
    if ($area_order === 'nearby') {
      $base_args['area_order'] = 'nearby';
    }
    // 表示数（3つ）
    $show_max = 3;
    $start = max(1, $current - 1);
    $end   = min($total_pages, $start + $show_max - 1);
    if (($end - $start + 1) < $show_max) {
      $start = max(1, $end - $show_max + 1);
    }
    ?>
    <div class="event__pagination">
      <?php
      // ← prev
      if ($current > 1) {
        $prev_args = $base_args;
        $prev_args['paged'] = $current - 1;
        $prev_page_url = add_query_arg($prev_args, $base_url);
        echo '<button class="arrow-before" type="button" onclick="location.href=\'' . esc_url($prev_page_url) . '\'"></button>';
      }
      // 中央の数字
      for ($i = $start; $i <= $end; $i++) {
        $page_args = $base_args;
        $page_args['paged'] = $i;
        $page_url  = add_query_arg($page_args, $base_url);
        $active    = ($i === $current) ? 'active' : '';
        echo '<button class="' . esc_attr($active) . '" type="button" onclick="location.href=\'' . esc_url($page_url) . '\'">' . esc_html($i) . '</button>';
      }
      if ($end < $total_pages) {
        echo '<button class="small" type="button"></button>';
        echo '<button class="small" type="button"></button>';
        echo '<button class="small" type="button"></button>';
      }
      // → next
      if ($current < $total_pages) {
        $next_args = $base_args;
        $next_args['paged'] = $current + 1;
        $next_page_url = add_query_arg($next_args, $base_url);
        echo '<button class="arrow-next" type="button" onclick="location.href=\'' . esc_url($next_page_url) . '\'"></button>';
      }
      ?>
    </div>
    <?php endif; ?>
  </section>
  <a class="event__btn back" href="<?php echo esc_url(home_url('/event/')); ?>">イベント情報へもどる</a>
</article>
<?php get_footer(); ?>