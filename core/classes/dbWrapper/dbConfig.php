<?php 

namespace core\classes\dbWrapper;

date_default_timezone_set('Asia/Baku');

session_set_cookie_params(31536000 + 500, '/');

session_start();
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','lime_sklad');
define('SITEEMAIL','noreply@domain.com');
define('ROOT', $_SERVER['DOCUMENT_ROOT']);

class dbConfig 
{
    public $dbpdo;

    public function __construct()
    {        
        $this->dbpdo = new \PDO("mysql:host=".DBHOST.";charset=utf8mb4;dbname=".DBNAME, DBUSER, DBPASS);
        $this->dbpdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->dbpdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

        return $this;
    }
}