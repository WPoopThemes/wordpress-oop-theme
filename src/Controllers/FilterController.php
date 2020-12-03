<?php

namespace WPTheme\Controllers;

class FilterController {

  public $filters = array();

  public function register(){
    
    //add_filter('init', 'change_author_permalink_base');
    add_filter('get_menu_items', array($this,'get_menu_items'), 10, 1);
    
    if(!mpty($this->filters)){

      foreach($this->filters as $filter){
        add_filter($filter['name'], $filter['cb']);
      }

    }

    remove_filter ('the_excerpt', 'wpautop');
  }

  public function set_filters(array $filters){
    $this->filters = $filters;

    return $this;
  }

  public function get_menu_items($selected_location) {
    $locations = get_nav_menu_locations();
    $args = array(
      'order'                  => 'ASC',
      'orderby'                => 'menu_order',
      'post_type'              => 'nav_menu_item',
      'post_status'            => 'publish',
      'output'                 => ARRAY_A,
      'output_key'             => 'menu_order',
      'nopaging'               => true,
      'update_post_term_cache' => false 
    );
    $items_found = wp_get_nav_menu_items($locations[$selected_location], $args);
    $menu = array();
    $submenu = array();
    if(!empty($items_found)){
        foreach ($items_found as $m) {
            if (empty($m->menu_item_parent)) {
                $menu[$m->ID]['object_id'] = $m->object_id;
                $menu[$m->ID]['object'] = $m->object;
                $menu[$m->ID]['title'] = $m->title;
                $menu[$m->ID]['url'] = $m->url;
                $menu[$m->ID]['type'] = $m->type;
                $menu[$m->ID]['classes'] = $m->classes;
                $menu[$m->ID]['children'] = array();
            } else {
              $submenu[$m->ID]['object_id'] = $m->object_id;
              $submenu[$m->ID]['object'] = $m->object;
              $submenu[$m->ID]['title'] = $m->title;
              $submenu[$m->ID]['url'] = $m->url;
              $submenu[$m->ID]['type'] = $m->type;
              $submenu[$m->ID]['classes'] = $m->classes;
              $menu[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID];
            }
        }
    }
    //var_dump($items);
    $menu = (object)$menu;

    return $menu;
  }

  public function change_author_permalink_base()
  {
    global $wp_rewrite;
    $wp_rewrite->author_base = "user";
  }
}