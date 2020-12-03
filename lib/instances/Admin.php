<?php 
  use Classes\Core\Admin as AdminPanelSetup;
  require_once(CLASSES_ROOT.'Admin.php');
  
  $admin_panel_setup = new AdminPanelSetup();
  
  $admin_panel_setup->add_options_page(array(
      'page_title' => 'Theme Options',
      'menu_title' => 'Theme Options',
      'slug' => 'options-page',
      'capabilities' => 'edit_posts',
      'redirect' => false
      )
  );
?>