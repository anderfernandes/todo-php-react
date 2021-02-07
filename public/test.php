<?php 

    header("Content-Type: application/json");

    require "../app/Helpers.php";

    use App\Helpers;

    echo json_encode(Helpers::json());

?>