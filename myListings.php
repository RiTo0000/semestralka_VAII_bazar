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


if(isset($_POST["updateAd"])) {
    if (!$storage->updateAd($_POST["idUpdate"], $_POST["nadpisUpdate"], $_POST["popisUpdate"], $_POST["cenaUpdate"])) {
        ?>
        <script>
            showAlert("Pri uprave sa nieco pokazilo");
            notValidForm();
        </script>
        <?php
    } else {
        ?>
        <script>
            showAlert("Upravenie inzeratu prebehlo uspesne");
        </script>
        <?php
    }
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


<?php if (!Auth::isLogged()) {?>
    <div id="noListings">
        <h1><i class="fas fa-exclamation-circle"></i> Pozor nie ste prihláseny</h1>
        <p>Pre zobrazenie vašich inzerátov sa najprv prosím prihláste</p>
    </div>

<?php } else {?>
    <h1>Vaše inzeráty</h1>

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
        <?php foreach ($storage->readAllAds("userEmail", $_SESSION["name"]) as $row) {?>
            <style>
                #noListings {
                    display: none;
                }
            </style>
            <tr class="tableRows">
                <td><img class="imagePrew" src="<?php echo $storage->readFirstImage($row["id"]);?>" ></td>

                <?php include 'gallery.php'?>

                <div><?php echo $row["popis"]?></div></td>
                <td class="priceInOutput"><?php echo $row["cena"]?> €</td>
                <td class="trashInOutput"><a data-modal-target="#model2" onclick="edit('<?php echo $row["id"]?>', '<?php echo $row["title"]?>', '<?php echo $row["popis"]?>', '<?php echo $row["cena"]?>')"><i class="fas fa-edit"></i></a></td>
                <td class="trashInOutput"><a href="?delete=<?php echo $row["id"] ?>"><i class="fas fa-trash trashAd"></i></a></td>
            </tr>
        <?php }?>

        </tbody>
    </table>

    <b><p id="noListings">Ľutujeme, žiadne inzeráty na zobrazenie</p></b>

    <?php include 'detail.php'?>
    <!--zaciatok upravy-->
    <div class="model" id="model2">
        <div class="model-header">
            <div class="title" id="titleUpdate"></div>
            <button data-close-button class="close-button">&times;</button>
        </div>
        <div class="model-body">
            <div id="updateAdForm">
                <form onsubmit="return chechk();" enctype="multipart/form-data" id="addListingForm" method="post">
                    <div class="row mb-3 display-none">
                        <label for="idUpdate" class="col-sm-2 col-form-label">ID</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="idUpdate" name="idUpdate" required="required">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nadpis" class="col-sm-2 col-form-label">Nadpis</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nadpisUpdate" name="nadpisUpdate" required="required">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="popis" class="col-sm-2 col-form-label">Popis produktu</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="popisUpdate" name="popisUpdate" required="required" maxlength="500"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="cena" class="col-sm-2 col-form-label">Cena (€)</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" step="0.01" class="form-control" id="cenaUpdate" name="cenaUpdate" required="required">
                        </div>
                    </div>
                    <button type="submit" id="btnUpdateAd" class="btn btn-primary" name="updateAd">Upraviť inzerát</button>
                </form>
            </div>
        </div>
    </div>
    <div id="overlay"></div>
<?php }?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js%22%3E"></script>
<script src="js/bootstrap.js"></script>
<script src="js/script.js"></script>
</body>
</html>