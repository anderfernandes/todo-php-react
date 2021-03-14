<?php

namespace App;

require("Environment.php");

use Exception;
use PDO;
use PDOException;

class Database
{

    private $database;

    public function __construct()
    {
        $database_path = Environment::getDbConnectionString();

        if (empty($database_path))
            throw new PDOException("Database path not configured");

        // To make this work with other database vendors,
        // we will have to change the PDO constructor
        if (!Environment::getDatabaseConnection() == "sqlite")
            throw new PDOException("Database connection not configured");

        $this->database = new PDO("sqlite:{$database_path}");

        $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Queries a table from the database
     *
     * @param string $table The name of the table
     * @return array
     */
    public function query(string $table)
    {
        try 
        {
            return $this->database->query("SELECT * FROM {$table}");
        }
        catch (Exception $e)
        {
            throw new PDOException("Table {$table} does not exist");
        }
    }

    /**
     * Undocumented function
     *
     * @param string $table The name of the table
     * @param array $data The data to be inserted
     * @return void
     */
    public function create(string $table, array $data)
    {
        $query = $this->database->prepare('
            INSERT INTO ' . $table . ' values (
                :id,
                :name, 
                :is_completed
            )
        ');

        $data['is_completed'] = array_key_exists('is_completed', $data);

        $query->execute([
            ':name'         => $data['name'],
            ':is_completed' => $data['is_completed'],
        ]);
    }

    /**
     * Deletes data from a table
     *
     * @param string $table The table to delete the data from
     * @param int $id The id of the item in the table
     * @return void
     */
    public function delete(string $table, int $id)
    {
        $query = $this->database->prepare('
            DELETE FROM ' . $table . ' WHERE id = :id
        ');
        
        $query->execute([
            ':id' => $id
        ]);
    }
}

?>