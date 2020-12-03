<?php 
namespace Classes\Core;

/*
###########################
# USAGE:

use Classes\Core\Blocks as BlocksFactory;

$blocks_factory = new BlocksFactory();

$blocks_factory->register_blocks(array(
  array(
    'name' => '',
    'title' => '',
    'desc' => '',
    'template' => '', // path/to/template.php
    'category' => '',
    'icon' => '',
    'keywords' => array()
  )
));

###########################
*/

class Blocks{

  public function __construct(){
    add_action('acf/init', array($this, 'register_blocks'));
  }

  public function register_blocks($blocks = null){
    if(is_array($blocks)){
      foreach ($blocks as $block) {
        acf_register_block_type(array(
          'name'              => $block['name'],
          'title'             => __($block['title']),
          'description'       => __($block['desc']),
          'render_template'   => $block['template'],
          'category'          => $block['category'],
          'icon'              => $block['icon'],
          'keywords'          => $block['keywords'],
      ));
      }
    }
  }

}

?>