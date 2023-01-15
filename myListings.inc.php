<?php
require "DBStorage.php";

$storage = new DBStorage();
session_start();

if(isset($_POST["updateAd"])) {
    if (!$storage->updateAd($_POST["idUpdate"], $_POST["nadpisUpdate"], $_POST["popisUpdate"], $_POST["cenaUpdate"])) {
        header("Location: ../myListings.php?updateAd=genError");
        exit();
    } else {
        header("Location: ../myListings.php?updateAd=success");
        exit();
    }
}
?>
