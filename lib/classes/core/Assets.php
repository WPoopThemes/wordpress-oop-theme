<?php 
namespace Classes\Core;

/*
###########################
# USAGE:

use Classes\Core\Assets as ThemeAssets;

$theme_assets = new ThemeAssets(
    array(
      'enqueue' => array(
        'styles' => array(
          array(
            'alias' => '',
            'src' => '',
            'deps' => array()
          )
        ),
        'scripts' => array(
          array(
            'alias' => '',
            'src' => ASSETS_URI . '',
            'deps' => array(''),
          )
        )
      ),
      'register' => array(
        'styles' => array(
          array(
            'alias' => '',
            'src' => '',
            'deps' => array()
          )
        ),
        'scripts' => array(
          array(
            'alias' => '',
            'src' => ASSETS_URI . '',
            'deps' => array(''),
          )
        )
      )
    )
);

###########################
*/

class Assets {

  public function __construct($assets = null) {
    $this->assets = $assets;

    if(is_array($this->assets)){

      if(array_key_exists('register', $this->assets)){

        if(is_array($this->assets['register'])){

          add_action( 'wp_enqueue_scripts', function (){
            if(is_array($this->assets['register']['styles'])){
              foreach ($this->assets['register']['styles'] as $style) {
                wp_register_style($style['alias'], ASSETS_URI . $style['src'], $style['deps']);
              }
            }
          });
  
          add_action( 'wp_enqueue_scripts', function (){
            if(is_array($this->assets['register']['scripts'])){
              foreach ($this->assets['register']['scripts'] as $script) {
                wp_register_script($script['alias'], ASSETS_URI . $script['src'], $script['deps']);
              }
            }
          });
        }
        
      }

      if(is_array($this->assets['enqueue'])){

        add_action( 'wp_enqueue_scripts', function (){
          if(is_array($this->assets['enqueue']['styles'])){
            foreach ($this->assets['enqueue']['styles'] as $style) {
              wp_enqueue_style($style['alias'], ASSETS_URI . $style['src'], $style['deps']);
            }
          }
        });

        add_action( 'wp_enqueue_scripts', function (){
          if(is_array($this->assets['enqueue']['scripts'])){
            foreach ($this->assets['enqueue']['scripts'] as $script) {
              wp_enqueue_script($script['alias'], ASSETS_URI . $script['src'], $script['deps']);
            }
          }
        });

      }
    }
  }
}
