<?php

class SystemCard
{
    public function get_system($id)
    {
        $DB = new Database();
        $query = "SELECT * FROM system";
        $systems = $DB->read($query);


        if ($systems) {
            return $systems;
        } else {
            return false;
        }
    }

    public function get_public_system($folderId = null)
    {
        $DB = new Database();
        $query = "SELECT * FROM system WHERE visibility = 0"; // 0 for public

        if ($folderId) {
            $query .= " AND folderid = '$folderId'";
        }
    
        // Execute the query and return the results
        $result = $DB->read($query);
        return $result;
        } 
    



    public function get_folder($userid) {
        $DB = new Database();
        $conn = $DB->connect();
    
        if ($userid === null) {
            // Handle the case where $userid is null
            return false;
        }
    
        $userid = mysqli_real_escape_string($conn, $userid);
    
        // Fetch systems for the given user
        $query = "SELECT * FROM folder WHERE userid = '$userid'";
        $result = $DB->read($query);
    
        if ($result) {
            return $result; // Return fetched systems
        } else {
            return false;
        }
    }

    public function get_public_folder($userid) {
        $DB = new Database();
        $conn = $DB->connect();
    
        if ($userid === null) {
            // Handle the case where $userid is null
            return false;
        }
    
        $userid = mysqli_real_escape_string($conn, $userid);
    
        // Fetch public folders (visibility = 0) for the given user
        $query = "SELECT * FROM folder WHERE userid = '$userid' AND visibility = 0";
        $result = $DB->read($query);
    
        if ($result) {
            return $result; // Return fetched folders
        } else {
            return false;
        }
    }
    


}
?>
