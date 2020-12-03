<?php
namespace WPTheme\Controllers;

class ThemeConfigurationController extends ThemeController
{

  public $features = array();
  public $menu = array();
  public $sidebars = array();

  public function register()
  {
    add_action('init', array($this, 'register_theme_menu'));
    add_action('after_setup_theme', array($this, 'add_support'));
    //add_action('widgets_init', array($this, 'remove_default_widgets'));
    add_action('widgets_init', array($this, 'add_sidebar'));
  }


  public function remove_default_widgets()
  {
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

  public function register_theme_menu()
  {
    //Register at least the main menu
    register_nav_menu('main-menu', __('Main menu'));

    //Register other menus
    if (!empty($this->menu)) {
      foreach ($this->menu as $menu_item) {
        register_nav_menu($menu_item['location'], __($menu_item['desc']));
      }
    }
  }

  public function add_sidebar()
  {

    //Register at least one sidebar
    register_sidebar(
      array(
        'name' => __('Main Sidebar', $this->text_domain),
        'id' => 'main-sidebar',
        'description' => __('Sidebar to display widgets near articles or pages.', $this->text_domain),
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
      )
    );

    //Register other sidebars
    if (!empty($this->sidebars)) {
      foreach ($this->sidabars as $sidebar) {
        register_sidebar(
          array(
            'name' => __($sidebar['name'], $this->text_domain),
            'id' => $sidebar['id'],
            'description' => __($sidebar['description'], $this->text_domain),
            'before_widget' => $sidebar['before_widget'],
            'after_widget'  => $sidebar['after_widget'],
            'before_title'  => $sidebar['before_title'],
            'after_title'   => $sidebar['after_title'],
          )
        );
      }
    }
  }

  public function add_support()
  {
    add_theme_support('post-thumbnails', array('post', 'page'));

    if (!empty($this->features)) {
      foreach ($this->features as $feature) {
        add_theme_support($feature['feature'], $feature['args']);
      }
    }
  }
}
