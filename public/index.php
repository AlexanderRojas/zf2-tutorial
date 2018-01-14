<?php

use Zend\Mvc\Application;
use Zend\Stdlib\ArrayUtils;

/**
 * when using Apache. Si pongo la variable APPLICATION_ENV = "development"
 * Entonces ponga a PHP  mostrar TODOS los errores.
 * Display all errors when APPLICATION_ENV is development.
 * you can use the APPLICATION_ENV setting in your VirtualHost to let PHP
 * output all its errors to the browser. This can be useful during the development of your application.
 */
 if ($_SERVER['APPLICATION_ENV'] == 'development') {
     error_reporting(E_ALL);
     ini_set("display_errors", 1);
     } // Ya la configuré en vhost Apache

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
//echo getcwd() . "\n";
chdir(dirname(__DIR__));
//echo getcwd() . "\n";
/**
 * __DIR__ : Constante mágica (se devuelven durante la compilación y cambia según dónde se empleen)
 * Directorio del fichero. Si se utiliza dentro de un include, devolverá el directorio del fichero incluido.
 * Esta constante es igual que dirname(__FILE__). El nombre del directorio no lleva la barra finla a no ser que 
 * esté en el directorio root.
 * 
 * dirname() : Develve la ruta de un directorio padre.
 * chdir(dirx): cambia el directorio actual a dirx
 * Veo que lo que hace acá es  deshacerse de /public
 * pasa de C:\wamp\www\zf2-tutorial\public  a C:\wamp\www\zf2-tutorial 
 */


// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}//Esto es para en caso de usar server integrado. No lo estudio por el momento

// Composer autoloading
include __DIR__ . '/../vendor/autoload.php';
// Se suponde que carga todas las clases. Las deja disponibles en los archivos.

if (! class_exists(Application::class)) {
    throw new RuntimeException(
        "Unable to load application.\n"
        . "- Type `composer install` if you are developing locally.\n"
        . "- Type `vagrant ssh -c 'composer install'` if you are using Vagrant.\n"
        . "- Type `docker-compose run zf composer install` if you are using Docker.\n"
    );
}

// Retrieve configuration
$appConfig = require __DIR__ . '/../config/application.config.php';
if (file_exists(__DIR__ . '/../config/development.config.php')) {
    $appConfig = ArrayUtils::merge($appConfig, require __DIR__ . '/../config/development.config.php');
}

// Run the application!
Application::init($appConfig)->run();
