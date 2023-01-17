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
    <script src="js/script.js"></script>

    <title>Prihlásenie</title>
</head>
<body>

<?php
if(isset($_POST["logout"])) {
    Auth::logout();
}

if (isset($_POST["deleteUser"])) {
    if (isset($_SESSION["name"])) {
        $storage->deleteUser($_SESSION["name"]);
        Auth::logout();
    }
}

?>

<?php include 'menu.php'?>

<?php if (!Auth::isLogged()) {?>
    <div id="loginAndRegistration" class="row row-cols-1 row-cols-sm-1 row-cols-md-2">
        <div id="loginForm" class="col">
            <form method="post" action="login.inc.php">
                <div class="row mb-3">
                    <label for="login" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="login" maxlength="319" required="required" name="login">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" required="required" name="password">
                    </div>
                </div>
                <button id="btnLogin" type="submit" class="btn btn-primary">Prihlásiť</button>
            </form>
        </div>
        <div id="registrationForm" class="col">
            <form method="post" action="login.inc.php" class="row g-3">
                <div class="col-md-6">
                    <label for="meno" class="form-label">Meno</label>
                    <?php
                    if (isset($_GET["register"]) && isset($_GET["name"])) {
                        $name = $_GET["name"];
                        echo '<input type="text" class="form-control" id="meno" required="required" maxlength="30" name="meno" value="'.$name.'">';
                    }
                    else {
                        echo '<input type="text" class="form-control" id="meno" required="required" maxlength="30" name="meno">';
                    }
                    ?>
                </div>
                <div class="col-md-6">
                    <label for="priezvisko" class="form-label">Priezvisko</label>
                    <?php
                    if (isset($_GET["register"]) && isset($_GET["surname"])) {
                        $surname = $_GET["surname"];
                        echo '<input type="text" class="form-control" id="priezvisko" required="required" maxlength="30" name="priezvisko" value="'.$surname.'">';
                    }
                    else {
                        echo '<input type="text" class="form-control" id="priezvisko" required="required" maxlength="30" name="priezvisko">';
                    }
                    ?>
                </div>
                <div class="col-12">
                    <label for="email" class="form-label">Email</label>
                    <?php
                    if (isset($_GET["register"]) && isset($_GET["email"])) {
                        $surname = $_GET["email"];
                        echo '<input type="email" class="form-control" id="email" name="email" required="required" maxlength="319" placeholder="example@gmail.com" value="'.$surname.'">';
                    }
                    else {
                        echo '<input type="email" class="form-control" id="email" name="email" required="required" maxlength="319" placeholder="example@gmail.com">';
                    }
                    ?>
                </div>
                <div class="col-12">
                    <label for="password2" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password2" name="password" required="required" placeholder="zadajte heslo">
                </div>
                <div class="col-12">
                    <label for="password3" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password3" name="password2" required="required" placeholder="zopakujte heslo">
                </div>
                <div class="col-12">
                    <button type="submit" id="btnRegister" class="btn btn-primary" name="registerNewUser">Zaregistrovať</button>
                </div>
            </form>
        </div>
    </div>
<?php } else {?>
    <form method="post" action="#">
        <input id="btnLogout" type="submit" name="logout" class="btn btn-primary" value="Odhlásiť">
    </form>
<?php  }?>
<?php if (Auth::isLogged()) {
    $logonUser = $storage->readUserInfo($_SESSION["name"]);
    ?>
    <form method="post" action="login.inc.php" id="updateInfoForm">
        <div class="row mb-3">
            <label for="inputName" class="col-sm-2 col-form-label">Meno</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputName" name="meno" maxlength="30" required="required" value="<?php echo $logonUser["meno"]?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="inputSurname" class="col-sm-2 col-form-label">Priezvisko</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputSurname" name="priezvisko" maxlength="30" required="required" value="<?php echo $logonUser["priezvisko"]?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail3" name="email" required="required" readonly value="<?php echo $logonUser["email"]?>">
            </div>
        </div>
        <button type="submit" id="btnUpdateInfo" class="btn btn-primary" name="updateUserInfo">Aktualizovať</button>
    </form>
    <form onsubmit="return confirmAction('Ste si istý že chcete odstrániť užívateľa?');" method="post" action="/login.php">
        <button type="submit" id="btnDeleteUser" class="btn btn-primary" name="deleteUser">Odstrániť užívateľa</button>
    </form>
<?php }?>

<?php

if (isset($_GET["logon"])) {
    $logon = $_GET["logon"];
    if ($logon == "incorrectLogin") {
        echo "<p class='errorMsg'>Prihlásenie používateľa sa nepodarilo, zadali ste nesprávne prihlasovacie údaje</p>";
        exit();
    }
}
elseif (isset($_GET["updateUser"])) {
    $updateUser = $_GET["updateUser"];
    switch ($updateUser) {
        case "genError":
            echo "<p class='errorMsg'>Pri úprave používateľského konta nastala chyba</p>";
            exit();
        case "nameTooLong":
            echo "<p class='errorMsg'>Meno je príliš dlhé</p>";
            exit();
        case "surnameTooLong":
            echo "<p class='errorMsg'>Priezvisko je príliš dlhé</p>";
            exit();
        case "success":
            echo "<p class='successMsg'>Úprava používateľského konta prebehla úspešne</p>";
            exit();
    }
}
elseif (isset($_GET["register"])) {
    $register = $_GET["register"];
    switch ($register) {
        case "passwordsUnequal":
            echo "<p class='errorMsg'>Zadané heslá sa nezhodujú</p>";
            exit();
        case "nameTooLong":
            echo "<p class='errorMsg'>Meno je príliš dlhé</p>";
            exit();
        case "surnameTooLong":
            echo "<p class='errorMsg'>Priezvisko je príliš dlhé</p>";
            exit();
        case "invalidEmail":
            echo "<p class='errorMsg'>Zadaná e-mailová adresa nie je platná</p>";
            exit();
        case "userAlreadyExists":
            echo "<p class='errorMsg'>Používateľ so zadanou e-mailovou adresou už existuje</p>";
            exit();
        case "success":
            echo "<p class='successMsg'>Registrácia užívateľa prebehla úspešne</p>";
            exit();
    }
}
?>

<script src="js/bootstrap.js"></script>
</body>
</html>