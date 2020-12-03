<?php

namespace WPTheme\Controllers;

class WidgetController extends ThemeController
{
  public $widgets = array();

  public function register()
  {
    if(!empty($this->widgets)){
      $this->load_widgets();
    }
  }

  public function load_widgets(){
    foreach($this->widgets as $widget){
      if(file_exists($this->widgets_root . $widget . ".php")){

        include_once($this->widgets_root . $widget . ".php"); 

        add_action('widgets_init', function(){
          return register_widget($widget);
        });
      }
    }
  }

  public function set_widgets(array $widgets){
    $this->widgets = $widgets;

    return $this;
  }
}
