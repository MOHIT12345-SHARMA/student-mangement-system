<?php
class Connection {
    // Define class constants
    const HOST_NAME = 'localhost';
    const USER_NAME = 'root';
    const DATABASE_PASSWORD = 'admin@123';
    const DATABASE_NAME = 'Collection';

    // Class property to hold the database connection
    private $db;

    // Constructor to establish the database connection
    public function __construct() {
        $this->db = new mysqli(self::HOST_NAME, self::USER_NAME, self::DATABASE_PASSWORD, self::DATABASE_NAME);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    // Function to return the database connection
    public function connect() {
        return $this->db;
    }
}
?>
