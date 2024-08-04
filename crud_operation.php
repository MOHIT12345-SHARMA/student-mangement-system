<?php

include 'connection.php';

class crud_operation {
    // Class property to hold the database connection
    private $db;

    // Constructor to initialize the database connection
    public function __construct() {
        $dbs = new Connection();
        $this->db = $dbs->connect();
    }

    // Data Insertion Function
    public function user_Insert($uName, $fullName, $email, $password, $courseEnroll , $mobileNumber) {
        $ret = mysqli_query($this->db, "INSERT INTO user (User_Name, Name, Email, Password, Course_Enrolled , Contact_Info) VALUES ('$uName', '$fullName', '$email', '$password', '$courseEnroll' , '$mobileNumber')");
        return $ret;
    }

    public function register_user($uName, $fullName, $email, $password, $courseEnroll, $mobileNumber, $role_id) {
        $sql = "INSERT INTO user (User_Name, Name, Email, Password, Course_Enrolled, Contact_Info, Role_Id) 
                VALUES ('$uName', '$fullName', '$email', '$password', '$courseEnroll', '$mobileNumber', '$role_id')";
        $result = mysqli_query($this->db, $sql);
        return $result;
    }
    // Data read Function
    public function user_FetchData() {
        $result = mysqli_query($this->db, "SELECT * FROM user");
        return $result;
    }

    public function getRoles() {
        $sql = "SELECT role_id, role_name FROM user_role WHERE role_status = 'Active' ";
        $result = mysqli_query($this->db, $sql);
        $roles = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $roles[] = $row;
            // echo "<pre>";
            //     print_r($roles);
            // echo "</pre>";
        }
        return $roles;
    }

    public function getExistingUsers() {
        $sql = "SELECT User_Name FROM user"; 
        $result = $this->db->query($sql);
        
        $existingUsers = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $existingUsers[] = $row['User_Name'];
            }
        }
        return $existingUsers;
    }

    // Data one record read Function
    public function user_FetchOneRecord($userid) {
        $oneresult = mysqli_query($this->db, "SELECT * FROM user WHERE id=$userid");
        return $oneresult;
    }

    // Data updation Function
    public function user_Update($uName, $fullName, $email, $password, $courseEnroll , $mobileNumber , $userid) {
        $updaterecord = mysqli_query($this->db, "UPDATE user SET User_Name='$uName', Name='$fullName', Email='$email', Password='$password', Contact_Info='$mobileNumber' , Course_Enrolled='$courseEnroll' WHERE id='$userid'");
        return $updaterecord;
    }

    // Data Deletion function
    public function user_Delete($rid) {
        $deleterecord = mysqli_query($this->db, "DELETE FROM user WHERE id=$rid");
        return $deleterecord;
    }

    
}
?>
