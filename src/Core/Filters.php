<?php 
namespace WPTheme\Core;

use WPTheme\Controllers\FilterController;
use WPTheme\Controllers\ThemeController;


  class Filters extends ThemeController {

    public $filters;

    public function init(){
      $this->filters = new FilterController;

      /*$this->filters->set_filters([
        'name' => 'custom_filter',
        'action' => function(){

        }
      ]);*/
    }
  }
?>