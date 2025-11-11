<?php

/**
 * メインテンプレート
 * どのテンプレートにも該当しない要求があった場合に使用。またテーマ構築の際に必須テンプレート
 */
if (!defined('ABSPATH')) exit;

//TOPへリダイレクト
wp_redirect(home_url());
exit;