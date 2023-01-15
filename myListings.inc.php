<?php
require "DBStorage.php";

$storage = new DBStorage();
session_start();

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
