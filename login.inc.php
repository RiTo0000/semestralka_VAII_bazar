<?php
require "DBStorage.php";
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
    $name = $_POST["meno"];
    $surname = $_POST["priezvisko"];
    $email = $_POST["email"];

    if (strlen($name) > 30){
        header("Location: ../login.php?register=nameTooLong&email=$email&surname=$surname");
        exit();
    }
    elseif (strlen($surname) > 30){
        header("Location: ../login.php?register=surnameTooLong&email=$email&name=$name");
        exit();
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) or strlen($email) > 319){
        header("Location: ../login.php?register=invalidEmail&name=$name&surname=$surname");
        exit();
    }
    else if ($_POST["password"] == $_POST["password2"]) {
        //hashovanie hesla a pridavanie salt
        try {
            $salt = bin2hex(random_bytes(10));
        } catch (Exception $e) {
        }

        $password = $storage->hashPassword($salt, $_POST["password"]);

        if (!$storage->createUser($email, $password, $name, $surname, $salt)) {
            header("Location: ../login.php?register=userAlreadyExists");
            exit();
        }
        else {
            header("Location: ../login.php?register=success");
            exit();
        }
    }
    else {
        header("Location: ../login.php?register=passwordsUnequal&email=$email&name=$name&surname=$surname");
        exit();
    }
}
elseif (isset($_POST["updateUserInfo"])) {
    $name = $_POST["meno"];
    $surname = $_POST["priezvisko"];

    if (strlen($name) > 30){
        header("Location: ../login.php?updateUser=nameTooLong&surname=$surname");
        exit();
    }
    elseif (strlen($surname) > 30){
        header("Location: ../login.php?updateUser=surnameTooLong&name=$name");
        exit();
    }
    elseif (!$storage->updateUserInfo($_POST["email"], $_POST["meno"], $_POST["priezvisko"])) {
        header("Location: ../login.php?updateUser=genError");
        exit();
    }
    else {
        header("Location: ../login.php?updateUser=success");
        exit();
    }
}
?>
