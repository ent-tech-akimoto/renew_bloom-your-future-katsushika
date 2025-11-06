<?php
/*
Template Name: Event Calendar
*/
$slug = 'event';
get_header();

// 現在の年月をGETから取得。なければ現在
$year  = isset($_GET['y'])  ? (int) $_GET['y']  : (int) current_time('Y');
$month = isset($_GET['mo']) ? (int) $_GET['mo'] : (int) current_time('m');
// エリア（main / kochi / monchi / wing / iris / tora）
$area  = isset($_GET['area']) ? sanitize_text_field($_GET['area']) : '';
$base_url = get_permalink();
// 当月の1日と末日
$start_of_month = sprintf('%04d-%02d-01', $year, $month);
$end_of_month   = date('Y-m-t', strtotime($start_of_month));
// クエリを組む
$meta_query = array(
  'relation' => 'AND',
  // イベント終了日が月初以降
  array(
    'key'     => 'event_end_date',
    'value'   => $start_of_month,
    'compare' => '>=',
    'type'    => 'DATE',
  ),
  // イベント開始日が月末以前
  array(
    'key'     => 'event_start_date',
    'value'   => $end_of_month,
    'compare' => '<=',
    'type'    => 'DATE',
  ),
);

$args = array(
  'post_type'      => 'event',
  'posts_per_page' => 12,
  'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
  'orderby'        => 'meta_value',
  'meta_key'       => 'event_start_date',
  'order'          => 'ASC',
  'meta_query'     => $meta_query,
);

// エリア指定があればタクソノミーで絞る
if ( $area ) {
  $args['tax_query'] = array(
    array(
      'taxonomy' => 'event_area',
      'field'    => 'slug',
      'terms'    => $area,
    ),
  );
}

$event_query  = new WP_Query( $args );
$found_posts  = $event_query->found_posts;
$current_page = $args['paged'];
$total_pages  = $event_query->max_num_pages;
// 前月・次月のためのタイムスタンプ
$prev_ts = strtotime('-1 month', strtotime($start_of_month));
$next_ts = strtotime('+1 month', strtotime($start_of_month));
// 前月・次月のURLを作る
$prev_url = add_query_arg(
  array(
    'y'    => date('Y', $prev_ts),
    'mo'   => date('m', $prev_ts),
    'area' => $area,
  ),
  $base_url
);
$next_url = add_query_arg(
  array(
    'y'    => date('Y', $next_ts),
    'mo'   => date('m', $next_ts),
    'area' => $area,
  ),
  $base_url
);
?>
<article class="event">
  <div class="event__bg"></div>
  <p class="common-bread event__bread">
    <span>TOP</span><span>イベント情報</span>
  </p>
  <h1 class="common__h1 event__h1">イベント情報</h1>
  <section class="event__calendar-search">
    <div class="event__calendar-flex top">
      <p class="before">
        <a
          href="<?php echo esc_url( $prev_url ); ?>">＜<?php echo esc_html( (int)date('n', $prev_ts) ); ?>月/<?php echo esc_html( date('Y', $prev_ts) ); ?></a>
      </p>
      <strong><?php echo esc_html( $month ); ?>月</strong>
      <p class="after">
        <a
          href="<?php echo esc_url( $next_url ); ?>"><?php echo esc_html( (int)date('n', $next_ts) ); ?>月/<?php echo esc_html( date('Y', $next_ts) ); ?>＞</a>
      </p>
    </div>
    <div class="event__calendar-flex bot pc-none">
      <div class="event__calendar-label"></div>
      <div class="event__calendar-box">
        <span class="event__calendar-select--area main<?php if($area==='main') echo ' js-active'; ?>"
          data-area="main">メインエリア</span>
        <span class="event__calendar-select--area kochi<?php if($area==='kochi') echo ' js-active'; ?>"
          data-area="kochi">こち亀エリア</span>
        <span class="event__calendar-select--area monchi<?php if($area==='monchi') echo ' js-active'; ?>"
          data-area="monchi">モンチッチエリア</span>
        <span class="event__calendar-select--area wing<?php if($area==='wing') echo ' js-active'; ?>"
          data-area="wing">翼エリア</span>
        <span class="event__calendar-select--area iris<?php if($area==='iris') echo ' js-active'; ?>"
          data-area="iris">堀切菖蒲園</span>
        <span class="event__calendar-select--area tora<?php if($area==='tora') echo ' js-active'; ?>"
          data-area="tora">寅さんエリア</span>
      </div>
      <div class="event__form-modal area" data-modal="modal1">
        <h5 class="pc-none">イベントエリア</h5>
        <div class="event__modal-flex area pc-none">
          <div class="event__form-label area" for="eventArea"></div>
          <div class="event__form-box area">
            <span class="event__form-select--area main" data-area="main">メインエリア</span>
            <span class="event__form-select--area kochi" data-area="kochi">こち亀エリア</span>
            <span class="event__form-select--area monchi" data-area="monchi">モンチッチエリア</span>
            <span class="event__form-select--area wing" data-area="wing">翼エリア</span>
            <span class="event__form-select--area iris" data-area="iris">堀切菖蒲園</span>
            <span class="event__form-select--area tora" data-area="tora">寅さんエリア</span>
          </div>
        </div>
        <div class="event__modal-map">
          <picture>
            <img src="/assets/img/event/modal_area.png" alt="">
          </picture>
          <ul>
            <li class="main <?php if($area==='main') echo 'js-active'; ?>" data-area="main">メインエリア</li>
            <li class="tora <?php if($area==='tora') echo 'js-active'; ?>" data-area="tora">寅さんエリア</li>
            <li class="kochi <?php if($area==='kochi') echo 'js-active'; ?>" data-area="kochi">こち亀エリア</li>
            <li class="iris <?php if($area==='iris') echo 'js-active'; ?>" data-area="iris">堀切菖蒲園</li>
            <li class="wing <?php if($area==='wing') echo 'js-active'; ?>" data-area="wing">翼エリア</li>
            <li class="monchi <?php if($area==='monchi') echo 'js-active'; ?>" data-area="monchi">モンチッチエリア</li>
          </ul>
        </div>
        <button class="event__modal-map-btn" type="button">現在地付近</button>
        <button class="event__modal-btn" type="button">検索する</button>
        <button class="event__modal-next" type="button">スキップする＞</button>
        <button class="event__modal-close" type="button">
          <span></span>
          <span></span>
        </button>
      </div>
    </div>
    <form id="event-calendar-filter" action="<?php echo esc_url( $base_url ); ?>" method="get" style="display:none;">
      <input type="hidden" name="y" value="<?php echo esc_attr($year); ?>">
      <input type="hidden" name="mo" value="<?php echo esc_attr(sprintf('%02d', $month)); ?>">
      <input type="hidden" name="area" value="<?php echo esc_attr($area); ?>" class="js-calendar-area">
    </form>
  </section>
  <section class="event__box">
    <h3 class="event__h3">検索結果<span><?php echo esc_html( $found_posts ); ?></span>件</h3>
    <ul class="event__box-list">
      <?php if ( $event_query->have_posts() ) : ?>
      <?php while ( $event_query->have_posts() ) : $event_query->the_post(); ?>
      <?php
            // エリアターム
            $area_terms = get_the_terms( get_the_ID(), 'event_area' );
            $area_class = '';
            $area_label = '';
            if ( $area_terms && ! is_wp_error($area_terms) ) {
              $area_class = $area_terms[0]->slug;
              $area_label = $area_terms[0]->name;
            }
            // カテゴリターム
            $cat_terms = get_the_terms( get_the_ID(), 'event_cat' );
            // 日付
            $start = get_post_meta( get_the_ID(), 'event_start_date', true );
            $end   = get_post_meta( get_the_ID(), 'event_end_date', true );
            // 表示用の日付文字列
            $date_str = '';
            if ( $start ) {
              $date_str = date_i18n('Y年 n月j日', strtotime($start));
            }
            if ( $end && $end !== $start ) {
              $date_str .= '（～' . date_i18n('n月j日', strtotime($end)) . '）';
            }
          ?>
      <li>
        <a class="event__box-item" href="<?php the_permalink(); ?>">
          <div class="event__box-img">
            <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail('medium'); ?>
            <?php else: ?>
            <img src="/assets/img/event/thumb/1.png" alt="">
            <?php endif; ?>
          </div>
          <?php if ( $date_str ) : ?>
          <p class="event__box-date"><?php echo esc_html( $date_str ); ?></p>
          <?php endif; ?>
          <h4 class="event__box-ttl"><?php the_title(); ?></h4>
          <div class="event__box-cat">
            <?php if ( $cat_terms && ! is_wp_error($cat_terms) ) : ?>
            <?php foreach ( $cat_terms as $term ) : ?>
            <span>#<?php echo esc_html( $term->name ); ?></span>
            <?php endforeach; ?>
            <?php endif; ?>
          </div>
          <?php if ( $area_label ) : ?>
          <span class="<?php echo esc_attr($area_class); ?>"><?php echo esc_html($area_label); ?></span>
          <?php endif; ?>
        </a>
      </li>
      <?php endwhile; wp_reset_postdata(); ?>
      <?php else: ?>
      <li>この月のイベントはありません。</li>
      <?php endif; ?>
    </ul>
    <div class="event__pagination">
      <?php
      // ページネーション（数字ボタンの代わりにWP標準を流し込む）
      echo paginate_links( array(
        'total'   => $total_pages,
        'current' => $current_page,
        'mid_size'=> 1,
        'prev_text' => '',
        'next_text' => '',
      ) );
      ?>
    </div>
  </section>
  <a class="event__btn back" href="<?php echo esc_url( home_url('/event/') ); ?>"> イベント情報へもどる </a>
</article>
<?php get_footer(); ?>