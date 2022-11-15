<?php
if ($row["pocetObrazkov"]== 0) {
    ?>
    <td class="popisInOutput"><div><b><a data-modal-target="#model" onclick="setModal('<?php echo $row["title"]?>', '<?php echo $row["kategoria"]?>', '<?php echo $row["popis"]?>', '<?php echo $row["userEmail"]?>', '<?php echo $row["cena"]?> €', '<?php echo $row["pocetObrazkov"]?>', '', '', '', '', '')"><?php echo $row["title"]?></a></b></div>
    <?php
}
else if ($row["pocetObrazkov"] == 1) {
    ?>
    <td class="popisInOutput"><div><b><a data-modal-target="#model" onclick="setModal('<?php echo $row["title"]?>', '<?php echo $row["kategoria"]?>', '<?php echo $row["popis"]?>', '<?php echo $row["userEmail"]?>', '<?php echo $row["cena"]?> €', '<?php echo $row["pocetObrazkov"]?>', '<?php echo $storage->readAllImages($row["id"])->fetchAll()[0]["imgPath"];?>', '', '', '', '')"><?php echo $row["title"]?></a></b></div>
    <?php
}
else if ($row["pocetObrazkov"] == 2) {
    ?>
    <td class="popisInOutput"><div><b><a data-modal-target="#model" onclick="setModal('<?php echo $row["title"]?>', '<?php echo $row["kategoria"]?>', '<?php echo $row["popis"]?>', '<?php echo $row["userEmail"]?>', '<?php echo $row["cena"]?> €', '<?php echo $row["pocetObrazkov"]?>', '<?php echo $storage->readAllImages($row["id"])->fetchAll()[0]["imgPath"];?>', '<?php echo $storage->readAllImages($row["id"])->fetchAll()[1]["imgPath"];?>', '', '', '')"><?php echo $row["title"]?></a></b></div>
    <?php
}
else if ($row["pocetObrazkov"] == 3) {
    ?>
    <td class="popisInOutput"><div><b><a data-modal-target="#model" onclick="setModal('<?php echo $row["title"]?>', '<?php echo $row["kategoria"]?>', '<?php echo $row["popis"]?>', '<?php echo $row["userEmail"]?>', '<?php echo $row["cena"]?> €', '<?php echo $row["pocetObrazkov"]?>', '<?php echo $storage->readAllImages($row["id"])->fetchAll()[0]["imgPath"];?>', '<?php echo $storage->readAllImages($row["id"])->fetchAll()[1]["imgPath"];?>', '<?php echo $storage->readAllImages($row["id"])->fetchAll()[2]["imgPath"];?>', '', '')"><?php echo $row["title"]?></a></b></div>
    <?php
}
else if ($row["pocetObrazkov"] == 4) {
    ?>
    <td class="popisInOutput"><div><b><a data-modal-target="#model" onclick="setModal('<?php echo $row["title"]?>', '<?php echo $row["kategoria"]?>', '<?php echo $row["popis"]?>', '<?php echo $row["userEmail"]?>', '<?php echo $row["cena"]?> €', '<?php echo $row["pocetObrazkov"]?>', '<?php echo $storage->readAllImages($row["id"])->fetchAll()[0]["imgPath"];?>', '<?php echo $storage->readAllImages($row["id"])->fetchAll()[1]["imgPath"];?>', '<?php echo $storage->readAllImages($row["id"])->fetchAll()[2]["imgPath"];?>', '<?php echo $storage->readAllImages($row["id"])->fetchAll()[3]["imgPath"];?>', '')"><?php echo $row["title"]?></a></b></div>
    <?php
}
else if ($row["pocetObrazkov"] == 5) {
    ?>
    <td class="popisInOutput"><div><b><a data-modal-target="#model" onclick="setModal('<?php echo $row["title"]?>', '<?php echo $row["kategoria"]?>', '<?php echo $row["popis"]?>', '<?php echo $row["userEmail"]?>', '<?php echo $row["cena"]?> €', '<?php echo $row["pocetObrazkov"]?>', '<?php echo $storage->readAllImages($row["id"])->fetchAll()[0]["imgPath"];?>', '<?php echo $storage->readAllImages($row["id"])->fetchAll()[1]["imgPath"];?>', '<?php echo $storage->readAllImages($row["id"])->fetchAll()[2]["imgPath"];?>', '<?php echo $storage->readAllImages($row["id"])->fetchAll()[3]["imgPath"];?>', '<?php echo $storage->readAllImages($row["id"])->fetchAll()[4]["imgPath"];?>')"><?php echo $row["title"]?></a></b></div>
    <?php
}
?>