<?php

namespace WPTheme\Core;

use WPTheme\Controllers\AssetsController;
use WPTheme\Controllers\ThemeController;

class Assets extends ThemeController
{

  public $assets;

  public function init()
  {
    $this->assets = new AssetsController();
  }
}
