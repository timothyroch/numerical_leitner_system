<?php

class Database
{
    private $host = "localhost";
    private $username = "root";  // Change to your database username
    private $password = "";  // Change to your database password
    private $db = "nls_db";

    public function connect()
    {
        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->db);
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $connection;
    }

    public function read($query)
    {
        $conn = $this->connect();
        $result = mysqli_query($conn, $query);

        if (!$result) {
            return false;
        } else {
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function readSingle($query)
    {
        $conn = $this->connect();
        $result = mysqli_query($conn, $query);

        if (!$result) {
            return false;
        } else {
            return mysqli_fetch_assoc($result);
        }
    }

    public function save($query)
    {
        $conn = $this->connect();
        $result = mysqli_query($conn, $query);

        if (!$result) {
            return false;
        } else {
            return true;
        }
    }

    public function saveWithPreparedStatement($query, $params, $types)
    {
        $conn = $this->connect();
        $stmt = mysqli_prepare($conn, $query);

        if (!$stmt) {
            die("Prepare failed: " . mysqli_error($conn));
        }

        // Bind parameters
        $paramArray = array_merge([$types], $params);
        $refArray = [];
        foreach ($paramArray as $key => $value) {
            $refArray[$key] = &$paramArray[$key];
        }
        call_user_func_array([$stmt, 'bind_param'], $refArray);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);
        
        if (!$result) {
            die("Execute failed: " . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        return $result;
    }
}

?>
