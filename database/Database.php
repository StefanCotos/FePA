<?php

class Database
{
    private $Db;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Close your connection to DB
     */
    public function __destruct()
    {
        $this->Db->close();
    }

    /**
     * Connect to DB
     */
    public function connectDB($CONFIG)
    {
        try {
            $this->Db = new mysqli($CONFIG["servername"], $CONFIG["username"],
                $CONFIG["password"], $CONFIG["db"]);

            if (!$this->Db->connect_error) {
                echo "Successfully connected to DB";
            } else {
                echo "Not connected to DB";
            }
        } catch (PDOException $e) {
            trigger_error("Could not connect to database: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function insertUser($first_name, $last_name, $email, $password, $username)
    {
        try {
            $statement = $this->Db->prepare('INSERT INTO users (first_name, last_name, email, password, username) VALUES (?, ?, ?, ?, ?)');
            $statement->bind_param('sssss', $first_name, $last_name, $email, $password, $username);
            $statement->execute();

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function emailExists($email)
    {
        try {
            $statement = $this->Db->prepare('SELECT COUNT(*) AS exist FROM users WHERE email = ?');
            $statement->bind_param('s', $email);
            $statement->execute();
            $result = $statement->get_result();
            $row = $result->fetch_assoc();

            if($row['exist'] == 1) {
                return true;
            }
            return false;


        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }
    public function usernameExists($username)
    {
        try {
            $statement = $this->Db->prepare('SELECT COUNT(*) AS exist FROM users WHERE username = ?');
            $statement->bind_param('s', $username);
            $statement->execute();
            $result = $statement->get_result();
            $row = $result->fetch_assoc();

            if($row['exist'] == 1) {
                return true;
            }
            return false;


        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function setPassword($password, $email)
    {
        try {
            $statement = $this->Db->prepare('UPDATE users SET password = ? WHERE email = ?');
            $statement->bind_param('ss', $password, $email);
            $statement->execute();

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function getPasswordByEmail($email){
        try {
            $statement = $this->Db->prepare('SELECT password FROM users WHERE email = ?');
            $statement->bind_param('s', $email);
            $statement->execute();
            $result = $statement->get_result();
            $row = $result->fetch_assoc();

            return $row['password'];

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function getPasswordByUsername($username){
        try {
            $statement = $this->Db->prepare('SELECT password FROM users WHERE username = ?');
            $statement->bind_param('s', $username);
            $statement->execute();
            $result = $statement->get_result();
            $row = $result->fetch_assoc();

            return $row['password'];

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function getUsername($email)
    {
        try {
            $statement = $this->Db->prepare('SELECT username FROM users WHERE email = ?');
            $statement->bind_param('s', $email);
            $statement->execute();
            $result = $statement->get_result();
            $row = $result->fetch_assoc();

            return $row['username'];

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }
}
