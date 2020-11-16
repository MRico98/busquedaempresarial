<?php
class DatabaseConnection {
    private $connection;

    function __construct($servername,$username,$password,$database){
        $this->connection = mysqli_connect($servername,$username,$password,$database);
    }

    function getConnection(){
        return $this->connection;
    }

    function closeConnection(){
        $this->connection->close();
    }

    function queryOperation($query){
        return $this->connection->query($query);
    }
}
?>