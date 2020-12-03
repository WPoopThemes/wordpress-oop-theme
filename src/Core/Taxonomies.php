<?php 
namespace WPTheme\Core;

use WPTheme\Controllers\TaxonomyController;
use WPTheme\Controllers\ThemeController;

class Taxonomies extends ThemeController {

  public $taxonomies;

  public function init(){
    $this->taxonomies = new TaxonomyController();

    /*$this->taxonomies->register_new_taxonomies(ù
      array(
        array(
          'plural_name' => 'ttypes1',
          'singular_name' => 'ttype1',
          'tax_slug' => 'tax-ttype1',
          'post_type' => 'ptype'
        )
      )
    );*/
  }

}

?>