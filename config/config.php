<?php
    class ConnectDB
    {
        private $servername = "localhost";
        private $username = "sa";
        private $password = "a";
        private $dbname = "db_qlda_qlbh";
        private $connection = null;
        function __construct()
        {
            $this->connection = new mysqli($this->servername,$this->username,$this->password,$this->dbname);
            if ($this->connection->connect_error){
                die("Couldn't connect to the database\n".$this->connection->connect_error);
            }
        }
        function closeConn() {
            $this->connection->close();
        }
        function getConn() {
            return $this->connection;
        }
    }


