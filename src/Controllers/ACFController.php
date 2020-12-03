<?php

namespace WPTheme\Controllers;

class ACFController {

  public $options_page_settings = array();
  public $acf_started;

  public function register(){
    $this->acf_started = function_exists('acf_add_options_page');

    if(!empty($options) && $this->acf_started){
      add_action('init', array($this, 'add_acf_options_page'));
    }
  }

  public function set_options_page(array $args){

    $this->options_page_settings = $args;

    return $this;
  }

  public function add_acf_options_page(){

    acf_add_options_page(array(
      'page_title' 	=> $this->options_page_settings['page_title'],
      'menu_title'	=> $this->options_page_settings['menu_title'],
      'menu_slug' 	=> $this->options_page_settings['slug'],
      'capability'	=> $this->options_page_settings['capabilities'],
      'redirect'		=> $this->options_page_settings['redirect']
    ));

    if(array_key_exists('sub_pages', $this->options_page_settings)){
      $this->add_acf_options_subpages(
        $this->options_page_settings['sub_pages']
      );
    }


    return $this;
  }

  public function add_acf_options_subpages(array $sub_pages){

    foreach ($sub_pages as $sub_page) {
      acf_add_options_sub_page(array(
        'page_title' 	=> $sub_page['title'],
        'menu_title'	=> $sub_page['menu_title'],
        'parent_slug'	=> $this->options_page_settings['slug'],
      ));
    }
  }

}