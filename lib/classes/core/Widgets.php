<?php 
  namespace Classes\Core;

/*
###########################
# USAGE:

use Classes\Core\Widgets as WidgetsFactory;

$widgets_factory = new WidgetsFactory(array(
  'widget_name',
  'my_widget_name'
));

###########################
*/

  class Widgets {
    protected $widgets;
    
    public function __construct() {
        $this->init_widgets();
    }

    protected function load_widgets($widgets){
      if(is_array($widgets)){
        foreach($widgets as $widget){
          if(file_exists(WIDGETS_ROOT.$widget.".widget.php")){
            include_once(WIDGETS_ROOT.$widget.".widget.php"); 
            add_action('widgets_init', function(){
              return register_widget($widget);
            });
          }
        }
      }
    }   

    public function init_widgets($widgets = null){
      $this->load_widgets($widgets);
    }
  }
?>