<?php

    $database_path = "/home/anderson/todo-php-react/database/database.sqlite";
        
    $database = new PDO("sqlite:{$database_path}");

    try {
        $database->exec("
            CREATE TABLE tasks (
                id           INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                name         TEXT    NOT NULL, 
                is_completed BOOLEAN NOT NULL
            );
        ");

        print("Tasks table created succesfully!");
    }
    catch (PDOException $e) {
        print("Error creating database: {$e->getMessage()}");
    }

?>