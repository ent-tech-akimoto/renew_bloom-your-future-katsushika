<?php
/**
 * カスタム投稿タイプ「event」のアーカイブ
 */
$slug = 'event';
get_header();

// --- GET値を受け取る ------------------------------------------
// エリア
$area_param = isset($_GET['area']) ? sanitize_text_field($_GET['area']) : '';
$area_ids   = [];
if ($area_param !== '') {
  $area_ids = array_map('intval', explode(',', $area_param));
  $area_ids = array_values(array_filter($area_ids, function($v){
    return $v > 0;
  }));
}
// 開始日・終了日
$from_d = isset($_GET['from']) ? sanitize_text_field($_GET['from']) : '';
$to_d   = isset($_GET['to'])   ? sanitize_text_field($_GET['to'])   : '';
// カテゴリー
$cat_param = isset($_GET['ev_cat']) ? sanitize_text_field($_GET['ev_cat']) : '';
$cat_ids   = [];
if ($cat_param !== '') {
  $cat_ids = array_map('intval', explode(',', $cat_param));
  $cat_ids = array_values(array_filter($cat_ids, function($v){
    return $v > 0;
  }));
}
// フリーワード
$keyword  = isset($_GET['keyword']) ? sanitize_text_field($_GET['keyword']) : '';

// ページング
$paged = max(1, get_query_var('paged'), get_query_var('page'));

// tax_query（エリア・カテゴリが送られてきたときだけ）
$tax_query = ['relation' => 'AND'];

if (!empty($area_ids)) {
  $tax_query[] = [
    'taxonomy' => 'event_area',
    'field'    => 'term_id',
    'terms'    => $area_ids,
  ];
}

if (!empty($cat_ids)) {
  $tax_query[] = [
    'taxonomy' => 'event_cat',
    'field'    => 'term_id',
    'terms'    => $cat_ids,
  ];
}

// 基本の引数（開催日で並べる）
$args = [
  'post_type'      => 'event',
  'post_status'    => 'publish',
  'posts_per_page' => 9,
  'paged'          => $paged,
  'meta_key'       => 'event_start_date',
  'orderby'        => 'meta_value_num',
  'order'          => 'ASC',
];

if ( !empty($area_ids) || !empty($cat_ids) ) {
  $args['tax_query'] = $tax_query;
}

if ($keyword) {
  $args['s'] = $keyword;
}

// 日付で絞る（期間がかぶっているイベントを取る想定）
$meta_query = [];

if ($from_d) {
  $from_ymd = date('Ymd', strtotime($from_d));
  $meta_query[] = [
    'key'     => 'event_end_date',
    'value'   => $from_ymd,
    'compare' => '>=',
    'type'    => 'NUMERIC',
  ];
}

if ($to_d) {
  $to_ymd = date('Ymd', strtotime($to_d));
  $meta_query[] = [
    'key'     => 'event_start_date',
    'value'   => $to_ymd,
    'compare' => '<=',
    'type'    => 'NUMERIC',
  ];
}

if (!empty($meta_query)) {
  if (count($meta_query) > 1) {
    $meta_query['relation'] = 'AND';
  }
  $args['meta_query'] = $meta_query;
}

$event_query = new WP_Query($args);
$found = $event_query->found_posts;
?>

<article class="event__wrapper">
  <div class="event__bg"></div>
  <p class="common-bread event__bread">
    <span><a href="<?php echo esc_url( home_url('/') ); ?>">TOP</a></span><span>イベント情報</span>
  </p>
  <h1 class="common__h1 event__h1">イベント情報</h1>

  <div class="event__switch">
    <a id="event-calendar" class="event__switch-btn" href="<?php echo esc_url( home_url('/event-calendar/') ); ?>">
      イベントカレンダー<br class="pc-none">から探す
    </a>
    <a id="event-detail" class="event__switch-btn js-active"
      href="<?php echo esc_url( get_post_type_archive_link('event') ); ?>">
      詳細を探す
    </a>
  </div>
  <section class="event__calendar">
    <h2 class="event__h2">イベントカレンダーから探す</h2>
    <a class="common__btn-i event__btn" href="<?php echo esc_url( home_url('/event-calendar/') ); ?>"> 各月毎のイベントはこちら </a>
  </section>
  <section class="event__form">
    <h2 class="event__h2">詳細から探す</h2>
    <form class="event__form-wrapper" method="get"
      action="<?php echo esc_url( get_post_type_archive_link('event') ); ?>">
      <div class="event__form-flex area">
        <input type="hidden" name="area" id="areaInput" value="<?php echo esc_attr($area_param); ?>">
        <div class="event__form-label area"></div>
        <div class="event__form-box area">
          <?php
          $areas = get_terms([
            'taxonomy'   => 'event_area',
            'hide_empty' => false,
            'orderby'    => 'term_id',
            'order'      => 'ASC',
          ]);
          if ( ! is_wp_error($areas) && ! empty($areas) ) :
            if ( !empty($area_ids) ) {
              foreach ($areas as $area) {
                if ( in_array($area->term_id, $area_ids, true) ) {
                  ?>
          <span class="event__form-select--area js-active" data-area="<?php echo esc_attr($area->slug); ?>"
            data-id="<?php echo esc_attr($area->term_id); ?>">
            <?php echo esc_html($area->name); ?>
          </span>
          <?php
                }
              }
            } else {
              foreach ($areas as $area) {
                ?>
          <span class="event__form-select--area js-active" data-area="<?php echo esc_attr($area->slug); ?>"
            data-id="<?php echo esc_attr($area->term_id); ?>">
            <?php echo esc_html($area->name); ?>
          </span>
          <?php
              }
            }
          endif;
          ?>
        </div>
        <div class="event__form-modal area" data-modal="modal1">
          <h5 class="pc-none">イベントエリア</h5>
          <div class="event__modal-flex area pc-none">
            <div class="event__form-label area"></div>
            <div class="event__form-box area in-modal">
              <?php
              $areas = get_terms([
                'taxonomy'   => 'event_area',
                'hide_empty' => false,
                'orderby'    => 'term_id',
                'order'      => 'ASC',
              ]);
              if ( ! is_wp_error($areas) && ! empty($areas) ) :
                foreach ($areas as $area) :
                  $active_class = '';
              ?>
              <span class="event__form-select--area<?php echo $active_class; ?>"
                data-area="<?php echo esc_attr($area->slug); ?>" data-id="<?php echo esc_attr($area->term_id); ?>">
                <?php echo esc_html($area->name); ?>
              </span>
              <?php
                endforeach;
              endif;
              ?>
            </div>
          </div>
          <div class="event__modal-map">
            <picture>
              <img src="/assets/img/event/modal_area.png" alt="">
            </picture>
            <ul>
              <?php if ( ! is_wp_error($areas) && ! empty($areas) ) : ?>
              <?php foreach ($areas as $area) : ?>
              <?php $is_active = empty($area_ids) || in_array($area->term_id, $area_ids, true); ?>
              <li class="map-btn<?php echo $is_active ? ' js-active' : ''; ?>"
                data-area="<?php echo esc_attr($area->slug); ?>" data-id="<?php echo esc_attr($area->term_id); ?>">
                <?php echo esc_html($area->name); ?>
              </li>
              <?php endforeach; ?>
              <?php endif; ?>
            </ul>
          </div>
          <button class="common__btn-w event__modal-map-btn" type="button"> 現在地付近 </button>
          <button class="common__btn-i event__modal-btn" type="submit"> 検索する </button>
          <button class="event__modal-next" type="button"> スキップする＞ </button>
          <button class="event__modal-close" type="button">
            <span></span>
            <span></span>
          </button>
        </div>
      </div>
      <div class="event__form-flex date">
        <input type="hidden" name="from" id="startDateInput" value="<?php echo esc_attr($from_d); ?>">
        <input type="hidden" name="to" id="endDateInput" value="<?php echo esc_attr($to_d); ?>">
        <div class="event__form-label date"></div>
        <div class="event__form-box date">
          <div class="event__date-start">
            <strong>開始日</strong>
            <p><?php echo $from_d ? esc_html($from_d) : '-'; ?></p>
          </div>
          <div class="event__date-wave">～</div>
          <div class="event__date-end">
            <strong>終了日</strong>
            <p><?php echo $to_d ? esc_html($to_d) : '-'; ?></p>
          </div>
        </div>
        <div class="event__form-modal date" data-modal="modal2">
          <h5 class="pc-none">日付</h5>
          <div class="event__modal-flex date">
            <div class="event__form-label date"></div>
            <div class="event__form-box date in-modal">
              <div class="event__date-start">
                <strong>開始日</strong>
                <p>-</p>
              </div>
              <div class="event__date-wave">～</div>
              <div class="event__date-end">
                <strong>終了日</strong>
                <p>-</p>
              </div>
            </div>
          </div>
          <div class="event__modal-date">
            <div class="event__date-flex top">
              <div class="event__modal-date-start">
                <p>開始日</p>
                <div class="event__modal-date-show">
                  <strong class="">
                    <?php echo $from_d ? esc_html( date('j', strtotime($from_d)) ) : '-';?>
                  </strong>
                  <div>
                    <p class="day">
                      <?php echo $from_d ? esc_html( date_i18n('D', strtotime($from_d)) ) : '';?>
                    </p>
                    <p class="month">
                      <?php echo $from_d ? esc_html( date_i18n('n月', strtotime($from_d)) ) : '';?>
                    </p>
                  </div>
                </div>
              </div>
              <div class="event__modal-date-arrow"></div>
              <div class="event__modal-date-end">
                <p>終了日</p>
                <div class="event__modal-date-show">
                  <strong class="">
                    <?php echo $to_d ? esc_html( date('j', strtotime($to_d)) ) : '-'; ?>
                  </strong>
                  <div>
                    <p class="day">
                      <?php echo $to_d ? esc_html( date_i18n('D', strtotime($to_d)) ) : ''; ?>
                    </p>
                    <p class="month">
                      <?php echo $to_d ? esc_html( date_i18n('n月', strtotime($to_d)) ) : ''; ?>
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="event__date-flex bot">
              <button class="sp-none" type="button">本日</button>
              <div class="event__modal-date-cal left-side">
                <div class="event__date-control before">
                  <button class="event__date-btn before" type="button"></button>
                  <p class="label"></p>
                  <button class="event__date-btn after" type="button"></button>
                </div>
                <div class="event__modal-date-days">
                  <span>日</span>
                  <span>月</span>
                  <span>火</span>
                  <span>水</span>
                  <span>木</span>
                  <span>金</span>
                  <span>土</span>
                </div>
                <div class="event__modal-date-dates"></div>
              </div>
              <div class="event__modal-date-cal right-side sp-none">
                <div class="event__date-control after">
                  <button class="event__date-btn before" type="button"></button>
                  <p class="label"></p>
                  <button class="event__date-btn after" type="button"></button>
                </div>
                <div class="event__modal-date-days">
                  <span>日</span>
                  <span>月</span>
                  <span>火</span>
                  <span>水</span>
                  <span>木</span>
                  <span>金</span>
                  <span>土</span>
                </div>
                <div class="event__modal-date-dates"></div>
              </div>
            </div>
          </div>
          <button class="common__btn-i event__modal-btn" type="submit"> 検索する </button>
          <button class="event__modal-next" type="button"> スキップする＞ </button>
          <button class="event__modal-close" type="button">
            <span></span>
            <span></span>
          </button>
        </div>
      </div>
      <div class="event__form-flex cate">
        <input type="hidden" name="ev_cat" id="cateInput" value="<?php echo esc_attr($cat_param); ?>">
        <div class="event__form-label cate"></div>
        <div class="event__form-box cate">
          <?php
          if ( !empty($cat_ids) ) {
            $terms_to_show = get_terms([
              'taxonomy'   => 'event_cat',
              'hide_empty' => false,
              'include'    => $cat_ids,
            ]);
            if ( !is_wp_error($terms_to_show) && !empty($terms_to_show) ) {
              foreach ($terms_to_show as $t) {
                echo '<span class="event__form-select js-active" data-cat="'.esc_attr($t->slug).'" data-id="'.esc_attr($t->term_id).'">'.esc_html($t->name).'</span>';
              }
            }
          } else {
            echo '<span class="event__form-select">カテゴリー</span>';
          }
          ?>
        </div>

        <div class="event__form-modal cate" data-modal="modal3">
          <h5 class="pc-none">カテゴリー</h5>
          <div class="event__modal-flex cate">
            <div class="event__form-label cate"></div>
            <div class="event__form-box cate in-modal">
              <span class="event__form-select">カテゴリー</span>
            </div>
          </div>
          <ul class="event__modal-cate">
            <?php
            $cats = get_terms([
              'taxonomy'   => 'event_cat',
              'hide_empty' => false,
              'orderby'    => 'term_id',
              'order'      => 'ASC',
            ]);
            if ( !is_wp_error($cats) && !empty($cats) ) :
              foreach ($cats as $cat) :
                $is_active = !empty($cat_ids) && in_array($cat->term_id, $cat_ids, true);
                ?>
            <li class="cat-btn<?php echo $is_active ? ' js-active' : ''; ?>"
              data-cat="<?php echo esc_attr($cat->slug); ?>" data-id="<?php echo esc_attr($cat->term_id); ?>">
              <?php echo esc_html($cat->name); ?>
            </li>
            <?php
              endforeach;
            endif;
            ?>
          </ul>
          <button class="common__btn-i event__modal-btn" type="submit">検索する</button>
          <button class="event__modal-next" type="button">スキップする＞</button>
          <button class="event__modal-close" type="button"><span></span><span></span></button>
        </div>
      </div>
      <div class="event__form-flex word">
        <div class="event__form-label word"></div>
        <textarea class="event__form-box word" placeholder="フリーワード" rows="1"
          name="keyword"><?php echo esc_textarea($keyword); ?></textarea>
        <div class="event__form-modal word" data-modal="modal4">
          <h5>フリーワード</h5>
          <div class="event__modal-flex word">
            <div class="event__form-label word in-modal"></div>
            <textarea class="event__form-box word" placeholder="フリーワード" rows="1"></textarea>
          </div>
          <ul class="event__modal-word"></ul>
          <button class="common__btn-i event__modal-btn" type="submit">検索する</button>
          <button class="event__modal-next" type="button">スキップする＞</button>
          <button class="event__modal-close" type="button">
            <span></span><span></span>
          </button>
        </div>
      </div>
    </form>
  </section>
  <section class="event__box">
    <h3 class="event__h3">検索結果<span><?php echo esc_html($found); ?></span>件</h3>
    <?php if ($event_query->have_posts()): ?>
    <ul class="event__box-list">
      <?php while ($event_query->have_posts()): $event_query->the_post();
          $cats        = get_the_terms(get_the_ID(), 'event_cat');
          $areas_terms = get_the_terms(get_the_ID(), 'event_area');
          $area_slug   = $areas_terms && !is_wp_error($areas_terms) ? $areas_terms[0]->slug : '';
          $area_name   = $areas_terms && !is_wp_error($areas_terms) ? $areas_terms[0]->name : '';
          $thumb_id    = get_post_thumbnail_id();
        ?>
      <li>
        <a class="event__box-item" href="<?php the_permalink(); ?>">
          <div class="event__box-img">
            <?php if ($thumb_id): ?>
            <?php echo wp_get_attachment_image($thumb_id, 'medium'); ?>
            <?php else: ?>
            <img src="/assets/img/common/thumb.png" alt="">
            <?php endif; ?>
          </div>
          <p class="event__box-date">
            <?php
            $event_period = function_exists('get_field') ? get_field('event_period') : '';
            if (!empty( $event_period)) {
              echo esc_html($event_period);
            } else {
              echo esc_html(get_the_date('Y年n月j日'));
            }
          ?>
          </p>
          <h4 class="event__box-ttl"><?php the_title(); ?></h4>
          <?php if ($cats && !is_wp_error($cats)): ?>
          <div class="event__box-cat">
            <?php foreach ($cats as $c): ?>
            <span>#<?php echo esc_html($c->name); ?></span>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
          <?php if ($area_name): ?>
          <span class="<?php echo esc_attr($area_slug); ?>"><?php echo esc_html($area_name); ?></span>
          <?php endif; ?>
        </a>
      </li>
      <?php endwhile; wp_reset_postdata(); ?>
    </ul>
    <?php
    $total_pages = (int) $event_query->max_num_pages;
    $current     = (int) $paged;
    if ( $total_pages > 1 ): ?>
    <div class="event__pagination">
      <?php
    $base_args = [];
    if ( !empty($area_param) ) $base_args['area']    = $area_param;
    if ( !empty($from_d) )     $base_args['from']    = $from_d;
    if ( !empty($to_d) )       $base_args['to']      = $to_d;
    if ( !empty($cat_param) )  $base_args['ev_cat']  = $cat_param;
    if ( !empty($keyword) )    $base_args['keyword'] = $keyword;
    $base_url = get_post_type_archive_link('event');
    // 表示数（3つ）
    $show_max = 3;
    $start = max(1, $current - 1);
    $end   = min($total_pages, $start + $show_max - 1);
    if ( ($end - $start + 1) < $show_max ) {
      $start = max(1, $end - $show_max + 1);
    }
    // ← prev
    if ( $current > 1 ) {
      $prev_args = array_merge( $base_args, ['page' => $current - 1] );
      $prev_url  = add_query_arg( $prev_args, $base_url );
      echo '<button class="arrow-before" type="button" onclick="location.href=\'' . esc_url( $prev_url ) . '\'"></button>';
    }
    // 中央の数字
    for ( $i = $start; $i <= $end; $i++ ) {
      $page_args = array_merge( $base_args, ['page' => $i] );
      $page_url  = add_query_arg( $page_args, $base_url );
      $active    = ($i === $current) ? 'active' : '';
      echo '<button class="' . esc_attr($active) . '" type="button" onclick="location.href=\'' . esc_url($page_url) . '\'">' . esc_html($i) . '</button>';
    }
    if ( $end < $total_pages ) {
      echo '<button class="small" type="button"></button>';
      echo '<button class="small" type="button"></button>';
      echo '<button class="small" type="button"></button>';
    }
    // → next
    if ( $current < $total_pages ) {
      $next_args = array_merge( $base_args, ['page' => $current + 1] );
      $next_url  = add_query_arg( $next_args, $base_url );
      echo '<button class="arrow-next" type="button" onclick="location.href=\'' . esc_url( $next_url ) . '\'"></button>';
    }
    ?>
    </div>
    <?php endif; ?>
    <?php else: ?>
    <p class="event__zero-txt">該当するイベントはありませんでした。</p>
    <?php endif; ?>
  </section>
</article>

<?php get_footer(); ?>