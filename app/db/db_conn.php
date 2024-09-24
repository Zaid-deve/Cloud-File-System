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
        try {
            if ($qry) {
                $this->stmt = $this->conn->prepare($qry);
                $res = $this->stmt->execute($params);
                if ($res) {
                    if (stripos($qry, "SELECT") === 0) {
                        $data = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
                        if (count($data) == 1) {
                            return count($data[0]) == 1 ? reset($data[0]) : $data[0];
                        }
                        return $data;
                    }

                    return $this->stmt->rowCount();
                }
            }
        } catch (Exception $e) {
        }

        return false;
    }

    public function getId()
    {
        return $this->conn->lastInsertId();
    }

    function getStatement()
    {
        return $this->stmt;
    }

    public function getErr()
    {
        return $this->conn->errorInfo()['1'];
    }

    public function closeConn()
    {
        $this->conn = null;
    }

    public function __destruct()
    {
        $this->closeConn();
    }
}

$db = new Db();
