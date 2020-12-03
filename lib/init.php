<?php

#Autoload all classes
class ClassAutoLoader {
    private $path;
    public function __construct($path) {
        $this->path = $path;
        spl_autoload_register( array($this, 'autoload') );
    }

    function autoload($class) {
        $file = $this->path . str_replace('\\', '/', $class) . '.php';
        if(is_file($file)){
            include_once($file);
        }
    }
}
$class_autoloader = new ClassAutoLoader(LIB_ROOT);

#Imports all instances of core classes
$classes_list = array(
    'Actions',
    'ThemeConf',
    'Filters',
    'Admin',
    'PostTypes',
    'Taxonomies',
    'Assets',
    'Modules',
    'Widgets',
    'CustomMenu'
);

foreach ($classes_list as $class) {
    include_once(LIB_ROOT . 'instances/' . $class . '.php');
}
?>