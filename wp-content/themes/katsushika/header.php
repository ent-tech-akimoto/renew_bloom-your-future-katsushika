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
if (is_post_type_archive('event')) {
  $slug = 'event';
}

if (is_home()) {
  $slug = 'top';
} elseif (is_singular()) {
  // カスタム投稿タイプまたは通常の投稿の場合
  $post_type = get_post_type();
  if ($post_type && $post_type !== 'post' && $post_type !== 'page') {
    $slug = $post_type;
  } elseif (is_page()) {
    $slug = get_post_field('post_name', get_the_ID());
  } else {
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

if (empty($slug) && !empty($segments) && !empty($segments[0])) {
  $slug = $segments[0];
}
if (!isset($slug) || empty($slug)) {
  $slug = 'top';
}

$base_title  = "全国みどりと花のフェアかつしか";
$description = "葛飾区でみどりと花をテーマにした「全国みどりと花のフェアかつしか」を開催。その時の花を楽しむだけでなく、葛飾に暮らす人と葛飾を訪れる人、老若男女も問わず、すべての人の未来に花を咲かせる、そんなフェアです。";
$section_title = '';

if (is_front_page()) {
  $section_title = '';
} elseif (is_post_type_archive('event') || is_singular('event')) {
  $section_title = 'イベント情報';
} elseif (is_post_type_archive('sponsors') || is_singular('sponsors') || is_page('sponsors-list')) {
  $section_title = '募集情報';
} elseif (is_archive() || is_singular()) {
  $section_title = 'お知らせ';
}

if (is_front_page()) {
  $page_title_main = $base_title;
} elseif (is_post_type_archive('event')) {
  $page_title_main = $section_title . ' | ' . $base_title;
} elseif (is_page() && !is_page('sponsors-list')) {
  $page_title_main = get_the_title() . ' | ' . $base_title;
} elseif (is_singular('event')) {
  $page_title_main = get_the_title() . ' | ' . $section_title . ' | ' . $base_title;
} elseif (is_post_type_archive('sponsors')) {
  $page_title_main = $section_title . ' | ' . $base_title;
} elseif (is_page('sponsors-list')) {
  $page_title_main = get_the_title() . ' | ' . $section_title . ' | ' . $base_title;
} elseif (is_singular('sponsors')) {
  $page_title_main = get_the_title() . ' | ' . $section_title . ' | ' . $base_title;
} elseif (is_archive() && !is_post_type_archive('event') && !is_post_type_archive('sponsors')) {
  $page_title_main = $section_title . ' | ' . $base_title;
} elseif (is_singular() && !is_singular('event') && !is_singular('sponsors')) {
  $page_title_main = get_the_title() . ' | ' . $section_title . ' | ' . $base_title;
} elseif (!empty($section_title)) {
  $page_title_main = $section_title . ' | ' . $base_title;
} else {
  $page_title_main = $base_title;
}

$url = home_url($_SERVER['REQUEST_URI']);
$og_image = home_url('/assets/img/ogp.png');
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <!-- title -->
  <title><?php echo $page_title_main; ?></title>
  <meta name="viewport" content="width=device-width">
  <meta name="description" content="<?php echo $description; ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?php echo $page_title_main; ?>">
  <meta name="twitter:description" content="<?php echo $description; ?>">
  <meta name="twitter:url" content="<?php echo esc_url($url); ?>">
  <meta name="twitter:image" content="<?php echo esc_url($og_image); ?>">
  <meta name="twitter:site" content="@katsu_midohana">
  <meta property="og:site_name" content="<?php echo $page_title_main; ?>">
  <meta property="og:title" content="<?php echo $page_title_main; ?>">
  <meta property="og:description" content="<?php echo $description; ?>">
  <meta property="og:url" content="<?php echo esc_url($url); ?>">
  <meta property="og:type" content="website">
  <meta property="og:image" content="<?php echo esc_url($og_image); ?>">
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
            <?php
            $event_date = new DateTime('2026-05-16');
            $today = new DateTime(current_time('Y-m-d'));
            // 差分日数を計算
            $diff = (int) $today->diff($event_date)->format('%r%a');
            // 開催日を過ぎたら「0」に
            $countdown_days = max($diff, 0);
            ?>
            <p class="header__countdown">開催まで<span
                class="header__countdown--num"><?php echo esc_html($countdown_days); ?><small>日</small></span>
            </p>
          </div>
        </div>
        <div class="gnavi <?php echo $slug; ?>">
          <div class="gnavi__contents">
            <a class="gnavi__contact" href="#" target="_blank">
              <span>お問い合わせ</span>
            </a>
            <a class="gnavi__sns -x" href="https://x.com/katsu_midohana" target="_blank">
              <img src="/assets/data/webp/common/sns_x.webp" alt="X">
            </a>
            <a class="gnavi__sns -insta" href="https://www.instagram.com/katsushika_midorihanafair/"
              target="_blank">
              <img src="/assets/data/webp/common/sns_insta.webp" alt="Instagram">
            </a>
            <a class="gnavi__sns -fb" href="https://www.facebook.com/profile.php?id=61576628410141"
              target="_blank">
              <img src="/assets/data/webp/common/sns_fb.webp" alt="facebook">
            </a>
          </div>
          <ul class="gnavi__menu">
            <li class="gnavi__menu--item menu-overview">
              <a href="/overview/">開催概要</a>
            </li>
            <li class="gnavi__menu--item menu-area">
              <a href="/area/">開催エリア</a>
            </li>
            <li class="gnavi__menu--item menu-event">
              <a href="/event/">イベント情報</a>
              <ul class="gnavi__submenu">
                <li class="gnavi__submenu--item">
                  <a href="/event-calendar/">&gt; イベントカレンダー</a>
                </li>
              </ul>
            </li>
            <li class="gnavi__menu--item menu-sponsors">
              <a href="/sponsors/">募集情報</a>
              <ul class="gnavi__submenu">
                <li class="gnavi__submenu--item">
                  <a href="/sponsors/list/">&gt; 協賛企業・団体一覧</a>
                </li>
              </ul>
            </li>
            <li class="gnavi__menu--item menu-support">
              <a href="/support/">協賛募集</a>
            </li>
            <li class="gnavi__menu--item menu-access">
              <a href="/access/">アクセス情報</a>
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
            <li class="header__menu--item menu-overview">
              <a href="/overview/">開催概要</a>
            </li>
            <li class="header__menu--item menu-area">
              <a href="/area/">開催エリア</a>
            </li>
            <li class="header__menu--item menu-event">
              <a href="/event/">イベント情報</a>
              <ul class="header__submenu">
                <li class="header__submenu--item">
                  <a href="/event-calendar/">&gt; イベントカレンダー</a>
                </li>
              </ul>
            </li>
            <li class="header__menu--item menu-sponsors">
              <a href="/sponsors/">募集情報</a>
              <ul class="header__submenu">
                <li class="header__submenu--item">
                  <a href="/sponsors/list/">&gt; 協賛企業・団体一覧</a>
                </li>
              </ul>
            </li>
            <li class="header__menu--item menu-support">
              <a href="/support/">協賛募集</a>
            </li>
            <li class="header__menu--item menu-access">
              <a href="/access/">アクセス情報</a>
            </li>
          </ul>
          <div class="header__utility">
            <ul class="header__menu">
              <li class="header__menu--item menu-sub">
                <a href="/news/">お知らせ</a>
              </li>
              <li class="header__menu--item menu-sub">
                <a href="/related/">関連サイト</a>
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
            <a class="header__contact" href="#" target="_blank">
              <span>お問い合わせ</span>
            </a>
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