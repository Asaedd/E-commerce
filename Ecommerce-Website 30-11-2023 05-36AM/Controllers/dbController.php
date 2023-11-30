<?php

class dbController
{
    public $dbHost = "localhost";
    public $dbUser = "root";
    public $dbPassword = "";
    public $dbName = "ecommerce";
    public $connection;

    public function openConnection()
    {
        $this->connection=new mysqli($this->dbHost, $this->dbUser, $this->dbPassword, $this->dbName);
        if($this->connection->connect_error)
        {
            echo "Error in Con: " .$this->connection->connect_error; 
            return false;
        }
        else
        {
            return true;
        }
    }

    public function closeConnection()
    {
        if($this->connection)
        {
            $this->connection->close();
        }
        else
        {
            echo "Connection is not oppend";
        }
    }

    public function select($qry)
    {
        $result= $this->connection->query($qry);
        if(!$result)
        {
           echo "Error : ".mysqli_error($this->connection);
           return false; 
        }
        else
        {
            return $result->fetch_all(MYSQLI_ASSOC); 
        }
    }

    public function update($qry)
    {
        $result = $this->connection->query($qry);
        if (!$result) {
            echo "Error: " . mysqli_error($this->connection);
            return false;
        } else {
            return true;
        }
    }

    public function insert($query, $params)
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return true;
        } catch (Exception $e) {
            // Handle the exception (e.g., log the error)
            return false;
        }
    }

        // ...
    
        public function prepare($sql) {
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                // Handle the error, e.g., log or display an error message
                echo "Error preparing statement: " . $this->connection->error;
                return false;
            }
            return $stmt;
        }
    
        // ...
    
}

?>