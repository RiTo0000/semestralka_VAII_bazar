<?php
    require "DBStorage.php";

    $storage = new DBStorage();
    session_start();

    $countAds = $storage->countAds("kategoria", $_SESSION["category"], $_GET["filterTxt"], $_GET["filterMinPrice"], $_GET["filterMaxPrice"])["pocet"];
    $pages = $countAds/20;
    if ($countAds%20 != 0){
        $pages++;
    }
    $pages = intval($pages);
    echo $pages.";";
    if ($pages > 0) {
        echo '<li id="prev" class="page-item ">
                <a class="page-link" onclick="plusPages(-1)">Previous</a>
            </li>';
        for ($pageNum = 1; $pageNum <= $pages; $pageNum++) {
            echo '<li id="page'.$pageNum.'" class="page-item"><a class="page-link" onclick="goToPage('.$pageNum.')">'.$pageNum.'</a></li>';
        }
        echo '<li id="next" class="page-item">
                <a class="page-link" onclick="plusPages(1)">Next</a>
            </li>';
    }

?>
