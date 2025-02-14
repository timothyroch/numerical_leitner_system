<?php

class Create
{
    private $error = "";

    public function create_system($folderId, $data)
    {
        // Validate the input data
        $name = isset($data['systemname']) ? $data['systemname'] : '';
        
        if (empty($name)) {
            $this->error = "Name cannot be empty.";
            echo $this->error;
            return false;
        }

        // Escape the input data to prevent SQL injection
        $DB = new Database();
        $conn = $DB->connect();

        $name = mysqli_real_escape_string($conn, $name);
        $folderId = mysqli_real_escape_string($conn, $folderId);

        // SQL query to insert the new system
        $query = "INSERT INTO system (folderid, name) VALUES ('$folderId', '$name')";

        // Save the query
        $result = $DB->save($query);
        
        if ($result) {
            echo "System created successfully.";
            return true;
        } else {
            $this->error = "Error creating system. Database error: " . mysqli_error($conn);
            echo $this->error;
            return false;
        }
    }
}

?>
