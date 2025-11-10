<?php
// ---- フリーワード予測AJAX
require_once get_template_directory() . '/functions/event-freeword.php';
// ---- 検索で使うクエリパラメータを許可
require_once get_template_directory() . '/functions/event-redirect.php';


// 管理バーOFF
// add_filter('show_admin_bar', '__return_false');