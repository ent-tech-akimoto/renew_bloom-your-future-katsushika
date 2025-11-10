<?php
add_action('wp_ajax_event_keyword_suggest', 'my_event_keyword_suggest');
add_action('wp_ajax_nopriv_event_keyword_suggest', 'my_event_keyword_suggest');

function my_event_keyword_suggest() {
  $keyword = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
  if ($keyword === '') {
    wp_send_json_success(array());
  }
  $event_ids = get_posts(array(
    'post_type'      => 'event',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'fields'         => 'ids',
  ));
  $suggests = array();
  $kwLen    = mb_strlen($keyword);
  // 記号・カギカッコを落とす
  $remove_marks_pattern = '/[「」『』【】（）\(\)［］\[\]〈〉《》、。．，\.・…!！\?？:：;；"“”’‘]+/u';
  foreach ($event_ids as $post_id) {
    // タイトルと本文をテキストで用意
    $title_raw = get_the_title($post_id);
    $content_raw = get_post_field('post_content', $post_id);
    // 本文をテキストのHTML除去 → エンティティ除去 → 空白整形
    $content_text = wp_strip_all_tags($content_raw);
    $content_text = html_entity_decode($content_text, ENT_QUOTES, 'UTF-8');
    // NBSPを普通のスペースに
    $content_text = str_replace("\xC2\xA0", ' ', $content_text);
    // 空白を1つに
    $content_text = preg_replace('/\s+/u', ' ', $content_text);
    $content_text = trim($content_text);
    $title_text = trim($title_raw);
    // タイトルを見る
    if ($title_text !== '') {
      add_suggest_from_text($title_text, $keyword, $kwLen, $remove_marks_pattern, $suggests);
    }
    // 本文を見る
    if ($content_text !== '') {
      add_suggest_from_text($content_text, $keyword, $kwLen, $remove_marks_pattern, $suggests);
    }
  }
  // 何も拾えなかったら入力語を返す
  if (empty($suggests)) {
    $suggests[$keyword] = true;
  }
  wp_send_json_success(array_keys($suggests));
}

function add_suggest_from_text($text, $keyword, $kwLen, $remove_marks_pattern, &$suggests) {
  $textLen = mb_strlen($text);
  $offset  = 0;
  // キーワードが出てくる位置を探す
  while (true) {
    $pos = mb_stripos($text, $keyword, $offset);
    if ($pos === false) {
      break;
    }
    // その出現位置のすぐ後ろをとりあえず30文字くらい見る
    $tail = mb_substr($text, $pos + $kwLen, 30);
    $tail_clean = preg_replace($remove_marks_pattern, '', $tail);
    $tail_clean = preg_replace('/\s+/u', '', $tail_clean);
    $tail_clean = trim($tail_clean);
    // 段階的に候補を作る
    $steps = array(0, 2, 6, 12);
    foreach ($steps as $step) {
      if ($step === 0) {
        $candidate = $keyword;
      } else {
        if ($tail_clean === '') {
          continue;
        }
        $candidate = $keyword . mb_substr($tail_clean, 0, $step);
      }
      $candidate = trim($candidate);
      if ($candidate !== '') {
        $suggests[$candidate] = true;
      }
    }
    // 次を探す
    $offset = $pos + $kwLen;
  }
}