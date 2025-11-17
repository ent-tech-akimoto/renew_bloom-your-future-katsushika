<?php
// 固定ページだけ wpautop（自動<p>）を無効化
add_action('wp', function () {
  if (is_page()) {
    remove_filter('the_content', 'wpautop');
    remove_filter('the_content', 'wptexturize');
  }
});

// the_content() に自動挿入される <p> を、<a> 単体のときだけ除去
function my_remove_p_on_single_link( $content ) {
  // <p><a ...></a></p> のようなケースを検出して除去
  $pattern = '#<p>\s*(<a\s[^>]+>.*?</a>)\s*</p>#i';
  $content = preg_replace( $pattern, '$1', $content );
  return $content;
}
add_filter( 'the_content', 'my_remove_p_on_single_link', 11 );

// ブロックフォーマットの調整
function my_event_tinymce_formats($init) {
  $screen_post_type = '';
  if (function_exists('get_current_screen')) {
    $screen = get_current_screen();
    if ($screen && ! empty($screen->post_type)) {
        $screen_post_type = $screen->post_type;
    }
  }
  global $post;
  if (! $screen_post_type && $post && ! empty($post->post_type)) {
    $screen_post_type = $post->post_type;
  }
  if (!in_array($screen_post_type, ['event', 'post', 'sponsors', 'news'], true)) {
    return $init;
  }
  $init['block_formats'] = '段落=p;見出し2=h2;見出し3=h3;見出し4=h4';

  return $init;
}
add_filter('tiny_mce_before_init', 'my_event_tinymce_formats');

// 本文内の画像構造のHTML変換
add_filter('the_content', function($content) {
  $pattern = '/<p>\s*(<a [^>]+>\s*)?(<img [^>]+>)(\s*<\/a>)?\s*<\/p>/i';
  $replacement = '<div class="detail__content-img">$1$2$3</div>';

  return preg_replace($pattern, $replacement, $content);
});