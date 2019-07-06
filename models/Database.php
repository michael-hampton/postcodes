<?php

class Database implements DatabaseInterface {

    private $connection;
    private $dbhost;
    private $dbuser;
    private $dbpass;
    private $dbname;

// Constructor
    public function __construct(Config $objConfig) {

        $arrConfig = $objConfig->getConfig();

        if (empty($arrConfig))
        {

            throw new Exception('Unable to get config');
        }

        $this->dbhost = $arrConfig['db_host'];
        $this->dbname = $arrConfig['db_name'];
        $this->dbuser = $arrConfig['db_user'];
        $this->dbpass = $arrConfig['db_pass'];

        if (!$this->connect())
        {
            throw new Exception('Unable to connect to db');
        }
    }

// Get the connection	
    public function getConnection() {
        return $this->connection;
    }

    /**
     * 
     * @return boolean
     */
    public function connect() {
        try {

            $this->connection = new PDO("mysql:host=$this->dbhost;dbname=$this->dbname", $this->dbuser, $this->dbpass);
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }

        return true;
    }

}
