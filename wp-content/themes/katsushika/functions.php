<?php
require_once get_template_directory() . '/functions/event-freeword.php';

// 検索で使うクエリパラメータを許可
function my_event_add_query_vars( $vars ) {
  $vars[] = 'ev_cat'; // ←ここに寄せた
  $vars[] = 'area';
  $vars[] = 'from';
  $vars[] = 'to';
  return $vars;
}
add_filter( 'query_vars', 'my_event_add_query_vars' );

/**
 * /event/ 周りで canonical リダイレクトを止める
 */
function my_event_disable_canonical_for_event( $redirect_url, $requested_url ) {
  // 現在のリクエストパス
  $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

  // ① URLが /event で始まっていたら止める（強めのガード）
  if ( strpos( $request_uri, '/event' ) === 0 ) {
    return false;
  }

  // ② もしくは event アーカイブで、検索パラメータが付いてたら止める（少し丁寧な条件）
  if ( is_post_type_archive( 'event' ) ) {
    if (
      get_query_var('ev_cat') ||
      get_query_var('area') ||
      get_query_var('from') ||
      get_query_var('to') ||
      isset($_GET['keyword'])
    ) {
      return false;
    }
  }

  // どれにも当てはまらなければ元のURLを返す
  return $redirect_url;
}
add_filter( 'redirect_canonical', 'my_event_disable_canonical_for_event', 10, 2);

// 管理バーOFF
// add_filter('show_admin_bar', '__return_false');