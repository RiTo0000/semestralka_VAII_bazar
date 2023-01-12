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

    <title>Recenzie užívateľa <?php echo $_SESSION["user"]?></title>
</head>
<body>

<?php include 'menu.php' ?>

<?php if (Auth::isLogged()) {?>
<div id="addComentForm">
    <form enctype="multipart/form-data" method="post">
        <div class="row mb-3">
            <label id="comentLabel" for="comentText" class="col-sm-2 col-form-label">Vaša recenzia</label>
            <div id="comentTextDiv" class="col-sm-10">
                <textarea class="form-control" id="comentText" name="comentText" required="required" maxlength="500"></textarea>
            </div>
            <button type="submit" id="btnAddComent" class="btn btn-primary" name="addComent">Pridať recenziu</button>
        </div>
    </form>
</div>
<?php }?>
<b><p>Recenzie pre užívateľa: <?php echo $_SESSION["user"]?></p></b>
<table class="table">
    <thead>
    <tr>
        <th scope="col">Od</th>
        <th scope="col">Text recenzie</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($storage->readAllComents("userTo", $_SESSION["user"]) as $row) {?>
        <style>
            #noComents {
                display: none;
            }
        </style>
        <tr class="tableRows">
            <td class="userFrom"><?php echo $row["userFrom"]?></td>
            <td class="comentText"><?php echo $row["comentText"]?></td>
            <?php if (strcmp($row["userFrom"], $_SESSION["name"]) == 0) { ?>
                <td class="trashInOutput"><a href="?delete=<?php echo $row["id"] ?>"><i class="fas fa-trash trashAd"></i></a></td>
            <?php } else {?>
                <td></td>
            <?php }?>
        </tr>
    <?php }?>

    </tbody>
</table>

<b><p id="noComents">Ľutujeme, žiadne recenzie na zobrazenie</p></b>

<?php
if(isset($_POST["addComent"])) {
    $storage->createComent($_SESSION["name"], $_SESSION["user"], $_POST["comentText"]);
    header("Refresh:0");
}
if (isset($_GET["delete"])) {
    $storage->deleteComent($_GET["delete"]);
    header("Location: /coments.php");
    exit();
}
?>


<script src="js/bootstrap.js"></script>
<script src="js/script.js"></script>
</body>
</html>