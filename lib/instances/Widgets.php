<?php 

use Classes\Core\Widgets as WidgetLoader;
require_once(CLASSES_ROOT.'Widgets.php');

$widget_loader = new WidgetLoader();

//pass array('widget-name')
$widget_loader->init_widgets();

?>