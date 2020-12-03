<?php
namespace WPTheme\Controllers;

class TaxonomyController extends ThemeController {

  public $taxonomies = array();

  public function register(){
    if(!empty($this->taxonomies)){
      add_action( 'init', array($this, 'register_new_taxonomies'), 0);
    }
  }

  public function register_new_taxonomies(){
    foreach($taxonomies as $taxonomy){
      $labels = array(
        'name'                       => _x( $taxonomy['plural_name'], 'Taxonomy General Name', $this->text_domain),
        'singular_name'              => _x( $taxonomy['singular_name'], 'Taxonomy Singular Name', $this->text_domain),
        'all_items'                  => __( "All {$taxonomy['plural_name']}", $this->text_domain),
        'parent_item'                => __( "Parent {$taxonomy['singular_name']}", $this->text_domain),
        'parent_item_colon'          => __( "Parent {$taxonomy['singular_name']}:", $this->text_domain),
        'new_item_name'              => __( "New {$taxonomy['singular_name']}", $this->text_domain),
        'add_new_item'               => __( "Add New {$taxonomy['singular_name']}", $this->text_domain),
        'edit_item'                  => __( "Edit {$taxonomy['singular_name']}", $this->text_domain),
        'update_item'                => __( "Update {$taxonomy['singular_name']}", $this->text_domain),
        'view_item'                  => __( "View {$taxonomy['singular_name']}", $this->text_domain),
        'separate_items_with_commas' => __( 'Separate items with commas', $this->text_domain),
        'add_or_remove_items'        => __( 'Add or remove items', $this->text_domain),
        'choose_from_most_used'      => __( 'Choose from the most used', $this->text_domain),
        'popular_items'              => __( "Popular {$taxonomy['plural_name']}", $this->text_domain),
        'search_items'               => __( "Search {$taxonomy['plural_name']}", $this->text_domain),
        'not_found'                  => __( 'Not Found', $this->text_domain),
        'no_terms'                   => __( "No {$taxonomy['plural_name']}", $this->text_domain),
        'items_list'                 => __( 'Items list', $this->text_domain),
        'items_list_navigation'      => __( 'Items list navigation', $this->text_domain)
      );
      $args = array(
              'labels'                     => $labels,
              'hierarchical'               => false,
              'public'                     => true,
              'show_ui'                    => true,
              'show_admin_column'          => true,
              'show_in_nav_menus'          => true,
              'show_tagcloud'              => true
      );
      register_taxonomy( $taxonomy['tax_slug'], $taxonomy['post_type'], $args);
    }
  }

  public function set_custom_taxonomies(array $taxonomies){
    $this->taxonomies = $taxonomies;

    return $this;
  }
}