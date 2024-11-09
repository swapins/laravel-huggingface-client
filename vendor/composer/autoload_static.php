<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita53c98c0bd5668234d3b80ed653e3cd0
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Swapinvidya\\LaravelHuggingfaceClient\\' => 37,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Swapinvidya\\LaravelHuggingfaceClient\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInita53c98c0bd5668234d3b80ed653e3cd0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita53c98c0bd5668234d3b80ed653e3cd0::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita53c98c0bd5668234d3b80ed653e3cd0::$classMap;

        }, null, ClassLoader::class);
    }
}
