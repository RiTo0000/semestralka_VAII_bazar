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
        <input type="text" class="form-control" id="search" onkeyup="filterDB()">
    </div>
    <div class="filter">
        <label class="col-sm-2 col-form-label filterLabel">Cena od: </label>
        <input type="number" min="0" step="0.01" class="form-control" id="priceFrom" onkeyup="filterDB()">
    </div>
    <div class="filter">
        <label class="col-sm-2 col-form-label filterLabel">Cena do: </label>
        <input type="number" class="form-control" id="priceTo" onkeyup="filterDB()">
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
    <tbody id="listings">
<!--    tu sa nacitavaju listingy javascriptom-->
    </tbody>
</table>

<b><p id="noListings">Ľutujeme, žiadne inzeráty na zobrazenie</p></b>

<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-end">
        <li id="prev" class="page-item ">
            <a class="page-link" onclick="plusPages(-1)">Previous</a>
        </li>
        <?php
            $countAds = $storage->countAds("kategoria", $_SESSION["category"])["pocet"];
            $pages = $countAds/20;
            if ($countAds%20 != 0){
                $pages++;
            }
            for ($pageNum = 1; $pageNum <= $pages; $pageNum++) {?>
                <li id="page<?php echo $pageNum?>" class="page-item"><a class="page-link" onclick="goToPage(<?php echo $pageNum?>)"><?php echo $pageNum?></a></li>
        <?php }?>
        <li id="next" class="page-item">
            <a class="page-link" onclick="plusPages(1)">Next</a>
        </li>
    </ul>
</nav>

<?php include 'detail.php'?>

<script src="js/bootstrap.js"></script>
<script src="js/script.js"></script>
<script>
    initPages(<?php echo intval($pages)?>);
    goToPage(1);
</script>
</body>
</html>