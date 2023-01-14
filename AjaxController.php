<?php
require "DBStorage.php";

    $storage = new DBStorage();

    switch ($_GET["action"]) {
        case "readAd":
            $ad = $storage->readAd($_GET["id"]);
            echo json_encode($ad) ;
            break;
        case "readAllImages":
            $images = $storage->readAllImages($_GET["id"]);
            echo json_encode($images) ;
            break;
    }


?>
