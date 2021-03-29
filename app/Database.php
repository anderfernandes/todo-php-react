<?php

namespace App;

require "Environment.php";

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
     * Gets a row from the database
     *
     * @param string $table
     * @param integer $id
     * @return void
     */
    public function show(string $table, int $id)
    {
        $query = $this->database->query("SELECT * FROM {$table} WHERE id = {$id}");
        
        return $query->fetch((PDO::FETCH_ASSOC));
    }

    /**
     * Creates a new record into $table with $data
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
     * Updates $table with $data
     *
     * @param string $table
     * @param array $data
     * @return void
     */
    public function update(string $table, array $data)
    {
        // Find data in database
        $this->query($table);

        $query = $this->database->prepare('
            UPDATE ' . $table . ' 
            SET  name = :name, 
                is_completed = :is_completed
            WHERE id = :id;
            ');

        $data['is_completed'] = array_key_exists('is_completed', $data);
            
        $query->execute([
            ':id' =>$data['id'],
            ':name' =>$data['name'],
            'is_completed' =>$data['is_completed']
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

    public function createTable(string $name, array $columns)
    {
        $fields = "";

        foreach ($columns as $column)
            $fields .= "{$column['name']} {$column['properties']}, ";

        $fields = rtrim($fields, ', ');

        $this->database->exec("CREATE TABLE IF NOT EXISTS {$name} ({$fields})");

        echo("Table {$name} created succesfully! ");
    }
}

?>