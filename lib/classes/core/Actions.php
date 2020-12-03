<?php 
  namespace Classes\Core;

/*
###########################
# USAGE:

use Classes\Core\Actions as ActionsFactory;

$actions_factory = new ActionsFactory(array(
  array(
    'name' => 'my_custom_action',
    'cb' => function(){
      echo '...';
    }
  )
));

###########################
*/

class Actions {

  public function __construct($actions = null){
    $this->actions = $actions;
    add_action('show-pagination', array($this, 'display_pagination'));

    if(is_array($this->actions)){
      foreach($this->actions as $action){
        add_action($action['name'], $action['cb']);
      }
    }
  }

  public function display_pagination(){
    global $wp_query;
    $big = 999999999; // need an unlikely integer
    $total = $wp_query->max_num_pages;
    if ( $total > 1 )  {
        // Get the current page
        if ( !$current_page = get_query_var('paged') ){
          $current_page = 1;
        }
        // Structure of “format” depends on whether we’re using pretty permalinks
        $permalinks = get_option('permalink_structure');
        $format = empty( $permalinks ) ? '&page=%#%' : '?paged=%#%';

        echo paginate_links(array(
          'base' => preg_replace('/\?.*/', '', get_pagenum_link(1)) . '%_%',
          'format' => $format,
          'current' => $current_page,
          'total' => $total,
          'mid_size' => 2,
          'type' => 'list',
          'prev_text' => __('&lt;'),
          'next_text' => __('&gt;'),
        ));
    }
  }

}
