<?php
// ---- イベント：現在地付近、フリーワード予測AJAX、検索で使うクエリパラメータを許可
require_once get_template_directory() . '/functions/functions-event.php';
// ---- 詳細ページ周り
require_once get_template_directory() . '/functions/functions-content.php';
// ---- お知らせ：投稿の詳細URLを/news/{post_id}/に統一など
require_once get_template_directory() . '/functions/functions-news.php';
// ---- 募集情報：本文内のブロック
require_once get_template_directory() . '/functions/functions-sponsors.php';

// 管理バーOFF
add_filter('show_admin_bar', '__return_false');