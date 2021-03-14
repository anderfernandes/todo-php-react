<?php 

namespace App;

use Exception;

class Environment 
{
    private static $rootDir = __DIR__;

    private static $database = "database.sqlite";

    private static $database_connection = "sqlite";

    /**
     * Returns the database connection string
     *
     * @return void
     */
    public static function getDbConnectionString()
    {
        return self::getDatabaseDir() . self::$database;
    }

    /**
     * Returns the root directory of the app
     *
     * @return string
     */
    private static function getRootDir()
    {
        $array_path = explode(DIRECTORY_SEPARATOR, self::$rootDir);

        $i = array_key_last($array_path);

        array_pop($array_path);

        $path = implode(DIRECTORY_SEPARATOR, $array_path);

        return $path;
    }

    /**
     * Returns the directory containing the database
     *
     * @return void
     */
    private static function getDatabaseDir()
    {
        return self::getRootDir() . '/database/';
    }

    /**
     * Return the type of database
     *
     * @return void
     */
    public static function getDatabaseConnection()
    {
        return self::$database_connection;
    }

}

?>