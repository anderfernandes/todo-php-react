<?php

    require "./app/Database.php";

    $database = new App\Database();

    $database->createTable('tasks', [
        ['name' => 'id',           'properties' => 'INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT'],
        ['name' => 'name',         'properties' => 'TEXT NOT NULL'],
        ['name' => 'is_completed', 'properties' => 'BOOLEAN NOT NULL'],
        ['name' => 'created_at',   'properties' => 'DATETIME NOT NULL'],
        ['name' => 'updated_at',   'properties' => 'DATETIME NOT NULL'],
    ]);


    /*$database_path = "/home/anderson/todo-php-react/database/database.sqlite";
        
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
    }*/



?>