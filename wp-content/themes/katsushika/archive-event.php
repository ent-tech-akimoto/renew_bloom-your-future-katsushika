<?php
  $slug = 'event';
  get_header();

  // ====== 受け取るパラメータ ======
  $paged   = get_query_var('paged') ? get_query_var('paged') : 1;
  $area    = isset($_GET['area']) ? sanitize_text_field($_GET['area']) : '';
  $from    = isset($_GET['from']) ? sanitize_text_field($_GET['from']) : '';
  $to      = isset($_GET['to'])   ? sanitize_text_field($_GET['to'])   : '';
  $cat     = isset($_GET['cat'])  ? sanitize_text_field($_GET['cat'])  : '';
  $keyword = isset($_GET['keyword']) ? sanitize_text_field($_GET['keyword']) : '';

  // ====== クエリ組み立て ======
  $meta_query = array('relation' => 'AND');

  // 期間があれば「イベント期間と重なっているか」で絞る例
  if ( $from || $to ) {
    $date_cond = array('relation' => 'AND');

    if ( $from ) {
      // イベント終了日が検索開始日以降
      $date_cond[] = array(
        'key'     => 'event_end_date',
        'value'   => $from,
        'compare' => '>=',
        'type'    => 'DATE',
      );
    }
    if ( $to ) {
      // イベント開始日が検索終了日以前
      $date_cond[] = array(
        'key'     => 'event_start_date',
        'value'   => $to,
        'compare' => '<=',
        'type'    => 'DATE',
      );
    }

    $meta_query[] = $date_cond;
  }

  $tax_query = array();

  // エリア（taxonomy: event_area を想定）
  if ( $area ) {
    $tax_query[] = array(
      'taxonomy' => 'event_area',
      'field'    => 'slug',
      'terms'    => $area,
    );
  }

  // カテゴリ（taxonomy: event_cat を想定）
  if ( $cat ) {
    $tax_query[] = array(
      'taxonomy' => 'event_cat',
      'field'    => 'slug',
      'terms'    => $cat,
    );
  }

  $args = array(
    'post_type'      => 'event',
    'paged'          => $paged,
    'posts_per_page' => 12,
    's'              => $keyword,
    'orderby'        => 'meta_value',
    'meta_key'       => 'event_start_date',
    'order'          => 'ASC',
  );

  if ( count($meta_query) > 1 ) {
    $args['meta_query'] = $meta_query;
  }

  if ( !empty($tax_query) ) {
    if ( count($tax_query) > 1 ) {
      $tax_query['relation'] = 'AND';
    }
    $args['tax_query'] = $tax_query;
  }

  $event_query = new WP_Query($args);
  $found_posts = $event_query->found_posts;
?>
<article class="event">
  <div class="event__bg"></div>
  <p class="common-bread event__bread">
    <span>TOP</span><span>イベント情報</span>
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

  <!-- カレンダー誘導 -->
  <section class="event__calendar">
    <h2 class="event__h2">イベントカレンダーから探す</h2>
    <a class="event__btn" href="<?php echo esc_url( home_url('/event-calendar/') ); ?>">
      各月毎のイベントはこちら
    </a>
  </section>

  <!-- 検索フォーム -->
  <section class="event__form">
    <h2 class="event__h2">詳細から探す</h2>

    <!-- action を /event/ にしてGETで投げる -->
    <form class="event__form-wrapper" action="<?php echo esc_url( get_post_type_archive_link('event') ); ?>"
      method="get">
      <!-- 実際に送信するhiddenたち（JSで書き換える想定） -->
      <input type="hidden" name="area" value="<?php echo esc_attr($area); ?>" class="js-event-area">
      <input type="hidden" name="from" value="<?php echo esc_attr($from); ?>" class="js-event-from">
      <input type="hidden" name="to" value="<?php echo esc_attr($to); ?>" class="js-event-to">
      <input type="hidden" name="cat" value="<?php echo esc_attr($cat); ?>" class="js-event-cat">
      <input type="hidden" name="keyword" value="<?php echo esc_attr($keyword); ?>" class="js-event-keyword">

      <!-- エリア行 -->
      <div class="event__form-flex area">
        <div class="event__form-label area"></div>
        <div class="event__form-box area">
          <!-- ここは見た目用。クリックしたら上の hidden[name=area] を書き換えるJSを組む -->
          <span class="event__form-select--area main<?php if($area==='main') echo ' js-active'; ?>"
            data-area="main">メインエリア</span>
          <span class="event__form-select--area kochi<?php if($area==='kochi') echo ' js-active'; ?>"
            data-area="kochi">こち亀エリア</span>
          <span class="event__form-select--area monchi<?php if($area==='monchi') echo ' js-active'; ?>"
            data-area="monchi">モンチッチエリア</span>
          <span class="event__form-select--area wing<?php if($area==='wing') echo ' js-active'; ?>"
            data-area="wing">翼エリア</span>
          <span class="event__form-select--area iris<?php if($area==='iris') echo ' js-active'; ?>"
            data-area="iris">堀切菖蒲園</span>
          <span class="event__form-select--area tora<?php if($area==='tora') echo ' js-active'; ?>"
            data-area="tora">寅さんエリア</span>
        </div>
        <div class="event__form-modal area" data-modal="modal1">
          <h5 class="pc-none">イベントエリア</h5>
          <div class="event__modal-flex area pc-none">
            <div class="event__form-label area"></div>
            <div class="event__form-box area in-modal">
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
          <button class="event__modal-map-btn">現在地付近</button>
          <button class="event__modal-btn" type="submit">検索する</button>
          <button class="event__modal-next" type="button">スキップする＞</button>
          <button class="event__modal-close" type="button">
            <span></span>
            <span></span>
          </button>
        </div>
      </div>

      <!-- 日付行（表示はそのまま／実際の送信は hidden） -->
      <div class="event__form-flex date">
        <div class="event__form-label date"></div>
        <div class="event__form-box date">
          <div class="event__date-start">
            <strong>開始日</strong>
            <p><?php echo $from ? esc_html(str_replace('-', '.', $from)) : '—'; ?></p>
          </div>
          <div class="event__date-wave">～</div>
          <div class="event__date-end">
            <strong>終了日</strong>
            <p><?php echo $to ? esc_html(str_replace('-', '.', $to)) : '—'; ?></p>
          </div>
        </div>
        <!-- モーダル部分は元のまま。日付クリックで .js-event-from / .js-event-to を書き換えるJSを組んでください -->
        <div class="event__form-modal date" data-modal="modal2">
          <!-- ここは元ソース省略せずにそのままでもOK。長いので省略 -->
          <!-- ...あなたの元のモーダルHTML... -->
          <button class="event__modal-btn" type="submit">検索する</button>
          <button class="event__modal-next" type="button">スキップする＞</button>
          <button class="event__modal-close" type="button">
            <span></span>
            <span></span>
          </button>
        </div>
      </div>

      <!-- カテゴリ行 -->
      <div class="event__form-flex cate">
        <div class="event__form-label cate"></div>
        <div class="event__form-box cate">
          <span class="event__form-select"><?php echo $cat ? esc_html($cat) : 'カテゴリー'; ?></span>
        </div>
        <div class="event__form-modal cate" data-modal="modal3">
          <h5>カテゴリー</h5>
          <div class="event__modal-flex cate">
            <div class="event__form-label cate"></div>
            <div class="event__form-box cate in-modal">
              <?php
              // タクソノミーを出す例
              $event_cats = get_terms(array(
                'taxonomy' => 'event_cat',
                'hide_empty' => false,
              ));
              if ( $event_cats && ! is_wp_error($event_cats) ) :
                foreach ( $event_cats as $term ) :
              ?>
              <span class="event__form-select<?php if($cat===$term->slug) echo ' js-active'; ?>"
                data-cat="<?php echo esc_attr($term->slug); ?>">
                <?php echo esc_html($term->name); ?>
              </span>
              <?php
                endforeach;
              else:
              ?>
              <span class="event__form-select" data-cat="">見る</span>
              <?php endif; ?>
            </div>
          </div>
          <button class="event__modal-btn" type="submit">検索する</button>
          <button class="event__modal-next" type="button">スキップする＞</button>
          <button class="event__modal-close" type="button">
            <span></span>
            <span></span>
          </button>
        </div>
      </div>

      <!-- フリーワード行 -->
      <div class="event__form-flex word">
        <div class="event__form-label word" for="eventWord"></div>
        <textarea class="event__form-box word" placeholder="フリーワード" rows="1"
          name="keyword"><?php echo esc_textarea($keyword); ?></textarea>
        <div class="event__form-modal word" data-modal="modal4">
          <h5>フリーワード</h5>
          <div class="event__modal-flex word">
            <div class="event__form-label word in-modal" for="eventWord"></div>
            <textarea class="event__form-box word" placeholder="フリーワード" rows="1"
              name="keyword"><?php echo esc_textarea($keyword); ?></textarea>
          </div>
          <button class="event__modal-btn" type="submit">検索する</button>
          <button class="event__modal-next" type="button">スキップする＞</button>
          <button class="event__modal-close" type="button">
            <span></span>
            <span></span>
          </button>
        </div>
      </div>
    </form>
  </section>

  <!-- 検索結果 -->
  <section class="event__box">
    <h3 class="event__h3">検索結果<span><?php echo esc_html( $found_posts ); ?></span>件</h3>

    <ul class="event__box-list">
      <?php if ( $event_query->have_posts() ) : ?>
      <?php while ( $event_query->have_posts() ) : $event_query->the_post(); ?>
      <?php
            // エリアのクラスを付ける（最初のタームだけ使う）
            $area_terms = get_the_terms( get_the_ID(), 'event_area' );
            $area_class = '';
            $area_label = '';
            if ( $area_terms && ! is_wp_error($area_terms) ) {
              $area_class = $area_terms[0]->slug;
              $area_label = $area_terms[0]->name;
            }
            // カテゴリ
            $cat_terms = get_the_terms( get_the_ID(), 'event_cat' );
            // 日付
            $start = get_post_meta( get_the_ID(), 'event_start_date', true );
            $end   = get_post_meta( get_the_ID(), 'event_end_date', true );
            // 日付を「2026年 5月16日」っぽくする簡易例
            $date_str = '';
            if ( $start ) {
              $t = strtotime($start);
              $date_str = date_i18n('Y年 n月j日', $t);
            }
            if ( $end && $end !== $start ) {
              $t2 = strtotime($end);
              $date_str .= ' ～ ' . date_i18n('Y年 n月j日', $t2);
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
            <span>#<?php echo esc_html($term->name); ?></span>
            <?php endforeach; ?>
            <?php endif; ?>
          </div>
          <?php if ( $area_label ) : ?>
          <span class="<?php echo esc_attr( $area_class ); ?>"><?php echo esc_html( $area_label ); ?></span>
          <?php endif; ?>
        </a>
      </li>
      <?php endwhile; wp_reset_postdata(); ?>
      <?php else: ?>
      <li>該当するイベントはありませんでした。</li>
      <?php endif; ?>
    </ul>

    <div class="event__pagination">
      <?php
        echo paginate_links( array(
          'total'   => $event_query->max_num_pages,
          'current' => $paged,
          'prev_text' => '',
          'next_text' => '',
        ) );
      ?>
    </div>
  </section>
</article>
<?php get_footer(); ?>