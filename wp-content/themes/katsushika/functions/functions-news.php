<?php
// 一覧：/news/
add_action('init', function () {
  add_rewrite_tag('%is_news_archive%', '1');
  add_rewrite_rule('^news/?$', 'index.php?is_news_archive=1', 'top');
  add_rewrite_rule('^news/page/([0-9]+)/?$', 'index.php?is_news_archive=1&paged=$matches[1]', 'top');
});

add_action('pre_get_posts', function ($q) {
  if (is_admin() || !$q->is_main_query()) return;
  if ((int) get_query_var('is_news_archive') === 1) {
    $q->set('post_type', 'post');
    $q->set('post_status', array('publish'));
    $q->is_home = false;
    $q->is_archive = true;
  }
});

add_filter('request', function ($vars) {
  if (isset($vars['is_news_archive']) && isset($vars['page'])) {
    $vars['paged'] = max(1, (int) $vars['page']);
  }
  return $vars;
});

add_filter('template_include', function ($template) {
  if ((int) get_query_var('is_news_archive') === 1) {
    if ($arch = locate_template('archive.php')) return $arch;
  }
  return $template;
});

// 詳細：/news/{post_id}/
$news_permalink_override = function ($permalink, $post) {
  if ($post instanceof WP_Post && $post->post_type === 'post') {
    $url = home_url('/news/' . $post->ID . '/');
    return user_trailingslashit($url, 'single');
  }
  return $permalink;
};
add_filter('post_link', $news_permalink_override, 999, 2);
add_filter('post_type_link', $news_permalink_override, 999, 2);

// リライトルール
add_action('init', function () {
  add_rewrite_rule('^news/([0-9]+)/?$', 'index.php?post_type=post&p=$matches[1]', 'top');
});

// 旧URLで来たアクセスを /news/{post_id}/ へ 301リダイレクト
add_action('template_redirect', function () {
  if (!is_singular('post')) return;

  $target = user_trailingslashit(home_url('/news/' . get_the_ID() . '/'), 'single');
  $req_uri = esc_url_raw(home_url(add_query_arg([], $GLOBALS['wp']->request)));

  if (trailingslashit($req_uri) === trailingslashit($target)) return;

  wp_redirect($target, 301);
  exit;
});

// /news/ アーカイブで ?page=2 を使うときに canonical を止める
function my_news_stop_canonical_on_news_archive() {
  if ( (int) get_query_var('is_news_archive') !== 1 ) {
    return;
  }
  if ( isset($_GET['page']) && (int) $_GET['page'] > 1 ) {
    remove_action('template_redirect', 'redirect_canonical');
  }
}
add_action('template_redirect', 'my_news_stop_canonical_on_news_archive', 9);