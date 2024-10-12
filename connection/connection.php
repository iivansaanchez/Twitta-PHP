<?php

function connection(){
    $host = "localhost:3306";
    $user = "root";
    $pass = "Ivan14402";

    $bd = "social_network";

    $connect=mysqli_connect($host, $user, $pass);

    mysqli_select_db($connect, $bd);

    return $connect;

}

?>