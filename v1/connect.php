<?php

function getConnect(){
    $dbhost = "localhost";
    $dbdata = "test1";
    $dbuser = "root";
    $dbpass = "";
    $dbport = "3306";

    $conn= new mysqli($dbhost, $dbuser, $dbpass, $dbdata, $dbport);
    if ($conn->connect_error) {
        echo 'koneksi error'.$conn->connect_error;
        // header("location:")
    }else {
        return $conn;
    }
}
?>
