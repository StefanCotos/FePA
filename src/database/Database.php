<?php

namespace database;

require_once __DIR__.'/../../vendor/autoload.php';

use mysqli;
use PDOException;
use Dotenv\Dotenv;

class Database
{
    private $db = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        if (isset($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE'], $_ENV['DB_PORT'])) {
            // Utilizează variabilele de mediu pentru conexiunea la baza de date
            $host = $_ENV['DB_HOST'];
            $username = $_ENV['DB_USERNAME'];
            $password = $_ENV['DB_PASSWORD'];
            $database = $_ENV['DB_DATABASE'];
            $port = $_ENV['DB_PORT'];
        } else {
            // Poți trata aici cazul în care variabilele nu sunt setate corect
            die('Variabilele de mediu nu sunt setate corect pentru conexiunea la baza de date.');
        }

        // Afișează variabilele pentru debug (opțional)
        echo "Host: $host, Username: $username, Database: $database, Port: $port<br>";

//        $dotenv = Dotenv::createImmutable(__DIR__ .'/../..');
//        $dotenv->load();

        /*echo 'DB_HOST: ' . $_ENV['DB_HOST'] . '<br>';
        echo 'DB_USERNAME: ' . $_ENV['DB_USERNAME'] . '<br>';
        echo 'DB_PASSWORD: ' . $_ENV['DB_PASSWORD'] . '<br>';
        echo 'DB_DATABASE: ' . $_ENV['DB_DATABASE'] . '<br>';
        echo 'DB_PORT: ' . $_ENV['DB_PORT'] . '<br>';*/

        $this->connectDB();
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
    public function connectDB()
    {
        try {
            $this->db = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE'], $_ENV['DB_PORT']);

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
