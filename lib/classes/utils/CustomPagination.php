<?php 
namespace Classes\Utils;

//Usage:
// do_action('render_pagination');

class CustomPagination(){

  function __construct(){
    add_action('render_pagination', array($this, 'render_custom_pagination'));
  }

  public function render_custom_pagination(){
      
    // Don't print empty markup if there's only one page.
      if ($GLOBALS['wp_query']->max_num_pages < 2) {
        return;
      }

      $paged        = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
      $pagenum_link = html_entity_decode(get_pagenum_link());
      $query_args   = array();
      $url_parts    = explode('?', $pagenum_link);

      if (isset($url_parts[1])) {
        wp_parse_str($url_parts[1], $query_args);
      }

      $pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
      $pagenum_link = trailingslashit($pagenum_link) . '%_%';

      // Set up paginated links.
      $links = paginate_links(array(
        'base'     => $pagenum_link,
        'total'    => $GLOBALS['wp_query']->max_num_pages,
        'current'  => $paged,
        'mid_size' => 1,
        'add_args' => array_map('urlencode', $query_args),
        'prev_text' => '<span class="prev">Prev</span>',
        'next_text' => '<span class="next">Next</span>',
      ));

      $markup = '';
      $markup_content = wp_kses_post($links);

      $markup .= '<nav class="navigation paging-navigation clearfix">';
      $markup .= '<div class="pagination loop-pagination">';
      $markup .= $markup_content;
      $markup .= '</div>';
      $markup .= '</nav';

      if($links){
        echo $markup;
      }
  }

}


?>