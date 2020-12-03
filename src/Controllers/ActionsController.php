<?php

namespace WPTheme\Controllers;

class ActionsController extends ThemeController
{

  public $actions = array();
  public $default = array();

  public function register()
  {
    /*
    * Check if the theme has already been activated, 
    * if not, create theme_options into the DB at its first activation
    */
    add_action('after_switch_theme', array($this, 'init_options'));
    
    if($this->check_online_status){
      add_action('init', 'update_online_status');
    }

    if (!empty($this->actions)) {

      foreach ($this->actions as $action) {
        add_action(
          $action['name'],
          $action['callback']
        );
      }
    }
  }

  public function init_options()
  {
    if (!get_option('theme_options')) {
      update_option('theme_options', $this->default);
    }
  }

  public function set_actions(array $actions)
  {
    $this->actions = $actions;

    return $this;
  }

  public function update_online_status(){

    if(is_user_logged_in()){

      // Get online users list
      if(($logged_in_users = get_transient('users_online')) === false) $logged_in_users = array();

      $current_user = wp_get_current_user();
      $current_user = $current_user->ID;  
      $current_time = current_time('timestamp');

      if(!isset($logged_in_users[$current_user]) || ($logged_in_users[$current_user] < ($current_time - (15 * 60)))){
        $logged_in_users[$current_user] = $current_time;
        set_transient('users_online', $logged_in_users, 30 * 60);
      }

    }
  }
}
