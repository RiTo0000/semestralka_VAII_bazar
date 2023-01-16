<?php
require "DBStorage.php";

$storage = new DBStorage();
session_start();


if (isset($_GET["pageNum"])) {
    foreach ($storage->readAds("kategoria", $_SESSION["category"], $_GET["pageNum"], $_GET["filterTxt"], $_GET["filterMinPrice"], $_GET["filterMaxPrice"]) as $row) {
        echo     "<style>
            #noListings {
                display: none;
            }
        </style>
        <tr class=\"tableRows\">
            <td><img class=\"imagePrew\" src=\"  ". $storage->readFirstImage($row["id"]) ."\" ></td>
    
            <td class=\"popisInOutput\"><div><b><a data-modal-target=\"#model\" onclick=\"setModal(' ". $row["id"]." ')\"> ". $row["title"] ."</a></b></div>
    
                <div>". $row["popis"]."</div></td>
            <td class=\"priceInOutput\">". $row["cena"]." €</td>
        </tr>
    "; }
}
?>
