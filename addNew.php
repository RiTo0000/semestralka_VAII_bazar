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

<div id="addNewForm">
    <form onsubmit="return chechk();" enctype="multipart/form-data" id="addListingForm" method="post">
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
                <input type="text" class="form-control" id="nadpis" name="nadpis" required="required">
            </div>
        </div>
        <div class="row mb-3">
            <label for="popis" class="col-sm-2 col-form-label">Popis produktu</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="popis" name="popis" required="required" maxlength="500"></textarea>
            </div>
        </div>
        <div class="row mb-3">
            <label for="cena" class="col-sm-2 col-form-label">Cena (€)</label>
            <div class="col-sm-10">
                <input type="number" min="0" step="0.01" class="form-control" id="cena" name="cena" required="required">
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <?php  if (Auth::isLogged()) { ?>
                    <input type="email" class="form-control" id="email" name="email" required="required" readonly value="<?php echo Auth::getName()?>">
                <?php  } else { ?>
                    <input type="email" class="form-control" id="email" name="email" required="required" >
                <?php  }?>
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

<?php
if(isset($_POST["addNewAd"])) {
    $myFile = $_FILES['image'];
    $fileCount = count(array_filter($myFile["name"]));
    if ($fileCount > 5) { //pise ze pridas jeden file aj ked je to prazdne
        ?>
        <script>
            showAlert("Pozor mozes nahrat max 5 obrazkov");
            notValidForm();
        </script>
    <?php
    }
    else {
    if (!$storage->createAd($_POST["email"], $_POST["nadpis"], $_POST["popis"], $_POST["kategoria"], $_POST["cena"], $fileCount)) {
    ?>
        <script>
            showAlert("Uzivatel so zadanou emailovou adresou neexistuje");
            notValidForm();
        </script>
    <?php
    } else {
    //zaciatok kopcenia

    if (isset($_FILES['image'])) {
        for ($i = 0; $i < $fileCount; $i++) {
            $var1 = rand(1111,9999);  // generate random number in $var1 variable
            $var2 = rand(1111,9999);  // generate random number in $var2 variable

            $var3 = $var1.$var2;  // concatenate $var1 and $var2 in $var3
            $var3 = md5($var3);   // convert $var3 using md5 function and generate 32 characters hex number

            $fnm = $myFile["name"][$i];    // get the image name in $fnm variable
            $dst = "./images/".$var3.$fnm;  // storing image path into the {all_images} folder with 32 characters hex number and file name
            $dst_db = "images/".$var3.$fnm; // storing image path into the database with 32 characters hex number and file name

            move_uploaded_file($myFile["tmp_name"][$i],$dst);  // move image into the {all_images} folder with 32 characters hex number and image name

            $check = $storage->insertImage($dst_db);  // executing insert query
        }
    }

    //koniec kopcenia
    ?>
        <script>
            showAlert("Pridanie inzeratu prebehlo uspesne");
        </script>
        <?php
    }
    }
}
?>

</body>
</html>