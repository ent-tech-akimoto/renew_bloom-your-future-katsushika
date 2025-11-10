<?php
function my_event_add_query_vars( $vars ) {
  $vars[] = 'ev_cat';
  $vars[] = 'area';
  $vars[] = 'from';
  $vars[] = 'to';
  return $vars;
}
add_filter( 'query_vars', 'my_event_add_query_vars' );
function my_event_stop_canonical_on_event_archive() {
  if ( is_post_type_archive( 'event' ) ) {
    // GETで ?page=2 が付いてるパターン
    if ( isset($_GET['page']) && (int) $_GET['page'] > 1 ) {
      remove_action( 'template_redirect', 'redirect_canonical' );
      return;
    }
    $paged = get_query_var('page');
    if ( $paged && (int) $paged > 1 ) {
      remove_action( 'template_redirect', 'redirect_canonical' );
      return;
    }
    if (
      get_query_var('ev_cat') ||
      get_query_var('area')   ||
      get_query_var('from')   ||
      get_query_var('to')     ||
      isset($_GET['keyword'])
    ) {
      remove_action( 'template_redirect', 'redirect_canonical' );
      return;
    }
  }
}
add_action( 'template_redirect', 'my_event_stop_canonical_on_event_archive', 9 );