<?php
require "DBStorage.php";
require "AuthControler.php";
require "Auth.php";

$storage = new DBStorage();
session_start();

if(isset($_POST["login"])) {
    if (!$storage->findUser($_POST["login"], $_POST["password"])) {
        header("Location: ../login.php?logon=incorrectLogin");
        exit();
    }
    else {
        Auth::login($_POST["login"]);
        header("Location: ../login.php");
        exit();
    }
}
elseif(isset($_POST["registerNewUser"])) {
    if ($_POST["password"] == $_POST["password2"]) {
        //hashovanie hesla a pridavanie salt
        try {
            $salt = bin2hex(random_bytes(10));
        } catch (Exception $e) {
        }

        $password = $storage->hashPassword($salt, $_POST["password"]);

        if (!$storage->createUser($_POST["email"], $password, $_POST["meno"], $_POST["priezvisko"], $salt)) {
            header("Location: ../login.php?register=userAlreadyExists");
            exit();
        }
        else {
            header("Location: ../login.php?register=success");
            exit();
        }
    }
    else {
        header("Location: ../login.php?register=passwordsUnequal");
        exit();
    }
}
elseif (isset($_POST["updateUserInfo"])) {
    if (!$storage->updateUserInfo($_SESSION["name"], $_POST["password"], $_POST["meno"], $_POST["priezvisko"])) {
        header("Location: ../login.php?updateUser=genError");
        exit();
    }
    else {
        header("Location: ../login.php?updateUser=success");
        exit();
    }
}
?>
