<?php

require "DBStorage.php";
require "Auth.php";

$storage = new DBStorage();
session_start();

if (isset($_GET["delete"])) {
    $storage->deleteAd($_GET["delete"]);
    header("Location: /myListings.php");
    exit();
}


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

    <title>Moje inzeráty</title>
</head>
<body>

<?php include 'menu.php'?>

<h1>Vaše inzeráty</h1>

<?php

if (isset($_GET["updateAd"])) {
    $updateAd = $_GET["updateAd"];
    switch ($updateAd) {
        case "genError":
            echo "<p class='errorMsg'>Pri úprave inzerátu nastala chyba</p>";
            break;
        case "success":
            echo "<p class='successMsg'>Úprava inzerátu prebehla úspešne</p>";
            break;
    }
}
?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">Image</th>
        <th scope="col">Produkt na predaj</th>
        <th scope="col">Cena</th>
        <th scope="col"></th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $noAds = true;
    foreach ( $storage->readAllAds("userEmail", $_SESSION["name"]) as $row) {
        $noAds = false;?>
        <tr class="tableRows">
            <td><img class="imagePrew" src="<?php echo $storage->readFirstImage($row["id"]);?>" alt=""></td>
            <td class="popisInOutput"><div><b><a data-modal-target="#model" onclick="setModal('<?php echo $row["id"]?>')"><?php echo $row["title"]?></a></b></div>
            <div><?php echo $row["popis"]?></div></td>
            <td class="priceInOutput"><?php echo $row["cena"]?> €</td>
            <td class="trashInOutput"><a data-modal-target="#model2" onclick="edit('<?php echo $row["id"]?>')"><i class="fas fa-edit"></i></a></td>
            <td class="trashInOutput"><a onclick="return confirmAction('Ste si istý že chcete odstrániť tento inzerát?');" href="?delete=<?php echo $row["id"] ?>"><i class="fas fa-trash trashAd"></i></a></td>
        </tr>
    <?php }?>

    </tbody>
</table>
<?php
    if ($noAds) {
        echo '<p id="noListings">Ľutujeme, žiadne inzeráty na zobrazenie</p>';
    }
?>

<?php include 'detail.php'?>
<!--zaciatok upravy-->
<div class="model" id="model2">
    <div class="model-header">
        <div class="title" id="titleUpdate"></div>
        <button data-close-button class="close-button">&times;</button>
    </div>
    <div class="model-body">
        <div id="updateAdForm">
            <form action="myListings.inc.php" enctype="multipart/form-data" id="addListingForm" method="post">
                <div class="row mb-3 display-none">
                    <label for="idUpdate" class="col-sm-2 col-form-label">ID</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="idUpdate" name="idUpdate" required="required">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="nadpisUpdate" class="col-sm-2 col-form-label">Nadpis</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nadpisUpdate" name="nadpisUpdate" required="required">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="popisUpdate" class="col-sm-2 col-form-label">Popis produktu</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="popisUpdate" name="popisUpdate" required="required" maxlength="500"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="cenaUpdate" class="col-sm-2 col-form-label">Cena (€)</label>
                    <div class="col-sm-10">
                        <input type="number" min="0" step="0.01" class="form-control" id="cenaUpdate" name="cenaUpdate" required="required">
                    </div>
                </div>
                <button type="submit" id="btnUpdateAd" class="btn btn-primary" name="updateAd">Upraviť inzerát</button>
            </form>
        </div>
    </div>
</div>
<!--<div id="overlay"></div>-->

<script src="js/bootstrap.js"></script>
<script src="js/script.js"></script>
</body>
</html>