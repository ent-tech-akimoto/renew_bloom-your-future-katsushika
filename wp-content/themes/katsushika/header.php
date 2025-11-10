<?php
if (!defined('ABSPATH')) exit;

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $uri);

$slug = 'top';
$page_title = '';

function get_top_ancestor_slug($post_id) {
  $anc = get_post_ancestors($post_id);
  $top_id = !empty($anc) ? end($anc) : $post_id;
  return get_post_field('post_name', $top_id);
}

// 明示: event アーカイブでは確実に 'event'
if (is_post_type_archive('event')) {
  $slug = 'event';
}

if (is_home()) {
  $slug = 'top';
} elseif (is_singular()) {
  // カスタム投稿タイプまたは通常の投稿の場合
  $post_type = get_post_type();
  if ($post_type && $post_type !== 'post' && $post_type !== 'page') {
    // カスタム投稿タイプのスラッグを取得（例: event → 'event'）
    $slug = $post_type;
  } elseif (is_page()) {
    // 固定ページの場合
    $slug = get_post_field('post_name', get_the_ID());
  } else {
    // 通常の投稿の場合
    $slug = get_post_field('post_name', get_the_ID());
  }
} elseif (is_post_type_archive()) {
  $obj = get_queried_object();
  if ($obj && !empty($obj->name)) {
    $slug = $obj->name;
  } else {
    $pt = get_query_var('post_type');
    if (is_array($pt)) {
      $pt = reset($pt);
    }
    if (!empty($pt)) {
      $slug = $pt;
    }
  }
} elseif (is_post_type_archive('event')) {
  $slug = 'event';
}

// 追加フォールバック: URLの第1セグメントから推測（例: /event/... → event）
if (empty($slug) && !empty($segments) && !empty($segments[0])) {
  $slug = $segments[0];
}

// $slugが未定義の場合はデフォルト値を使用
if (!isset($slug) || empty($slug)) {
  $slug = 'top';
}


if (is_home() || is_front_page()) {
  $page_title = '';
} elseif (is_single() || is_page()) {
  $page_title = get_the_title();
} elseif (is_post_type_archive('post') || is_category()) {
  $page_title = 'お知らせ';
}
$base_title  = "全国みどりと花のフェアかつしか";
$description = "全国みどりと花のフェアかつしかの公式サイトです";
$page_title  = (empty($page_title)) ? $base_title : $page_title . ' | ' . $base_title;
$url         = 'https://bloom-your-future-katsushika.jp/';
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <!-- title -->
  <title><?php echo $page_title; ?> ｜ Bloom Your Future Katsushika</title>
  <meta name="viewport" content="width=device-width">
  <meta name="description" content="初期値です">
  <meta name="keywords" content="初期値です">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="全国みどりと花のフェアかつしか ｜ Bloom Your Future Katsushika">
  <meta name="twitter:description" content="初期値です">
  <meta name="twitter:url" content="初期値です">
  <meta name="twitter:image" content="初期値です">
  <meta name="twitter:site" content="初期値です">
  <meta property="og:site_name" content="全国みどりと花のフェアかつしか ｜ Bloom Your Future Katsushika">
  <meta property="og:title" content="全国みどりと花のフェアかつしか ｜ Bloom Your Future Katsushika">
  <meta property="og:description" content="初期値です">
  <meta property="og:url" content="初期値です">
  <meta property="og:type" content="website">
  <meta property="og:image" content="初期値です">
  <!-- font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kiwi+Maru:wght@300;400;500&display=swap" rel="stylesheet">
  <!-- favicon -->
  <link rel="shortcut icon" href="/assets/img/common/favicon.ico">
  <link rel="apple-touch-icon" href="/assets/img/common/apple-touch-icon.png">
  <!-- css -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
  <link rel="stylesheet" href="/assets/css/share.css">
  <?php wp_head(); ?>
</head>

<body>
  <div class="page">
    <header class="header <?php echo $slug; ?>">
      <div class="header__inner">
        <div class="header__main">
          <a class="header__logo" href="/">
            <img src="/assets/data/webp/common/logo.webp" alt="Bloom Your Future Katsushika">
          </a>
          <div class="header__info">
            <p class="header__date">
              <span class="header__date--year">2026年</span>
              <span class="header__date--period">5/16<img src="/assets/data/webp/common/icon_polygon.webp"
                  alt="">6/14</span>
            </p>
            <p class="header__countdown"> 開催まで <span class="header__countdown--num">360<small>日</small></span>
            </p>
          </div>
        </div>
        <div class="gnavi">
          <div class="gnavi__contents">
            <a class="gnavi__contact" href="#">お問い合わせ</a>
            <div class="gnavi__sns">
              <a class="gnavi__sns--item -x" href="https://x.com/katsu_midohana" target="_blank">
                <img src="/assets/data/webp/common/sns_x.webp" alt="X">
              </a>
              <a class="gnavi__sns--item -insta" href="https://www.instagram.com/katsushika_midorihanafair/"
                target="_blank">
                <img src="/assets/data/webp/common/sns_insta.webp" alt="Instagram">
              </a>
              <a class="gnavi__sns--item -fb" href="https://www.facebook.com/profile.php?id=61576628410141"
                target="_blank">
                <img src="/assets/data/webp/common/sns_fb.webp" alt="facebook">
              </a>
            </div>
          </div>
          <ul class="gnavi__menu">
            <li class="gnavi__menu--item menu-about">
              <a href="#">開催概要</a>
            </li>
            <li class="gnavi__menu--item menu-area">
              <a href="#">開催エリア</a>
            </li>
            <li class="gnavi__menu--item menu-event">
              <a href="#">イベント情報</a>
              <ul class="gnavi__submenu">
                <li class="gnavi__submenu--item">
                  <a href="">&gt; イベントカレンダー</a>
                </li>
              </ul>
            </li>
            <li class="gnavi__menu--item menu-sponsorship">
              <a href="#">募集情報</a>
              <ul class="gnavi__submenu">
                <li class="gnavi__submenu--item">
                  <a href="">&gt; 協力企業・団体一覧</a>
                </li>
              </ul>
            </li>
            <li class="gnavi__menu--item menu-sponsorinfo">
              <a href="#">協賛募集</a>
            </li>
            <li class="gnavi__menu--item menu-access">
              <a href="#">アクセス情報</a>
            </li>
          </ul>
        </div>
        <button id="js-header-btn" class="header__btn" aria-label="メニューを開閉">
          <div class="header__btn--line">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </button>
        <nav id="js-header-nav" class="header__nav">
          <ul class="header__menu -main">
            <li class="header__menu--item menu-about">
              <a href="#">開催概要</a>
            </li>
            <li class="header__menu--item menu-area">
              <a href="#">開催エリア</a>
            </li>
            <li class="header__menu--item menu-event">
              <a href="#">イベント情報</a>
              <ul class="header__submenu">
                <li class="header__submenu--item">
                  <a href="">&gt; イベントカレンダー</a>
                </li>
              </ul>
            </li>
            <li class="header__menu--item menu-sponsorship">
              <a href="#">募集情報</a>
              <ul class="header__submenu">
                <li class="header__submenu--item">
                  <a href="">&gt; 協力企業・団体一覧</a>
                </li>
              </ul>
            </li>
            <li class="header__menu--item menu-sponsorinfo">
              <a href="#">協賛募集</a>
            </li>
            <li class="header__menu--item menu-access">
              <a href="#">アクセス情報</a>
            </li>
          </ul>
          <div class="header__utility">
            <ul class="header__menu">
              <li class="header__menu--item menu-sub">
                <a href="#">お知らせ</a>
              </li>
              <li class="header__menu--item menu-sub">
                <a href="#">関連サイト</a>
              </li>
            </ul>
            <div id="google_translate_element"></div>
            <div class="header__search">
              <form id="siteSearchForm" class="header__search--form">
                <input class="header__search--input" id="siteSearchInput" type="text" placeholder="">
                <button class="header__search--button" type="submit">
                  <img src="/assets/data/webp/common/header/icon_search.webp" alt="検索">
                </button>
              </form>
            </div>
            <script>
            document.getElementById("siteSearchForm").addEventListener("submit", function(e) {
              e.preventDefault();
              const q = document.getElementById("siteSearchInput").value.trim();
              if (q) {
                location.href = `/search/?q=${encodeURIComponent(q)}`;
              }
            });
            </script>
            <a class="header__contact" href="#">お問い合わせ</a>
            <div class="header__sns">
              <a class="header__sns--item -x" href="https://x.com/katsu_midohana" target="_blank">
                <img src="/assets/data/webp/common/sns_x.webp" alt="X">
              </a>
              <a class="header__sns--item -insta" href="https://www.instagram.com/katsushika_midorihanafair/"
                target="_blank">
                <img src="/assets/data/webp/common/sns_insta.webp" alt="Instagram">
              </a>
              <a class="header__sns--item -fb" href="https://www.facebook.com/profile.php?id=61576628410141"
                target="_blank">
                <img src="/assets/data/webp/common/sns_fb.webp" alt="facebook">
              </a>
            </div>
          </div>
        </nav>
      </div>
    </header>