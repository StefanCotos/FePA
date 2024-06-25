<?php

class UserGateway
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insertUser(array $input)
    {
        try {
            $statement = $this->db->prepare('INSERT INTO users (first_name, last_name, email, password, username) VALUES (?, ?, ?, ?, ?)');
            $statement->bind_param('sssss', $input['first_name'], $input['last_name'], $input['email'], $input['password'], $input['username']);
            $statement->execute();

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function emailExists($email)
    {
        try {
            $statement = $this->db->prepare('SELECT COUNT(*) AS exist FROM users WHERE email = ?');
            $statement->bind_param('s', $email);
            $statement->execute();
            $result = $statement->get_result();
            $row = $result->fetch_assoc();

            if ($row['exist'] == 1) {
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
            $statement = $this->db->prepare('SELECT COUNT(*) AS exist FROM users WHERE username = ?');
            $statement->bind_param('s', $username);
            $statement->execute();
            $result = $statement->get_result();
            $row = $result->fetch_assoc();

            if ($row['exist'] == 1) {
                return true;
            }
            return false;


        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function setPassword(array $input)
    {
        try {
            $statement = $this->db->prepare('UPDATE users SET password = ? WHERE email = ?');
            $statement->bind_param('ss', $input['password'], $input['email']);
            $statement->execute();

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function getPasswordByEmail($email)
    {
        try {
            $statement = $this->db->prepare('SELECT password FROM users WHERE email = ?');
            $statement->bind_param('s', $email);
            $statement->execute();
            $result = $statement->get_result();
            $row = $result->fetch_assoc();

            return $row['password'];

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function getPasswordByUsername($username)
    {
        try {
            $statement = $this->db->prepare('SELECT password FROM users WHERE username = ?');
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
            $statement = $this->db->prepare('SELECT username FROM users WHERE email = ?');
            $statement->bind_param('s', $email);
            $statement->execute();
            $result = $statement->get_result();
            $row = $result->fetch_assoc();

            return $row['username'];

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function getAdmin($username)
    {
        try {
            $statement = $this->db->prepare('SELECT admin FROM users WHERE username = ?');
            $statement->bind_param('s', $username);
            $statement->execute();
            $result = $statement->get_result();
            $row = $result->fetch_assoc();

            return $row['admin'];

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function find($id)
    {
        try {
            $statement = $this->db->prepare('SELECT * FROM users WHERE id = ?');
            $statement->bind_param('s', $id);
            $statement->execute();
            $result = $statement->get_result();
            return $result->fetch_assoc();

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function deleteUser($id)
    {
        try {
            $statement = $this->db->prepare('DELETE FROM users WHERE id = ?');
            $statement->bind_param('s', $id);
            $statement->execute();

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function findAll()
    {
        try {
            $statement = $this->db->prepare('SELECT * FROM users WHERE admin=0 ORDER BY id');
            $statement->execute();
            $result = $statement->get_result();

            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            return $data;

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function getIdByUsername($username)
    {
        try {
            $statement = $this->db->prepare('SELECT id FROM users WHERE username = ?');
            $statement->bind_param('s', $username);
            $statement->execute();
            $result = $statement->get_result();
            $row = $result->fetch_assoc();

            return $row['id'];

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function getUsernameById($id)
    {
        try {
            $statement = $this->db->prepare('SELECT username FROM users WHERE id = ?');
            $statement->bind_param('s', $id);
            $statement->execute();
            $result = $statement->get_result();
            $row = $result->fetch_assoc();

            return $row['username'];

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function changeFirstName($firstName, $id)
    {
        try {
            $statement = $this->db->prepare('UPDATE users SET first_name = ? WHERE id = ?');
            $statement->bind_param('si', $firstName, $id);
            $statement->execute();

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function changeLastName($lastName, $id)
    {
        try {
            $statement = $this->db->prepare('UPDATE users SET last_name = ? WHERE id = ?');
            $statement->bind_param('si', $lastName, $id);
            $statement->execute();

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function changeEmail($email, $id)
    {
        try {
            $statement = $this->db->prepare('UPDATE users SET email = ? WHERE id = ?');
            $statement->bind_param('si', $email, $id);
            $statement->execute();

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function changeUsername($username, $id)
    {
        try {
            $statement = $this->db->prepare('UPDATE users SET username = ? WHERE id = ?');
            $statement->bind_param('si', $username, $id);
            $statement->execute();

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }
}