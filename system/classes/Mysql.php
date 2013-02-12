<?php 
include(INC.'Database.php');
class Mysql extends Database { 

    static private $instance; 

    public function __construct($dbHost=null, $dbName=null, $dbUser=null, $dbPass=null) { 
        parent::__construct($dbHost, $dbName, $dbUser, $dbPass); 
    } 

    static function getInstance($dbHost, $dbName, $dbUser, $dbPass) { 
        if(!Mysql::$instance) { 
            Mysql::$instance = new Mysql($dbHost, $dbName, $dbUser, $dbPass); 
        } 
        return Mysql::$instance; 
    } 

    public function __set($name, $value) { 
        if (isset($name) && isset($value)) { 
            parent::__set($name, $value); 
        } 
    } 

    public function __get($name) { 
        if (isset($name)) { 
            return parent::__get($name); 
        } 
    } 

    public function Connected() { 
        if (is_resource($this->connection)) { 
            return true; 
        } else { 
            return false; 
        } 
    } 

    public function AffectedRows() { 
        return mysql_affected_rows($this->connection); 
    } 

    public function Open() { 
        if (is_null($this->database)) 
            die("MySQL database not selected"); 
        if (is_null($this->hostname)) 
            die("MySQL hostname not set"); 

        $this->connection = @mysql_connect($this->hostname, $this->username, $this->password); 

        if ($this->connection === false) 
        die("Could not connect to database. Check your username and password then try again.\n"); 

        if (!mysql_select_db($this->database, $this->connection)) { 
            die("Could not select database"); 
        } 
    } 

    public function Close() { 
        mysql_close($this->connection); 
        $this->connection = null; 
    } 

    public function Query($sql) { 
        if ($this->connection === false) { 
            die('No Database Connection Found.'); 
        } 

        $result = @mysql_query($sql,$this->connection); 
        if ($result === false) { 
            die(mysql_error()); 
        } 
        return $result; 
    } 

    public function FetchArray($result) { 
        if ($this->connection === false) { 
            die('No Database Connection Found.'); 
        } 
         
        $data = @mysql_fetch_array($result); 
        if (!is_array($data)) { 
            die(mysql_error()); 
        } 
        return $data; 
    } 
} 
?> 