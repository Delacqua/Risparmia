<?php
// Create connection to database and return a json 
header("Content-Type: application/json");

    include_once(dirname(__FILE__) . '/urls.php');
    //include_once "Database.php";

    $dataDB = new Database();
    $outp = $dataDB->prendeTabella("comune");


    function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}

    echo json_encode(utf8ize($outp));

?>