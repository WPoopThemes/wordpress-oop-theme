<?php 
  namespace Classes\Core;

/*
###########################
# USAGE:

use Classes\Core\ThemeConf as ThemeConfiguration;

$theme_configuration = new ThemeConfiguration();

$theme_configuration->register_theme_menu(
  array(
    array(
      'location' => '',
      'desc' => ''
    )
  )
);

$theme_configuration->add_sidebar(
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

$theme_configuration->add_support(
  array(
    array(
      'feature' => 'post-thumbnails',
      'args' => 'post' | array('post', 'page')
    )
  )
);

###########################
*/

  class ThemeConf {

    public function __construct(){
      add_action('init', array($this, 'register_theme_menu'));
      add_action('after_setup_theme',array($this,'add_support') );
      add_action('widgets_init',array($this,'remove_default_widgets'));
      add_action('widgets_init',array($this,'add_sidebar'));
  }


  public function remove_default_widgets(){
      unregister_widget('WP_Widget_Pages');     
      unregister_widget('WP_Widget_Calendar');     
      unregister_widget('WP_Widget_Archives');     
      unregister_widget('WP_Widget_Links');     
      unregister_widget('WP_Widget_Meta');     
      unregister_widget('WP_Widget_Search');     
      unregister_widget('WP_Widget_Text');     
      unregister_widget('WP_Widget_Categories');     
      unregister_widget('WP_Widget_Recent_Posts');     
      unregister_widget('WP_Widget_Recent_Comments');     
      unregister_widget('WP_Widget_RSS');     
      unregister_widget('WP_Widget_Tag_Cloud');     
      unregister_widget('WP_Nav_Menu_Widget');     
  }

  public function register_theme_menu($menu = null){ 
    //Register at least the main menu
    register_nav_menu('main-menu', __( 'Main menu' ));
    
    //Register other menus
    if(is_array($menu)){
      foreach ($menu as $menu_item) {
        register_nav_menu($menu_item['location'], __($menu_item['desc']));
      }
    }
  }

  public function add_sidebar($sidebars = null){
    
    //Register at least one sidebar
    register_sidebar(
        array(
        'name' => __( 'Main Sidebar', TEXT_DOMAIN),
        'id' => 'main-sidebar',
        'description' => __( 'Sidebar to display widgets near articles or pages.', TEXT_DOMAIN),
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
        ) 
    );

    //Register other sidebars
    if(is_array($sidebars)){
      foreach($sidabars as $sidebar){
        register_sidebar(
          array(
          'name' => __( $sidebar['name'], TEXT_DOMAIN),
          'id' => $sidebar['id'],
          'description' => __( $sidebar['description'], TEXT_DOMAIN),
          'before_widget' => $sidebar['before_widget'],
          'after_widget'  => $sidebar['after_widget'],
          'before_title'  => $sidebar['before_title'],
          'after_title'   => $sidebar['after_title'],
          ) 
        );
      }
    }
  }

  public function add_support($features = null) {
    add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
    if(is_array($features)){
      foreach($features as $feature){
        add_theme_support($feature['feature'], $feature['args']);
      }
    }
  }

  }
?>