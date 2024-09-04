<?php

class Db
{
    private $dbhost = "localhost";
    private $dbname = "cloud_manager";
    private $dbpass = "";
    private $dbuser = "root";

    protected $conn = null;
    protected $stmt = null;

    public function __construct()
    {
        try {
            $dsn = "mysql:host={$this->dbhost};dbname={$this->dbname}";
            $this->conn = new PDO($dsn, $this->dbuser, $this->dbpass);
        } catch (Exception) {
            die("Something went wrong !");
        }
    }

    public function qry($qry, $params = [])
    {
        if ($qry) {
            $this->stmt = $this->conn->prepare($qry);
            $res = $this->stmt->execute($params);
            if ($res) {
                if (stripos($qry, "SELECT") === 0) {
                    return $this->stmt->fetch(PDO::FETCH_ASSOC);
                }

                return $this->stmt->rowCount();
            }

            return false;
        }
    }

    public function getId(){
        return $this->conn->lastInsertId();
    }
}

$db = new Db();