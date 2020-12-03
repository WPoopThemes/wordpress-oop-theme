<?php

namespace WPTheme\Controllers;

class WooCommerceController
{

  public function register()
  {
    add_filter('woocommerce_login_redirect', 'custom_wc_login_redirect', 10, 3);
  }

  public function custom_wc_login_redirect($redirect, $user)
  {
    $redirect = site_url() . '/my-profile/';
    return $redirect;
  }
}
