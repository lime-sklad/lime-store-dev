<?php


require_once 'vendor/autoload.php';

spl_autoload_register(function ($class) {
    if(basename($class) !== 'PDO') {
        // Преобразовать пространство имен и имя класса в путь к файлу
        $file = $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', '/', $class) . '.php';

        // Если файл существует, загрузить его
        if (file_exists($file)) {
            require_once $file;
        }
    }
});


// $loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/core/template/');
// $twig = new \Twig\Environment($loader);

$Render = new \Core\Classes\Services\RenderTemplate;

$db = new \core\classes\dbWrapper\db;

$main = new \Core\Classes\System\Main;

$accessManager = new \Core\Classes\Privates\AccessManager;

$init = new \Core\Classes\System\Init;

$utils = new \Core\Classes\System\Utils;

$productsFilter = new \Core\Classes\Services\ProductsFilter;

$category = new \Core\Classes\Services\Category;

$provider = new \Core\Classes\Services\Provider;

$user = new \Core\Classes\Privates\User;

$products = new \Core\Classes\Products;