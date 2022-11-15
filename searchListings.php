<?php

require "DBStorage.php";
require "Auth.php";

$storage = new DBStorage();
session_start();


if (isset($_POST["coments"])) {
    $_SESSION["user"] = $_POST["userTo"];
    header("Location: /coments.php");
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

    <title><?php echo $_SESSION["category"]?> inzeraty</title>
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

<!--filter-->
<div id="filter">
    <div class="filter">
        <label class="col-sm-2 col-form-label filterLabel">Hľadaný výraz: </label>
        <input type="text" class="form-control" id="search" onkeyup="filter()">
    </div>
    <div class="filter">
        <label class="col-sm-2 col-form-label filterLabel">Cena od: </label>
        <input type="number" min="0" step="0.01" class="form-control" id="priceFrom" onkeyup="filter()">
    </div>
    <div class="filter">
        <label class="col-sm-2 col-form-label filterLabel">Cena do: </label>
        <input type="number" class="form-control" id="priceTo" onkeyup="filter()">
    </div>
</div>

<table class="table">
    <thead>
    <tr>
        <th scope="col">Image</th>
        <th scope="col">Produkt na predaj</th>
        <th scope="col">Cena</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($storage->readAllAds("kategoria", $_SESSION["category"]) as $row) {?>
        <style>
            #noListings {
                display: none;
            }
        </style>
        <tr class="tableRows">
            <td><img class="imagePrew" src="<?php echo $storage->readImage($row["id"]);?>" ></td>

            <?php include "gallery.php"; ?>

            <div><?php echo $row["popis"]?></div></td>
            <td class="priceInOutput"><?php echo $row["cena"]?> €</td>
        </tr>
    <?php }?>

    </tbody>
</table>

<b><p id="noListings">Ľutujeme, žiadne inzeráty na zobrazenie</p></b>

<div class="model" id="model">
    <div class="model-header">
        <div class="title" id="title"></div>
        <button data-close-button class="close-button">&times;</button>
    </div>
    <div class="model-body">
        <b><div id="kategoria"></div></b>
        <!--zaciatok obrazkovej galerie-->
        <div class="container" id="imageGalery">

            <!-- Full-width images with number text -->
            <div class="mySlides">
                <img class="image1" src="" style="width:100%">
            </div>

            <div class="mySlides">
                <img class="image2" src="" style="width:100%">
            </div>

            <div class="mySlides">
                <img class="image3" src="" style="width:100%">
            </div>

            <div class="mySlides">
                <img class="image4" src="" style="width:100%">
            </div>

            <div class="mySlides">
                <img class="image5" src="" style="width:100%">
            </div>


            <!-- Next and previous buttons -->
            <a class="prev arrow" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next arrow" onclick="plusSlides(1)">&#10095;</a>


            <!-- Thumbnail images -->
            <div class="row">
                <div class="column">
                    <img class="demo cursor image1" src="" style="width:100%" onclick="currentSlide(1)">
                </div>
                <div class="column">
                    <img class="demo cursor image2" src="" style="width:100%" onclick="currentSlide(2)">
                </div>
                <div class="column">
                    <img class="demo cursor image3" src="" style="width:100%" onclick="currentSlide(3)">
                </div>
                <div class="column">
                    <img class="demo cursor image4" src="" style="width:100%" onclick="currentSlide(4)">
                </div>
                <div class="column">
                    <img class="demo cursor image5" src="" style="width:100%" onclick="currentSlide(5)">
                </div>
            </div>
        </div>
        <!--koniec obrazkovej galerie-->
        <br>
        <div id="popis"></div>
        <br>
        <div id="price"></div>
        <div id="mailAndComents"><div id="contactInfo">Kontaktný email: <a id="usrEmail" href=""></a></div><form enctype="multipart/form-data" method="post"><input id="noVisible" name="userTo"><button type="submit" name="coments" id="comentsBtn" class="btn btn-primary">Recenzie používateľa</button></form></div>
    </div>
</div>
<div id="overlay"></div>

<script src="js/bootstrap.js"></script>
<script src="js/script.js"></script>
</body>
</html>