<?php

namespace WPTheme\Utils;

use WPTheme\Controllers\ThemeController;

class UserController extends ThemeController
{

  public function register()
  {
    $this->generate_custom_profile_fields();
  }

  public function get_current_user_data()
  {
    $user_ID = get_current_user_id();
    $user_data = get_userdata($user_ID);

    return $user_data;
  }

  public function check_online_status(int $user_id)
  {

    // get the online users list
    $logged_in_users = get_transient('users_online');

    // online, if (s)he is in the list and last activity was less than 15 minutes ago
    return isset($logged_in_users[$user_id]) && ($logged_in_users[$user_id] > (current_time('timestamp') - (15 * 60)));
  }


  public function show_custom_profile_fields($user)
  { 
    require_once($this->views_path . 'user/profile-custom-fields.php');
  }

  public function save_custom_profile_fields(int $user_id, array $fields, $post_obj)
  {
    if (!current_user_can('edit_user', $user_id)) {
      return false;
    }

    foreach ($fields as $field) {
      if (get_the_author_meta($field, $user_id) != $field) {
        update_user_meta($user_id, $field, $post_obj[$field]);
      }
    }
    return $this;
  }

  public function generate_custom_profile_fields(){

    add_action('show_user_profile', array($this, 'show_custom_profile_fields'));
    add_action('edit_user_profile', array($this, 'show_custom_profile_fields'));

    add_action('personal_options_update', array($this, 'save_custom_profile_fields'));
    add_action('edit_user_profile_update', array($this, 'save_custom_profile_fields'));

    return $this;
  }
}
