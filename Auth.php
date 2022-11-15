<?php

class Auth
{
    public static function login($name)
    {
        $_SESSION["name"] = $name;
    }

    public static function logout()
    {
        unset( $_SESSION["name"]);
    }

    public static function isLogged()
    {
        return isset( $_SESSION["name"]);
    }

    public static function getName()
    {
        return (Auth::isLogged() ? $_SESSION["name"] : "Anonym");
    }
}
?>