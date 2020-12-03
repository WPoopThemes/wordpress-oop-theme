<?php 

namespace WPTheme\Controllers;

class ThemeController {

  public $text_domain;
  public $theme_path;
  public $theme_uri;
  public $src_root;
  public $core_root;
  public $utils_root;
  public $assets_uri;
  public $widgets_root;
  public $templates_root;
  public $views_path;
  public $status_checker;

  public function __construct()
  {
    $this->text_domain = 'WPTheme';
    $this->theme_path = get_stylesheet_directory();
    $this->theme_uri = get_stylesheet_directory_uri();
    $this->src_root = $this->theme_path . '/src/';
    $this->core_root = $this->theme_path . '/Core/';
    $this->utils_root = $this->theme_path . '/Utils/';
    $this->assets_uri = $this->theme_uri . '/assets';
    $this->widgets_root = $this->theme_path . '/Widgets/';
    $this->templates_root = $this->theme_path . '/templates/';
    $this->views_path = $this->templates_root . 'views/';
    $this->check_online_status = false;
  }

  public function registered(string $selected_option){
    $option = get_option('test_plugin');
    return isset($option[$selected_option]) ? $option[$selected_option] : false;
  }

  public function generate_random_string(int $max)
  {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $randstring = '';
      for ($i = 0; $i < $max; $i++) {
          $randstring = $characters[rand(0, strlen($characters))];
      }
      return $randstring;
  }

}