<?php

class Database
{
    private $db = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->connectDB(include('..\database\Config.php'));
    }

    /**
     * Close your connection to DB
     */
    public function __destruct()
    {
        $this->db->close();
    }

    /**
     * Connect to DB
     */
    public function connectDB($CONFIG)
    {
        try {
            $this->db = new mysqli($CONFIG["servername"], $CONFIG["username"],
                $CONFIG["password"], $CONFIG["db"]);

//            if (!$this->db->connect_error) {
//                echo "Successfully connected to DB";
//            } else {
//                echo "Not connected to DB";
//            }
        } catch (PDOException $e) {
            trigger_error("Could not connect to database: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function getConnection()
    {
        return $this->db;
    }
}
