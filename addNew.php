<?php


require "DBStorage.php";
require "Auth.php";

$storage = new DBStorage();
session_start();

?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/1c912cc3b2.js" crossorigin="anonymous"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/script.js"></script>

    <title>Nový inzerát</title>
</head>
<body>

<?php include 'menu.php'?>

<?php if (!Auth::isLogged()) {?>
    <div id="notLoggedIn">
        <h1><i class="fas fa-exclamation-circle"></i> Pozor nie ste prihlásený</h1>
        <p>Pre pridanie nového inzerátu sa najprv prosím prihláste</p>
    </div>

<?php } else {?>

    <div id="addNewForm">
        <form onsubmit="return chechk();" action="addNew.inc.php" enctype="multipart/form-data" id="addListingForm" method="post">
            <div class="row mb-3">
                <label for="kategoria" class="col-sm-2 col-form-label">Kategória</label>
                <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example" id="kategoria" name="kategoria" >
                        <option value="Auto">Auto</option>
                        <option value="Motorky">Motorky</option>
                        <option value="Reality">Reality</option>
                        <option value="Deti">Deti</option>
                        <option value="Oblecenie">Oblecenie</option>
                        <option value="Praca">Praca</option>
                        <option value="Zvierata">Zvierata</option>
                        <option value="Stroje">Stroje</option>
                        <option value="Sport">Sport</option>
                        <option value="Knihy">Knihy</option>
                        <option value="PC">PC</option>
                        <option value="Mobily">Mobily</option>
                        <option value="Foto">Foto</option>
                        <option value="Elektro">Elektro</option>
                        <option value="Hudba">Hudba</option>
                        <option value="Nabytok">Nabytok</option>
                        <option value="Sperky">Sperky</option>
                        <option value="Zdravie">Zdravie</option>
                        <option value="Zabava">Zabava</option>
                        <option value="Ostatne">Ostatne</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="nadpis" class="col-sm-2 col-form-label">Nadpis</label>
                <div class="col-sm-10">
                    <?php
                        if (isset($_GET["ad"])) {
                            $ad = json_decode($_GET["ad"], true);
                            echo '<input type="text" class="form-control" id="nadpis" name="nadpis" required="required" value="'.$ad["nadpis"].'">';
                        }
                        else {
                            echo '<input type="text" class="form-control" id="nadpis" name="nadpis" required="required">';
                        }
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <label for="popis" class="col-sm-2 col-form-label">Popis produktu</label>
                <div class="col-sm-10">
                    <?php
                    if (isset($_GET["ad"])) {
//                        $ad = json_decode($_GET["ad"], true);
                        echo '<textarea class="form-control" id="popis" name="popis" required="required" maxlength="500">'.$ad["popis"].'</textarea>';
                    }
                    else {
                        echo '<textarea class="form-control" id="popis" name="popis" required="required" maxlength="500"></textarea>';
                    }
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <label for="cena" class="col-sm-2 col-form-label">Cena (€)</label>
                <div class="col-sm-10">
                    <?php
                    if (isset($_GET["ad"])) {
//                        $ad = json_decode($_GET["ad"], true);
                        echo '<input type="number" min="0" step="0.01" class="form-control" id="cena" name="cena" required="required" value="'.$ad["cena"].'">';
                    }
                    else {
                        echo '<input type="number" min="0" step="0.01" class="form-control" id="cena" name="cena" required="required">';
                    }
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" required="required" readonly value="<?php echo Auth::getName()?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="image" class="col-sm-2 col-form-label">Nahraj fotky (max. 5ks)</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" id="image" name="image[]" value="" multiple accept="image/*">
                </div>
            </div>
            <button type="submit" id="btnAddNewAd" class="btn btn-primary" name="addNewAd">Pridať inzerát</button>
        </form>
    </div>
<?php }?>

<?php

    if (isset($_GET["addNewAd"])) {
        $addNewCheck = $_GET["addNewAd"];
        switch ($addNewCheck) {
            case "tooManyImages":
                echo "<p class='errorMsg'>Pozor môžeš nahrať maximálne 5 obrázkov</p>";
                exit();
            case "userDontExist":
                echo "<p class='errorMsg'>Užívateľ so zadanou emailovou adresou neexistuje</p>";
                exit();
            case "success":
                echo "<p class='successMsg'>Pridanie inzerátu prebehlo úspešne</p>";
                exit();
        }
    }
?>

</body>
</html>