<?php

require "DBStorage.php";
require "AuthControler.php";
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
if(isset($_POST["login"])) {
    if ($storage->findUser($_POST["login"], $_POST["password"])) {
        Auth::login($_POST["login"]);
    }
}

if(isset($_POST["logout"])) {
    Auth::logout();
}

if (isset($_POST["updateUserInfo"])) {
    $storage->updateUserInfo($_SESSION["name"], $_POST["email"], $_POST["password"], $_POST["meno"], $_POST["priezvisko"]);
}

if (isset($_POST["deleteUser"])) {
    if (isset($_SESSION["name"])) {
        $storage->deleteUser($_SESSION["name"]);
        Auth::logout();
    }
}

?>

<?php if (!Auth::isLogged()) {?>
    <div id="loginAndRegistration" class="row row-cols-1 row-cols-sm-1 row-cols-md-2">
        <div id="loginForm" class="col">
            <form method="post" action="#">
                <div class="row mb-3">
                    <label for="login" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="login" required="required" name="login">
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
            <form method="post" action="#" class="row g-3">
                <div class="col-md-6">
                    <label for="meno" class="form-label">Meno</label>
                    <input type="text" class="form-control" id="meno" required="required" name="meno">
                </div>
                <div class="col-md-6">
                    <label for="priezvisko" class="form-label">Priezvisko</label>
                    <input type="text" class="form-control" id="priezvisko" required="required" name="priezvisko">
                </div>
                <div class="col-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required="required" placeholder="example@gmail.com">
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
<?php if (Auth::isLogged()) {?>
    <form method="post" action="#" id="updateInfoForm">
        <div class="row mb-3">
            <label for="inputName" class="col-sm-2 col-form-label">Meno</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputName" name="meno" required="required" value="<?php echo $storage->readFromTable($_SESSION["name"], "meno")?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="inputSurname" class="col-sm-2 col-form-label">Priezvisko</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputSurname" name="priezvisko" required="required" value="<?php echo $storage->readFromTable($_SESSION["name"], "priezvisko")?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail3" name="email" required="required" readonly value="<?php echo $storage->readFromTable($_SESSION["name"], "email")?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword3" name="password" required="required" value="<?php echo $storage->readFromTable($_SESSION["name"], "password")?>">
            </div>
        </div>
        <button type="submit" id="btnUpdateInfo" class="btn btn-primary" name="updateUserInfo">Aktualizovat</button>
    </form>
    <form method="post" action="/login.php">
        <button type="submit" id="btnDeleteUser" class="btn btn-primary" name="deleteUser">Odstranit uzivatela</button>
    </form>
<?php }?>

<?php
if(isset($_POST["login"])) {
    if (!$storage->findUser($_POST["login"], $_POST["password"])) {
        ?>
        <script>
            showAlert("Prihlásenie používateľa sa nepodarilo, zadali ste nesprávne prihlasovacie údaje");
        </script>
        <?php
    }
}
else if(isset($_POST["registerNewUser"])) {
    if ($_POST["password"] == $_POST["password2"]) {
        //hashovanie hesla a pridavanie salt
        try {
            $salt = bin2hex(random_bytes(10));
        } catch (Exception $e) {
        }

        $password = $storage->hashPassword($salt, $_POST["password"]);

    if (!$storage->createUser($_POST["email"], $password, $_POST["meno"], $_POST["priezvisko"], $salt)) {
        ?>
        <script>
            showAlert("Registrácia nového používateľa sa nepodarila, konto so zadaným emailom už existuje skúste sa prihlásiť");
            notValidForm();
        </script>
    <?php
    }
    else {
    ?>
        <script>
            showAlert("Registrácia nového používateľa sa podarila");
        </script>
    <?php
    }
    }
    else {
    ?>
        <script>

            showAlert("Registrácia nového používateľa sa nepodarila, vaše heslá sa nezhodujú");
            notValidForm();
        </script>
        <?php
    }
}
?>

<script src="js/bootstrap.js"></script>
</body>
</html>