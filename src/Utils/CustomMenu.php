<?php 
namespace WPTheme\Utils;
// Usage:
  //do_action('render_custom_menu', [
  //  'menu-name' => 'main-menu',
  //  'listItemClasses' => 'list__item',
  //  'listAnchorClasses' => 'list__link',
  //  'listItemTitleClasses' => 'list__title',
  //  'subItemClasses' => 'list',
  //  'subItemListClasses' => 'list__item'
  //  'subItemTitleClasses' => 'list__title',
  //  'subItemAnchorClasses' => 'list__link',
  //  'dataIconName' => '',
  //]);

  class CustomMenu {
    public function __construct(){
      add_action('render_custom_menu', array($this,'render_custom_menu'));
    }
  
    public function render_custom_menu($params){
      // $check = is_home() || is_front_page() ? 'current-menu-item' : '';
      // $homeItem = '
      // <li class="'.$check.' '.$params['listItemClasses'].'">
      //   <a href="'.get_home_url().'" class="'.$params['listAnchorClasses'].'">
      //     <!--<h3 class="'.$params['listItemTitleClasses'].'">Home</h3>-->
      //     Home
      //   </a>
      // </li>
      // ';
      // echo $homeItem;
      $items = apply_filters('get_menu_items', $params['menu-name']);

      //var_dump($items);

      $id_element = get_queried_object_id();
      
      $list_term = array();

      if(is_single()){
          $term_element = wp_get_post_terms($id_element,'category');
          $list_term = wp_list_pluck( $term_element, 'term_id');
      }

      if(is_category()){
          $term_selected = get_term($id_element,'category');
          $list_term[] = $term_selected->parent;
      }

      $objectQueried = get_queried_object();

      global $gPostTypeArchive;

      foreach($items as $menu_item){
        $listBlock = '';
        $menu_item = (object)$menu_item;
        $link_pattern = '<a href="{link}" class="list__link">';

        if(!empty($menu_item->children)){
          $link_pattern = '<a class="'.$params['subItemAnchorClasses'].'" data-icon="'.$params['dataIconName'].'">';
        }
        //Primary menu
        switch($menu_item->type){
          case 'taxonomy':
              $info_term = get_term($menu_item->object_id,$menu_item->object);
              $isCurrent = $menu_item->object_id == get_queried_object_id() || in_array($menu_item->object_id,$list_term) ? 'current-menu-item' : '';
              $hasChildren = $menu_item->children ? 'list__item--has-children' : '';
              $listBlock.='
                <li class="'.$isCurrent.' '.$params['listItemClasses'].' '. $hasChildren .'">
                <a class="'.$params['listAnchorClasses'].'" href="'.$menu_item->url.'">
                    <h3 class="'.$params['listItemTitleClasses'].'">'.$info_term->name.'</h3>
                </a>
              ';
              echo $listBlock;
          break;
          case 'post_type_archive':
            //$info_term = get_term($menu_item->object_id,$menu_item->object);
            $isCurrent = $objectQueried->name == $menu_item->object ||  $gPostTypeArchive ==  $menu_item->object ? 'current-menu-item' : '';
            $hasChildren = $menu_item->children ? 'list__item--has-children' : '';
            $listBlock.='
              <li class="'.$isCurrent.' '.$params['listItemClasses'].' '. $hasChildren .'">
              <a class="'.$params['listAnchorClasses'].'" href="'.$menu_item->url.'">
                <h3 class="'.$params['listItemTitleClasses'].'">'.$menu_item->title.'</h3>
              </a>
            ';
            echo $listBlock;
          break;
          default:
            $info_post = get_post($menu_item->object_id);
            $isCurrent = $menu_item->object_id == get_queried_object_id() || strcmp($menu_item->url,get_home_url(null,'/')) == 0 && (is_home() || is_front_page())  ? 'current-menu-item' : '';
            $hasChildren = $menu_item->children ? 'list__item--has-children' : '';
            $listBlock.='
            <li class="'.$isCurrent.' '.$params['listItemClasses'].' '. $hasChildren .'">
              <a class="'.$params['listAnchorClasses'].'" href="'.$menu_item->url.'">
                <h3 class="'.$params['listItemTitleClasses'].'">'.$menu_item->title.'</h3>
              </a>
            ';
            echo $listBlock;
          break;
        }
        //Submenu
        if(!empty($menu_item->children)){
          $subListBlock = '';
          $childrenBlock = '';
          foreach($menu_item->children as $menu_item_child){
            $menu_item_child = (object)$menu_item_child;
            switch($menu_item_child->type){
                case 'taxonomy':
                    $info_term = get_term($menu_item_child->object_id,$menu_item_child->object);
                    $isCurrent = $menu_item_child->object_id == get_queried_object_id() || in_array($menu_item_child->object_id,$list_term) ? 'current-menu-item' : '';
                    $childrenBlock.='
                      <li class="'.$isCurrent.' '.$params['subItemListClasses'].'">
                        <a href="'.$menu_item_child->url.'" class="'.$params['subItemAnchorClasses'].'">
                            <h3 class="'.$params['subItemTitleClasses'].'">'.$info_term->name.'</h3>
                        </a>
                      </li>
                    ';
                break;
                default:
                    $info_post = get_post($menu_item_child->object_id);
                    $isCurrent = $menu_item_child->object_id == get_queried_object_id()  ? 'current-menu-item' : '';
                    $childrenBlock.='
                    <li class="'.$isCurrent.' '.$params['subItemListClasses'].'">
                      <a href="'.$menu_item_child->url.'" class="'.$params['subItemAnchorClasses'].'">
                          <h3 class="'.$params['subItemTitleClasses'].'">'.$info_post->post_title.'</h3>
                      </a>
                    </li>
                  ';
                break;
            }
          }
          $subListBlock.='
          <ul class="'.$params['subItemClasses'].'">'.$childrenBlock.'</ul>
          ';
          echo $subListBlock;
        }
      }
    }
  }
?>