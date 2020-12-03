<?php

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
  require_once(__DIR__ . '/vendor/autoload.php');
}

use WPTheme\Init;

Init::register_services();