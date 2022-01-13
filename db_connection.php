<?php

$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "db_domaci";

$connection = new mysqli($hostname, $username, $password, $dbname);

if($connection->connect_errno){
    echo "Connection unsuccessful... Error: ".$connection->connect_error;
}

?>
