<?php 
namespace WPTheme\Core;

use WPTheme\Controllers\ThemeConfigurationController;
use WPTheme\Controllers\ThemeController;

class ThemeConf extends ThemeController
{

  public $configuration;

  public function init(){
    $this->configuration = new ThemeConfigurationController();

    /*$this->configuration->register_theme_menu(
      array(
        array(
          'location' => '',
          'desc' => ''
        )
      )
    );

    $this->configuration->add_sidebar(
      array(
        array(
          'name' => '',
          'id' => '',
          'description' => '',
          'before_widget' => '',
          'after_widget'  => '',
          'before_title'  => '',
          'after_title'   => ''
        )
      )
    );

    $this->configuration->add_support(
      array(
        array(
          'feature' => 'post-thumbnails',
          'args' => 'post' //array('post', 'page')
        )
      )
    );

    $this->configuration->register();*/
  }

}
