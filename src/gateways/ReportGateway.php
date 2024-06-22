<?php

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
            $statement = $this->db->prepare('INSERT INTO reports (animal_type, city, street, description, additional_aspects) VALUES (?, ?, ?, ?, ?)');
            $statement->bind_param('sssss', $input['animal_type'], $input['city'], $input['street'], $input['description'], $input['additional_aspects']);
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

}
