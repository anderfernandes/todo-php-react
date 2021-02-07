<?php

    $database_path = "/home/anderson/todo-php-react/database/database.sqlite";
        
    $database = new PDO("sqlite:{$database_path}");

    try {
        $database->exec("
            CREATE TABLE tasks (
                name text, 
                is_completed boolean
            );
        ");

        print("Tasks table created succesfully!");
    }
    catch (PDOException $e) {
        print("Error creating database: {$e->getMessage()}");
    }

?>