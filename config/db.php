<?php
date_default_timezone_set('Asia/Manila');
class DB
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "ialertu";
    private $conn;

    function getConnectionString()
    {
        $con = mysqli_connect($this->host, $this->username, $this->password, $this->dbname) or die("Connection failed" . mysqli_connect_error());

        if (mysqli_connect_error()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        } else {
            $this->conn = $con;
        }
        return $this->conn;
    }
}
abstract class BaseController
{
    public function _connection()
    {
        $conn = new DB();
        return $conn->getConnectionString();
    }
    function rsc($str)
    {
        // Allow only letters, numbers, and underscores
        $cleanedString = preg_replace('/[^a-zA-Z0-9\s\-\.,_]/', '', $str);
        return $cleanedString;
    }
}
