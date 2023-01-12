<?php

require "DBStorage.php";
require "Auth.php";

$storage = new DBStorage();
session_start();

if (isset($_GET["category"])) {
    $_SESSION["category"] = $_GET["category"];
    header("Location: /searchListings.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/1c912cc3b2.js" crossorigin="anonymous"></script>

    <title>Bazár</title>
</head>
<body>

<?php include 'menu.php'?>


<div class="container">
    <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-2 g-lg-3">
        <div class="col">
            <div class="item border bg-light"><a href="?category=Auto"><i class="fas fa-car menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=Motorky"><i class="fas fa-motorcycle menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=Reality"><i class="fas fa-home menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=Deti"><i class="fas fa-baby menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=Oblecenie"><i class="fas fa-tshirt menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=Praca"><i class="fas fa-briefcase menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=Zvierata"><i class="fas fa-paw menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=Stroje"><i class="fas fa-tools menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=Sport"><i class="fas fa-running menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=Knihy"><i class="fas fa-book menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=PC"><i class="fas fa-desktop menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=Mobily"><i class="fas fa-mobile-alt menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=Foto"><i class="fas fa-camera menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=Elektro"><i class="fas fa-plug menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=Hudba"><i class="fas fa-guitar menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=Nabytok"><i class="fas fa-couch menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=Sperky"><i class="fas fa-gem menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=Zdravie"><i class="fas fa-medkit menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=Zabava"><i class="fas fa-film menuIcon"></i></a></div>
        </div>
        <div class="col">
            <div class="item border bg-light"><a href="?category=Ostatne"><i class="fas fa-balance-scale menuIcon"></i></a></div>
        </div>
    </div>
</div>

<script src="js/bootstrap.js"></script>
</body>
</html>