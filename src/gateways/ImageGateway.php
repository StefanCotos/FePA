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

    public function getImagesByReportId($reportId)
    {
        try {
            $statement = $this->db->prepare('SELECT name FROM images WHERE report_id=?');
            $statement->bind_param('i', $reportId);
            $statement->execute();
            $result = $statement->get_result();

            $data = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }

            return $data;

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function deleteImagesByReportId($reportId)
    {
        try {
            $statement = $this->db->prepare('DELETE FROM images WHERE report_id=?');
            $statement->bind_param('i', $reportId);
            $statement->execute();

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }
}