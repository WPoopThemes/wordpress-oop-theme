<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitaf87a591dc0e3a41e9f656f2e21d760b
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WPTheme\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WPTheme\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitaf87a591dc0e3a41e9f656f2e21d760b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitaf87a591dc0e3a41e9f656f2e21d760b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitaf87a591dc0e3a41e9f656f2e21d760b::$classMap;

        }, null, ClassLoader::class);
    }
}
