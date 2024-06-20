<?php

class ReportGateway
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insertReport(Array $input)
    {
        try {
            $statement = $this->db->prepare('INSERT INTO reports (animal_type, city, street, descriptions, additional_aspects) VALUES (?, ?, ?, ?, ?)');
            $statement->bind_param('sssss', $input['animal_type'], $input['city'], $input['street'], $input['description'], $input['additional_aspects']);
            $statement->execute();
            return true; // Am adăugat această linie pentru a indica succesul
        } catch (PDOException $e) {
            trigger_error("Error: " . $e->getMessage(), E_USER_ERROR);
            return false; // Am adăugat această linie pentru a indica eșecul
        }
    }
    
}
