<?php 
namespace WPTheme\Core;

use WPTheme\Controllers\ThemeController;
use WPTheme\Controllers\WidgetController;

class Widgets extends ThemeController {

  public $widgets;

  public function init(){
    $this->widgets = new WidgetController();

    /*$this->widgets->set_widgets(
      array(
        array(
          'widget_name',
          'my_widget_name'
        )
      )
    );*/
  }
}