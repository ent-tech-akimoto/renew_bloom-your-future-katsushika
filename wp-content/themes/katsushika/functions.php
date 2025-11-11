<?php
// ---- 現在地付近
function my_event_order_by_area_tax( $clauses, $query ) {
  global $wpdb, $event_area_order_for_archive;
  if ( empty($event_area_order_for_archive) ) {
    return $clauses;
  }
  if ( $query->get('post_type') !== 'event' ) {
    return $clauses;
  }
  $ids_for_field = implode(',', array_map('intval', $event_area_order_for_archive));
  $clauses['join'] .= "
    LEFT JOIN {$wpdb->term_relationships} tr ON ({$wpdb->posts}.ID = tr.object_id)
    LEFT JOIN {$wpdb->term_taxonomy} tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
  ";
  $clauses['where'] .= $wpdb->prepare(" AND tt.taxonomy = %s ", 'event_area');
  $clauses['orderby'] = "FIELD(tt.term_id, {$ids_for_field}), " . $clauses['orderby'];

  return $clauses;
}
// ---- フリーワード予測AJAX
require_once get_template_directory() . '/functions/event-freeword.php';
// ---- 検索で使うクエリパラメータを許可
require_once get_template_directory() . '/functions/event-redirect.php';
// ---- 詳細ページ周り
require_once get_template_directory() . '/functions/event-content.php';


// 管理バーOFF
add_filter('show_admin_bar', '__return_false');