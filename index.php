<?php
    $db = new Db();

    $rows = $db -> select("SELECT 'population' FROM 'city'");

    if ($rows == false) {
        echo 'Didnt work check back later';
    }

    while($result = oci_fetch_array($rows)) {
        echo $result[0]." ".$result[1];
    }