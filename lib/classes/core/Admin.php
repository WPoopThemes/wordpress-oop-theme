<?php 
  namespace Classes\Core;

/*
###########################
# USAGE:

use Classes\Core\Admin as AdminPanelSetup;

$admin_panel_setup = new AdminPanelSetup();

$admin_panel_setup->add_options_page(array(
  'page_title' => 'Options',
  'menu_title' => 'Options',
  'slug' => 'options-page',
  'capabilities' => 'edit_posts',
  'redirect' => false,
  'sub_pages' => array(
    array(
      'title' => 'Header',
      'menu_title' 'Header',
      'slug' => 'site-header'
    )
  )
));

###########################
*/

  class Admin {

    public function __construct(){
      add_action('init', array($this, 'add_options_page'));
    }

    public function add_options_page($opts_page_settings = null){
      if(is_array($opts_page_settings)){
        if( function_exists('acf_add_options_page') ) {
	
          acf_add_options_page(array(
            'page_title' 	=> $opts_page_settings['page_title'],
            'menu_title'	=> $opts_page_settings['menu_title'],
            'menu_slug' 	=> $opts_page_settings['slug'],
            'capability'	=> $opts_page_settings['capabilities'],
            'redirect'		=> $opts_page_settings['redirect']
          ));
  
          if(array_key_exists('sub_pages', $opts_page_settings)){
            $sub_pages = $opts_page_settings['sub_pages'];
  
            foreach ($sub_pages as $sub_page) {
              acf_add_options_sub_page(array(
                'page_title' 	=> $sub_page['title'],
                'menu_title'	=> $sub_page['menu_title'],
                'parent_slug'	=> $opts_page_settings['slug'],
              ));
            }
          }
          
        }
      }
    }

  }
?>