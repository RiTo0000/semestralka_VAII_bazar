<?php
require "DBStorage.php";

$storage = new DBStorage();

if(isset($_POST["addNewAd"])) {
    $email = $_POST["email"];
    $nadpis = $_POST["nadpis"];
    $popis = $_POST["popis"];
    $kategoria = $_POST["kategoria"];
    $cena = $_POST["cena"];
    $myFile = $_FILES['image'];
    $ad = json_encode($_POST);
    $fileCount = count(array_filter($myFile["name"]));
    if ($fileCount > 5) {
        header("Location: ../addNew.php?addNewAd=tooManyImages&ad=$ad");
        exit();
    }
    else {
        $createdAd = $storage->createAd($email, $nadpis, $popis, $kategoria, $cena, $fileCount);
        if (!$createdAd) {
            header("Location: ../addNew.php?addNewAd=userDontExist");
            exit();
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

                    $check = $storage->insertImage($createdAd, $dst_db);  // executing insert query
                }
            }

            //koniec kopcenia

            header("Location: ../addNew.php?addNewAd=success");
            exit();
        }
    }
}
?>