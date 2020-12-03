<?php

namespace WPTheme\Controllers;

class PostTypeController extends ThemeController {

  public $post_types = array();

  public function register(){
    if(!empty($this->pos_types)){
      add_action('init', array($this, 'register_custom_post_types'));
    }
  }

  public function register_custom_post_types(){
    foreach ($post_types as $post_type) {
      $labels = array(
                'name'                  => _x( $post_type['plural_name'], 'Post Type General Name', $this->text_domain),
                'singular_name'         => _x( $post_type['singular_name'], 'Post Type Singular Name', $this->text_domain),
                'menu_name'             => __( $post_type['plural_name'], $this->text_domain),
                'name_admin_bar'        => __( $post_type['plural_name'], $this->text_domain),
                'archives'              => __( 'Item Archives', $this->text_domain),
                'parent_item_colon'     => __( 'Parent Item:', $this->text_domain),
                'all_items'             => __( "All {$post_type['plural_name']}", $this->text_domain),
                'add_new_item'          => __( 'Add New Item', $this->text_domain),
                'add_new'               => __( "Add {$post_type['singular_name']}", $this->text_domain),
                'new_item'              => __( "New {$post_type['singular_name']}", $this->text_domain),
                'edit_item'             => __( "Edit {$post_type['singular_name']}", $this->text_domain),
                'update_item'           => __( 'Update Item', $this->text_domain),
                'view_item'             => __( 'View Item', $this->text_domain),
                'search_items'          => __( 'Search Item', $this->text_domain),
                'not_found'             => __( 'Not found', $this->text_domain),
                'not_found_in_trash'    => __( 'Not found in Trash', $this->text_domain),
                'featured_image'        => __( 'Featured Image', $this->text_domain),
                'set_featured_image'    => __( 'Set featured image', $this->text_domain),
                'remove_featured_image' => __( 'Remove featured image', $this->text_domain),
                'use_featured_image'    => __( 'Use as featured image', $this->text_domain),
                'insert_into_item'      => __( 'Insert into item', $this->text_domain),
                'uploaded_to_this_item' => __( 'Uploaded to this item', $this->text_domain),
                'items_list'            => __( 'Items list', $this->text_domain),
                'items_list_navigation' => __( 'Items list navigation', $this->text_domain),
                'filter_items_list'     => __( 'Filter items list', $this->text_domain)
      );
      //$rewrite = array('slug' => 'event/%%');
      $args = array(
              'label'                 => __( $post_type['singular_name'], $this->text_domain),
              'description'           => __( $post_type['description'], $this->text_domain),
              'labels'                => $labels,
              'supports'              => array( 'title', 'editor', 'author', 'thumbnail' ),
              'taxonomies'            => $post_type['taxonomies'],
              'hierarchical'          => false,
              'public'                => true,
              'show_ui'               => true,
              'show_in_menu'          => true,
              'menu_position'         => 7,
              'menu_icon'             => $post_type['dash_icon'],
              'show_in_admin_bar'     => true,
              'show_in_nav_menus'     => true,
              'can_export'            => true,
              'has_archive'           => true,		
              'exclude_from_search'   => false,
              'publicly_queryable'    => true,
              'capability_type'       => $post_type['capability']//,
              //'rewrite'               => $rewrite
      );
      register_post_type( $post_type['slug'], $args );
    }
  }

  public function set_post_types(array $post_types){
    $this->post_types = $post_types;

    return $this;
  }
}