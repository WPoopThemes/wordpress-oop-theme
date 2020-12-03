<?php 
namespace Classes\Core;

/*
###########################
# USAGE:

use Classes\Core\Taxonomies as TaxonomyFactory;

$tax_factory = new TaxonomyFactory();

$tax_factory->register_new_taxonomies(
  array(
    array(
      'plural_name' => 'ttypes1',
      'singular_name' => 'ttype1',
      'tax_slug' => 'tax-ttype1',
      'post_type' => 'ptype'
    )
  )
);

###########################
*/

class Taxonomies {

  public function __construct(){
    add_action( 'init', array($this, 'register_new_taxonomies'), 0);
  }

  public function register_new_taxonomies($taxonomies = null){
    if(is_array($taxonomies)){
      foreach($taxonomies as $taxonomy){
        $labels = array(
          'name'                       => _x( $taxonomy['plural_name'], 'Taxonomy General Name', TEXT_DOMAIN),
          'singular_name'              => _x( $taxonomy['singular_name'], 'Taxonomy Singular Name', TEXT_DOMAIN),
          'all_items'                  => __( "All {$taxonomy['plural_name']}", TEXT_DOMAIN),
          'parent_item'                => __( "Parent {$taxonomy['singular_name']}", TEXT_DOMAIN),
          'parent_item_colon'          => __( "Parent {$taxonomy['singular_name']}:", TEXT_DOMAIN),
          'new_item_name'              => __( "New {$taxonomy['singular_name']}", TEXT_DOMAIN),
          'add_new_item'               => __( "Add New {$taxonomy['singular_name']}", TEXT_DOMAIN),
          'edit_item'                  => __( "Edit {$taxonomy['singular_name']}", TEXT_DOMAIN),
          'update_item'                => __( "Update {$taxonomy['singular_name']}", TEXT_DOMAIN),
          'view_item'                  => __( "View {$taxonomy['singular_name']}", TEXT_DOMAIN),
          'separate_items_with_commas' => __( 'Separate items with commas', TEXT_DOMAIN),
          'add_or_remove_items'        => __( 'Add or remove items', TEXT_DOMAIN),
          'choose_from_most_used'      => __( 'Choose from the most used', TEXT_DOMAIN),
          'popular_items'              => __( "Popular {$taxonomy['plural_name']}", TEXT_DOMAIN),
          'search_items'               => __( "Search {$taxonomy['plural_name']}", TEXT_DOMAIN),
          'not_found'                  => __( 'Not Found', TEXT_DOMAIN),
          'no_terms'                   => __( "No {$taxonomy['plural_name']}", TEXT_DOMAIN),
          'items_list'                 => __( 'Items list', TEXT_DOMAIN),
          'items_list_navigation'      => __( 'Items list navigation', TEXT_DOMAIN)
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
  }

}

?>