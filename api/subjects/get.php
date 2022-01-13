<?php
 
require "../../db_connection.php";
require "../../data_model/subjects.php";
 
if(isset($_POST['id'])) {
    $arr = Subject::getOne($_POST['id'], $connection);
    echo json_encode($arr);
}
?>
