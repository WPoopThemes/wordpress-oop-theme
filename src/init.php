<?php

namespace WPTheme;

/**
 * Automate class intantiation on theme startup
 */

final class Init
{

  public static function get_services()
  {
    return [
      Core\Actions::class,
      Core\Admin::class,
      Core\Assets::class,
      Core\Filters::class,
      Core\PostTypes::class,
      Core\Taxonomies::class,
      Core\ThemeConf::class,
      Utils\CustomMenu::class,
      Utils\Shortcodes::class
    ];
  }

  /**
   * Loop through the classes and calls the init() method if it exists
   */

  public static function register_services()
  {

    //self:: calls Init class instead of using $this, because the class was not initialised
    foreach (self::get_services() as $class) {

      //Triggers a method inside the not instantiated class
      $service = self::instantiate($class);

      //Checks if the init() method exists in the above class and triggers it
      if (method_exists($service, 'init')) {
        $service->init();
      }
    }
  }

  /**
   * Initialise the class
   */

  private static function instantiate($class)
  {
    return new $class();
  }
}
