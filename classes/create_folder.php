<?php

class Folder
{
    public function create_folder($data)
    {

         // Validate the input data
         $name = isset($data['name']) ? $data['name'] : '';

         if (empty($name)) {
            $this->error = "Name cannot be empty.";
            echo $this->error;
            return false;
        }

        if (!isset($_SESSION['nls_db_userid'])) {
            $this->error = "User is not logged in.";
            echo $this->error;
            return false;
        }
        
        $userid = $_SESSION['nls_db_userid'];




        if (is_array($data)) {
            $foldername = $data['name'];
        } else {
            $foldername = $data; // If $data is not an array, assume it is the folder name.
      }




                // Escape the input data to prevent SQL injection
                $DB = new Database();
                $conn = $DB->connect();

        $query = "INSERT INTO folder (userid, foldername) VALUES (' $userid', '$foldername')";

        $DB = new Database();
        $result = $DB->save($query);

        if ($result) {
            return true;
        } else {
            echo "Error creating the folder.";
        }
    }
}
