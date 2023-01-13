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

<?php include 'menu.php'?>

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
            <td><img class="imagePrew" src="<?php echo $storage->readFirstImage($row["id"]);?>" ></td>

            <?php include "gallery.php"; ?>

            <div><?php echo $row["popis"]?></div></td>
            <td class="priceInOutput"><?php echo $row["cena"]?> €</td>
        </tr>
    <?php }?>

    </tbody>
</table>

<b><p id="noListings">Ľutujeme, žiadne inzeráty na zobrazenie</p></b>

<?php include 'detail.php'?>

<script src="js/bootstrap.js"></script>
<script src="js/script.js"></script>
</body>
</html>