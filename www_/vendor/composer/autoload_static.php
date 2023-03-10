<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticIniteb36680ddc5b58255cbff6600dd47539
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'J' => 
        array (
            'Jh\\Kum\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Jh\\Kum\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticIniteb36680ddc5b58255cbff6600dd47539::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticIniteb36680ddc5b58255cbff6600dd47539::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticIniteb36680ddc5b58255cbff6600dd47539::$classMap;

        }, null, ClassLoader::class);
    }
}
