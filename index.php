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
<nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Bazar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarNav">
            <ul class="navbar-nav ">
                <li class="nav-item">
                    <a class="nav-link" href="addNew.php">Pridať inzerát</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="myListings.php">Moje inzeráty</a>
                </li>
                <?php  if (Auth::isLogged()) { ?>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="login.php"><?php echo Auth::getName()?></a>
                    </li>
                <?php  } else {?>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="login.php">Prihlásenie</a>
                    </li>
                <?php }?>
            </ul>
        </div>
    </div>
</nav>

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