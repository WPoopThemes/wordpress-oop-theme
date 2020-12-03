<?php

namespace WPTheme\Controllers;

class AssetsController extends ThemeController
{

  public $scripts = array();
  public $styles = array();

  public function set_scripts(array $args)
  {
    $this->scripts = $args;

    return $this;
  }

  public function set_styles(array $args)
  {
    $this->styles = $args;

    return $this;
  }

  public function register_custom_scripts()
  {
    foreach ($this->scripts as $script) {
      wp_register_script(
        $script['alias'], 
        $this->assets_uri . '/js/' . $script['src'], 
        $script['deps'], 
        $script['in_footer'] ? $script['in_footer'] : true
      );
    }
  }

  public function register_custom_styles()
  {
    foreach ($this->styles as $style) {
      wp_register_style(
        $style['alias'], 
        $this->assets_uri . '/css/' . 
        $style['src'],
        $style['deps']
      );
    }
  }

  public function enqueue_custom_scripts()
  {
    foreach ($this->scripts as $script) {
      wp_enqueue_script(
        $script['alias'], 
        $this->assets_uri . '/js/' . $script['src'], 
        $script['deps'],
        $script['in_footer'] ? $script['in_footer'] : true
      );
    }
  }

  public function enqueue_custom_styles()
  {
    foreach ($this->styles as $style) {
      wp_enqueue_style(
        $style['alias'], 
        $this->assets_uri . '/css/' . 
        $style['src'], 
        $style['deps']
      );
    }
  }
}
