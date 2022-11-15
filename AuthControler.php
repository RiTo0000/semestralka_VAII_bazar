<?php

class AuthControler
{

    public function login()
    {
        $name = $this->request()->getValue("login");
        if ($name) {
            Auth::login($name);
        }
        else {
            echo "nepodarilo sa prihlasit";
        }
    }

    public function logout()
    {
        Auth::logout();
    }
}