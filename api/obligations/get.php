<?php
 
require "../../db_connection.php";
require "../../data_model/obligations.php";
 
if(isset($_POST['id'])) {
    $arr = Obligation::getOne($_POST['id'], $connection);
    echo json_encode($arr);
}
?>
