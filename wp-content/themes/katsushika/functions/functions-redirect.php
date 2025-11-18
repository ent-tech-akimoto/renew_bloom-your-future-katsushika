<?php
add_action('template_redirect', function () {
  $disabled_taxes = ['event_cat', 'event_area', 'sponsors_funds_partners', 'sponsors_goods_partners', 'sponsors_advertise_partners'];
  foreach ($disabled_taxes as $tax) {
    if (is_tax($tax)) {
      wp_redirect(home_url('/'), 301);
      exit;
    }
  }
});