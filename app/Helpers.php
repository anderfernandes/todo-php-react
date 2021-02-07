<?php 

namespace App;

class Helpers
{
    public static function test()
    {
        echo "It works!";
    }

    public static function json()
    {
        return [
            "name" => "Anderson",
            "age"  => 32
        ];
    }
}

?>