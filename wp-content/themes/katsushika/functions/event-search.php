<?php
function my_event_archive_filtering( $query ) {
  if ( is_admin() || ! $query->is_main_query() ) {
    return;
  }
  // /event/ のアーカイブのときだけ
  if ( $query->is_post_type_archive( 'event' ) ) {
    // 期間（from, to）
    $meta_query = array();

    $from = isset($_GET['from']) ? sanitize_text_field($_GET['from']) : '';
    $to   = isset($_GET['to'])   ? sanitize_text_field($_GET['to'])   : '';
    if ( $from || $to ) {
      $date_meta = array(
        'relation' => 'AND',
      );
      // イベントの終了日が検索の開始日以降
      if ( $from ) {
        $date_meta[] = array(
          'key'     => 'event_end_date',
          'value'   => $from,
          'compare' => '>=',
          'type'    => 'DATE',
        );
      }
      // イベントの開始日が検索の終了日以前
      if ( $to ) {
        $date_meta[] = array(
          'key'     => 'event_start_date',
          'value'   => $to,
          'compare' => '<=',
          'type'    => 'DATE',
        );
      }
      $meta_query[] = $date_meta;
    }
    // エリア (taxonomy)
    if ( !empty($_GET['area']) ) {
      $query->set( 'tax_query', array(
        array(
          'taxonomy' => 'event_area',
          'field'    => 'slug',
          'terms'    => sanitize_text_field( $_GET['area'] ),
        ),
      ));
    }
    // カテゴリ (taxonomy)
    if ( !empty($_GET['cat']) ) {
      // すでに tax_query が入っていた場合はマージしたいので一度取り出す
      $tax_query = $query->get('tax_query');
      if ( ! is_array($tax_query) ) {
        $tax_query = array();
      }
      $tax_query[] = array(
        'taxonomy' => 'event_cat',
        'field'    => 'slug',
        'terms'    => sanitize_text_field( $_GET['cat'] ),
      );
      $query->set('tax_query', $tax_query);
    }
    // フリーワード
    if ( !empty($_GET['keyword']) ) {
      // 通常の検索と同じように s に入れる
      $query->set( 's', sanitize_text_field( $_GET['keyword'] ) );
    }
    if ( !empty($meta_query) ) {
      $query->set( 'meta_query', $meta_query );
    }
    // $query->set( 'posts_per_page', 12 );
  }
}
add_action( 'pre_get_posts', 'my_event_archive_filtering' );