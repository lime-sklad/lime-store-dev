<?php 
date_default_timezone_set('Asia/Baku');

// ini_set('session.cookie_lifetime', 3600);

session_set_cookie_params(31536000 + 500, '/');

session_start();
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','lime_sklad');
define('SITEEMAIL','noreply@domain.com');

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



try 
{
	$dbpdo = new PDO("mysql:host=".DBHOST.";charset=utf8mb4;dbname=".DBNAME, DBUSER, DBPASS);
    $dbpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbpdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
	$loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/core/template/');
	$twig = new \Twig\Environment($loader);
    // $twig->addGlobal('mytitle', $mytitle);
} 
catch(PDOException $e)
{
    echo "Проблемы на сервере";
    exit();
}
?>
    