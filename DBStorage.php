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
        $stmt = $this->conn->prepare("SELECT * FROM users where email=?");
        $stmt->bindParam(1, $email);
        $stmt->execute();

        $row = $stmt->fetch();
        if ( $row == null)
        {
            return false;
        }
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
        $stmt = $this->conn->prepare("SELECT * FROM users where email=?");
        $stmt->bindParam(1, $origEmail);
        $stmt->execute();

        $row = $stmt->fetch();
        $password = $pPassword;
        if (strcmp($pPassword, $row["password"]) != 0) {
            $salt = $row["salt"];
            $password = $this->hashPassword($salt, $pPassword);
        }

        $stmt2 = $this->conn->prepare("UPDATE users SET meno = :name, priezvisko = :surname where email = :origEmail");
        $stmt2->bindParam(':name', $name);
        $stmt2->bindParam(':surname', $surname);
        $stmt2->bindParam(':origEmail', $origEmail);
        $stmt2->execute();
    }

    public function readUserInfo($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users where email=?");
        $stmt->bindParam(1, $email);
        $stmt->execute();

        return $stmt->fetch();
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

        $stmt = $this->conn->prepare("DELETE FROM users where email =?");
        $stmt->bindParam(1, $email);
        $stmt->execute();

    }

    public function createUser($email, $password, $name, $surname, $salt) {
        $user = $this->readUserInfo($email);

        if ($user != null) {
            return false;
        }

        $stmt = $this->conn->prepare("INSERT INTO users VALUES(:email, :pswd, :name, :surname, :salt)");
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":pswd", $password);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":surname", $surname);
        $stmt->bindParam(":salt", $salt);
        $stmt->execute();

        return true;
    }

    public function createAd($email, $title, $popis, $kategoria, $cena, $pocetFoto) {
        $user = $this->readUserInfo($email);

        if ($user == null) {
            return false;
        }
        else{
            $stmt = $this->conn->prepare("INSERT INTO inzeraty VALUES(NULL , :title, :popis, :kategoria, :cena, :email, :pocetFoto)");
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":popis", $popis);
            $stmt->bindParam(":kategoria", $kategoria);
            $stmt->bindParam(":cena", $cena);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":pocetFoto", $pocetFoto);
            $stmt->execute();

            return $this->conn->lastInsertId();
        }

    }

    public function readAllAds($colName, $colValue) {
        $stmt = $this->conn->prepare("SELECT * FROM inzeraty where $colName=?");
        $stmt->bindParam(1, $colValue);
        $stmt->execute();

        return $stmt;
    }

    public function readAds($colName, $colValue, $pageNum) {
        $offset = ($pageNum - 1) * 20;
        $stmt = $this->conn->prepare("SELECT * FROM inzeraty where $colName=? limit 20 offset $offset");
        $stmt->bindParam(1, $colValue);
        $stmt->execute();

        return $stmt;
    }

    public function countAds($colName, $colValue) {

        $stmt = $this->conn->prepare("SELECT COUNT(*) as pocet FROM inzeraty where $colName=?;");
        $stmt->bindParam(1, $colValue);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function readAd($id) {
        $stmt = $this->conn->prepare("SELECT * FROM inzeraty where id=?");
        $stmt->bindParam(1, $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function deleteAd($id) {
        $this->deleteImages($id); //vymazanie obrazkov pre dany inzerat ak nejake su

        $stmt = $this->conn->prepare("DELETE FROM inzeraty where id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();

    }

    public function updateAd($id, $title, $popis, $cena) {
        $stmt = $this->conn->prepare("UPDATE inzeraty SET title = :title, popis = :popis, cena = :cena where id = :id");
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":popis", $popis);
        $stmt->bindParam(":cena", $cena);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();

    }

    public function insertImage($inzerat_ID, $path) {
        $stmt = $this->conn->prepare("INSERT INTO images VALUES(NULL, :inzeratID, :path)");
        $stmt->bindParam( ":inzeratID", $inzerat_ID);
        $stmt->bindParam(":path", $path);
        $stmt->execute();
    }

    public function readFirstImage($inzeratId) {
        $stmt = $this->conn->prepare("SELECT * FROM images where inzerat_id = ? limit 1");
        $stmt->bindParam( 1, $inzeratId);
        $stmt->execute();

        $res = $stmt->fetch();

        if ($res != null){
            return $res["imgPath"];
        }
        return null;
    }

    public function readAllImages($inzeratId) {
        $stmt = $this->conn->prepare("SELECT * FROM images where inzerat_id = ?");
        $stmt->bindParam( 1, $inzeratId);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function deleteImages($inzeratId) {
        $images = $this->readAllImages($inzeratId);

        if ($images != null) {
            foreach ($images as $img) {
                unlink($img["imgPath"]);
            }

            $stmt = $this->conn->prepare("DELETE FROM images where inzerat_id = ?");
            $stmt->bindParam( 1, $inzeratId);
            $stmt->execute();
        }

    }

    public function createComent($userFrom, $userTo, $text) {
        $stmt = $this->conn->prepare("INSERT INTO coments VALUES(NULL , :userFrom, :userTo, :text)");
        $stmt->bindParam( ":userFrom", $userFrom);
        $stmt->bindParam( ":userTo", $userTo);
        $stmt->bindParam( ":text", $text);
        $stmt->execute();
    }

    public function readAllComents($colName, $colValue) {
        $stmt = $this->conn->prepare("SELECT * FROM coments where $colName = ?");
        $stmt->bindParam( 1, $colValue);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function deleteComent($id) {
        $stmt = $this->conn->prepare("DELETE FROM coments where id = ?");
        $stmt->bindParam( 1, $id);
        $stmt->execute();

    }
}
?>