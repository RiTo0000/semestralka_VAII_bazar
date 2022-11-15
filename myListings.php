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
                    <a class="nav-link active" href="myListings.php">Moje inzeráty</a>
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
                <td><img class="imagePrew" src="<?php echo $storage->readImage($row["id"]);?>" ></td>

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

    <div class="model" id="model">
        <div class="model-header">
            <div class="title" id="title"></div>
            <button data-close-button class="close-button">&times;</button>
        </div>
        <div class="model-body">
            <b><div id="kategoria"></div></b>
            <!--zaciatok obrazkovej galerie-->
            <div class="container" id="imageGalery">

                <!-- velke obrazky -->
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


                <!-- tlacidla dalsi a predchadzajuci -->
                <a class="prev arrow" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next arrow" onclick="plusSlides(1)">&#10095;</a>


                <!-- male obrazky -->
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
            <div>Kontaktný email: <a id="usrEmail" href=""></a></div>
        </div>
    </div>
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