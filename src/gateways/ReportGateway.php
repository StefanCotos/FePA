<?php

use rss_generator\RSSGenerator;

class ReportGateway
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insertReport(array $input)
    {
        try {
            $statement = $this->db->prepare('INSERT INTO reports (animal_type, city, street, description, additional_aspects, user_id) VALUES (?, ?, ?, ?, ?, ?)');
            $statement->bind_param('sssssi', $input['animal_type'], $input['city'], $input['street'], $input['description'], $input['additional_aspects'], $input['user_id']);
            $statement->execute();

            return $this->db->insert_id;

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function getApprovedReports()
    {
        try {
            $statement = $this->db->prepare('SELECT * FROM reports where is_approve=1');
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

    public function getNotApprovedReports()
    {
        try {
            $statement = $this->db->prepare('SELECT * FROM reports where is_approve=0');
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

    public function getAreaStatistics()
    {
        try {
            $statement = $this->db->prepare('SELECT city, COUNT(*) AS lines_number FROM reports where is_approve=1 GROUP BY city');
            $statement->execute();
            $result = $statement->get_result();

            $data = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = [$row['city'], (int)$row['lines_number']];
                }
            }

            return $data;

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function getTypeStatistics()
    {
        try {
            $statement = $this->db->prepare('SELECT animal_type, COUNT(*) AS lines_number FROM reports where is_approve=1 GROUP BY animal_type');
            $statement->execute();
            $result = $statement->get_result();

            $data = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = [$row['animal_type'], (int)$row['lines_number']];
                }
            }

            return $data;

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function getReportById($id)
    {
        try {
            $statement = $this->db->prepare('SELECT * FROM reports WHERE is_approve=1 AND id=?');
            $statement->bind_param('i', $id);
            $statement->execute();
            $result = $statement->get_result();
            return $result->fetch_assoc();

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function getReportsForRSS()
    {
        try {
            $statement = $this->db->prepare('SELECT id, animal_type, city, street, description, additional_aspects, pub_date FROM reports where is_approve=1');
            $statement->execute();
            $result = $statement->get_result();

            $rss = new RSSGenerator("rss.xml");
            while ($row = $result->fetch_assoc()) {
                $rss->createItem($row['animal_type'], $row['city'] . ", " . $row['street'] . ", " . substr($row['description'], 0, 15) . "... " . "(Click to see more information and photos)", "post/" . $row['id'], $row['pub_date']);
            }
            $rss->generate();

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        } catch (Exception $e) {
        }
    }

    public function approveReport($id)
    {
        try {
            $statement = $this->db->prepare('UPDATE reports SET is_approve=1 WHERE id=?');
            $statement->bind_param('i', $id);
            $statement->execute();

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function deleteReport($id)
    {
        try {
            $statement = $this->db->prepare('DELETE FROM reports WHERE id=?');
            $statement->bind_param('i', $id);
            $statement->execute();

        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function getReportsByUserId($userId)
    {
        try {
            $statement = $this->db->prepare('SELECT * FROM reports WHERE user_id=?');
            $statement->bind_param('i', $userId);
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

}
