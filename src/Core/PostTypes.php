<?php
namespace WPTheme\Core;

use WPTheme\Controllers\PostTypeController;
use WPTheme\Controllers\ThemeController;


class PostTypes extends ThemeController{

  public $post_type;

  public function init(){
    $this->post_type = new PostTypeController();

    /*$this->post_type->set_post_types(
      array(
        array(
          'plural_name' => 'ptypes1',
          'singular_name' => 'ptype1',
          'description' => 'Lorem ipsum dolor',
          'taxonomies' => array('tax-ptype1'),
          'dash_icon' => '',
          'capability' => 'post|page',
          'slug' => 'pt-ptype1',
        )
      )
    );*/
  }

}


?>