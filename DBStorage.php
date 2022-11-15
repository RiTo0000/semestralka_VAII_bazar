<?php

class DBStorage
{


    /**
     * @var PDO
     */
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=localhost;dbname=db_bazar", "root", "dtb456");
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function findUser($email, $pPassword) {
        $sql = "SELECT * FROM users where email = '".$email."'";

        $res = $this->conn->query($sql);
        $res->fetchAll();
        $res->execute();


        $rows = $res->fetchAll();
        if ( $rows == null)
        {
            return false;
        }
        $row = $rows[0];
        $salt = $row["salt"];
        $password = $this->hashPassword($salt, $pPassword);
        if (strcmp($password, $row["password"]) == 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function hashPassword($salt, $password): string
    {
        $unhashed = $salt.$password;  // osoli heslo
        return md5($unhashed);   // konvertuje cez md5
    }

    public function updateUserInfo($origEmail, $email, $pPassword, $name, $surname) {
        $sql = "SELECT * FROM users where email = '".$origEmail."'";

        $res = $this->conn->query($sql);
        $res->fetchAll();
        $res->execute();

        $row = $res->fetchAll()[0];
        $password = $pPassword;
        if (strcmp($pPassword, $row["password"]) != 0) {
            $salt = $row["salt"];
            $password = $this->hashPassword($salt, $pPassword);
        }


        $sql = "UPDATE users SET email = '".$email."', password = '".$password."', meno = '".$name."', priezvisko = '".$surname."' where email = '".$origEmail."'";

        $res = $this->conn->prepare($sql);
        $res->execute();
        $_SESSION["name"] = $email;

        $sql = "UPDATE inzeraty SET userEmail = '".$email."' where userEmail = '".$origEmail."'";
        $res = $this->conn->prepare($sql);
        $res->execute();
    }

    public function readFromTable($email, $columName) {
        $sql = "SELECT * FROM users where email = '".$email."'";

        $res = $this->conn->query($sql);
        $res->fetchAll();
        $res->execute();

        foreach ($res as $user) {
            return $user[$columName];
        }

    }

    public function deleteUser($email) {
        foreach ($this->readAllAds("userEmail", $email) as $row) {
            $this->deleteAd($row["id"]);
        }

        foreach ($this->readAllComents("userTo", $email) as $row) {
            $this->deleteComent($row["id"]);
        }

        foreach ($this->readAllComents("userFrom", $email) as $row) {
            $this->deleteComent($row["id"]);
        }
        $sql = "DELETE FROM users where email = '".$email."'";
        $res = $this->conn->prepare($sql);
        $res->execute();
    }

    public function createUser($email, $password, $name, $surname, $salt) {
        $sql = "SELECT * FROM users where email = '".$email."'";

        $res = $this->conn->query($sql);
        $res->fetchAll();
        $res->execute();

        foreach($res as $row) {
            return false;
        }

        $sql = "INSERT INTO users VALUES('".$email."', '".$password."', '".$name."', '".$surname."', '".$salt."')";

        $res = $this->conn->prepare($sql);
        $res->execute();
        return true;
    }

    public function createAd($email, $title, $popis, $kategoria, $cena, $pocetFoto) {
        $sql = "SELECT * FROM users where email = '".$email."'";

        $res = $this->conn->query($sql);
        $res->fetchAll();
        $res->execute();
        $count = 0;
        foreach($res as $row) {
            $count = 1;
        }

        if ($count == 1) {
            $sql = "INSERT INTO inzeraty VALUES(NULL , '".$title. "', '" . $popis. "', '" . $kategoria. "', '" . $cena. "', '" . $email. "', '" . $pocetFoto. "')";
            $res = $this->conn->prepare($sql);
            $res->execute();
            return true;
        }
        else {
            return false;
        }
    }

    public function readAllAds($colName, $colValue) {
        $sql = "SELECT * FROM inzeraty where $colName = '".$colValue."'";
        $res = $this->conn->query($sql);
        $res->fetchAll();
        $res->execute();

        return $res;
    }

    public function deleteAd($id) {
        $sql = "SELECT * FROM inzeraty where id = '".$id."'";

        $res = $this->conn->prepare($sql);
        $res->execute();

        foreach ($res as $img) {
            $this->deleteImages($img["id"]);
        }

        $sql = "DELETE FROM inzeraty where id = '".$id."'";

        $res = $this->conn->prepare($sql);
        $res->execute();

    }

    public function updateAd($id, $title, $popis, $cena) {
        $sql = "UPDATE inzeraty SET title = '".$title."', popis = '".$popis."', cena = '".$cena."' where id = '".$id."'";

        $res = $this->conn->prepare($sql);
        $res->execute();

    }

    public function insertImage($path) {
        $sql = "INSERT INTO images VALUES(NULL, (SELECT MAX(id) FROM inzeraty),'".$path."')";

        $res = $this->conn->prepare($sql);
        $res->execute();
    }

    public function readImage($inzeratId) {
        $sql = "SELECT * FROM images where inzerat_id = '".$inzeratId."'";

        $res = $this->conn->query($sql);
        $res->fetchAll();
        $res->execute();

        foreach ($res as $img) {
            return $img["imgPath"];
        }
    }

    public function readAllImages($inzeratId) {
        $sql = "SELECT * FROM images where inzerat_id = '".$inzeratId."'";

        $res = $this->conn->query($sql);
        $res->fetchAll();
        $res->execute();

        return $res;
    }

    public function deleteImages($inzeratId) {
        $sql = "SELECT * FROM images where inzerat_id = '".$inzeratId."'";

        $res = $this->conn->prepare($sql);
        $res->execute();

        foreach ($res as $img) {
            unlink($img["imgPath"]);
        }

        $sql = "DELETE FROM images where inzerat_id = '".$inzeratId."'";

        $res = $this->conn->prepare($sql);
        $res->execute();

    }

    public function createComent($userFrom, $userTo, $text) {
        $sql = "INSERT INTO coments VALUES(NULL , '".$userFrom. "', '" . $userTo. "', '" . $text. "')";
        $res = $this->conn->prepare($sql);
        $res->execute();
    }

    public function readAllComents($colName, $colValue) {
        $sql = "SELECT * FROM coments where $colName = '".$colValue."'";
        $res = $this->conn->query($sql);
        $res->fetchAll();
        $res->execute();

        return $res;
    }

    public function deleteComent($id) {
        $sql = "DELETE FROM coments where id = '".$id."'";

        $res = $this->conn->prepare($sql);
        $res->execute();

    }
}
?>