<?php 

namespace core\classes\dbWrapper;

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