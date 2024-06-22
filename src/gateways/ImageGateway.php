<?php

class ImageGateway
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insertImage(array $input)
    {
        try {
            $statement = $this->db->prepare('INSERT INTO images (name, report_id) VALUES (?, ?)');
            $statement->bind_param('si', $input['name'], $input['report_id']);
            $statement->execute();

            return $this->db->insert_id;

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function updateImage($name, $id)
    {
        try {
            $statement = $this->db->prepare('UPDATE images SET name = ? WHERE id = ?');
            $statement->bind_param('si', $name, $id);
            $statement->execute();

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }
}