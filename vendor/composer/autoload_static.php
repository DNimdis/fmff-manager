<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0da7575b111b1b53beb4f80653e5f610
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0da7575b111b1b53beb4f80653e5f610::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0da7575b111b1b53beb4f80653e5f610::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0da7575b111b1b53beb4f80653e5f610::$classMap;

        }, null, ClassLoader::class);
    }
}
