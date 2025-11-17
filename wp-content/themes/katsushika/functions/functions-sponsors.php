<?php
// 募集詳細用：コンテンツブロック
function sponsors_block_shortcode( $atts, $content = '' ) {
  $atts = shortcode_atts(
    array(
      'title' => '',
    ),
    $atts,
    'sponsors_block'
  );
  $title   = $atts['title'];
  $content = do_shortcode( $content );
  $content = trim( $content );
  if ( $content !== '' ) {
    $content = wpautop( $content );
    // <p><img></p>をdetail__content-imgに変換
    $content = preg_replace(
      '#<p>\s*(<img[^>]+>)\s*</p>#i',
      '<div class="detail__content-img">$1</div>',
      $content
    );
    // 中身が何もない<p>削除
    $content = preg_replace( '#<p>\s*</p>#i', '', $content );
  }
  $html  = '<div class="detail__content-block">';
  if ( $title !== '' ) {
    $html .= '<h2>' . esc_html( $title ) . '</h2>';
  }
  $html .= $content;
  $html .= '</div>';
  return $html;
}
add_shortcode( 'sponsors_block', 'sponsors_block_shortcode' );

// 募集詳細用：お問い合わせブロック
function sponsors_contact_shortcode( $atts ) {
  $atts = shortcode_atts(
    array(
      'url'   => '',
      'label' => 'お問い合わせはこちら', // デフォルト文言
    ),
    $atts,
    'sponsors_contact'
  );

  $url   = trim( $atts['url'] );
  $label = trim( $atts['label'] );
  // URL がない時はブロック自体を出さない
  if ( $url === '' ) {
    return '';
  }
  $url   = esc_url( $url );
  $label = esc_html( $label );
  // 外部リンク判定
  $home   = home_url();
  $target = '';
  $rel    = '';

  if ( strpos( $url, $home ) !== 0 ) {
    // 外部リンク
    $target = ' target="_blank"';
    $rel    = ' rel="noopener noreferrer"';
  }

  // HTML 出力
  $html  = '<div class="sponsor-detail__contact">';
  $html .= '<p>以下お問い合わせより受付いたします。</p>';
  $html .= '<a href="' . $url . '" class="sponsor-detail__contact--btn"' . $target . $rel . '>';
  $html .= '<span>' . $label . '</span>';
  $html .= '</a>';
  $html .= '</div>';

  return $html;
}
add_shortcode( 'sponsors_contact', 'sponsors_contact_shortcode' );

// カスタム投稿sponsorsでTinyMCEボタンを追加
function byf_sponsors_mce_buttons( $buttons ) {
  global $typenow;
  if ( $typenow !== 'sponsors' ) {
    return $buttons;
  }
  $buttons[] = 'sponsors_block_btn';
  $buttons[] = 'sponsors_contact_btn';
  return $buttons;
}
add_filter( 'mce_buttons', 'byf_sponsors_mce_buttons' );

// テーマ内にJSのパス
function byf_sponsors_mce_plugin( $plugins ) {
  global $typenow;
  if ( $typenow !== 'sponsors' ) {
    return $plugins;
  }
  $plugins['sponsors_buttons'] = get_template_directory_uri() . '/assets/js/sponsors-tinymce.js';
  return $plugins;
}
add_filter( 'mce_external_plugins', 'byf_sponsors_mce_plugin' );

// 協賛企業・団体一覧を/sponsors/list/で表示する
add_action('init', function () {
  add_rewrite_rule(
    '^sponsors/list/?$',
    'index.php?pagename=sponsors-list',
    'top'
  );
});

// /sponsors-list/でアクセスされたら/sponsors/list/に301リダイレクト
add_action('template_redirect', function () {
  if ( ! is_page() ) {
    return;
  }
  $page = get_queried_object();
  if ( ! $page || empty( $page->post_name ) ) {
    return;
  }
  if ( $page->post_name !== 'sponsors-list' ) {
    return;
  }
  $target = home_url('/sponsors/list/');
  $current = home_url( add_query_arg( [], $GLOBALS['wp']->request ) );
  if ( trailingslashit( $current ) === trailingslashit( $target ) ) {
    return;
  }
  wp_redirect( $target, 301 );
  exit;
});