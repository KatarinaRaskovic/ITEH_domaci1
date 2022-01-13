<?php
 
require "../../db_connection.php";
require "../../data_model/subjects.php";
  
if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['espb']) && isset($_POST['semester'])) {
    $response = Subject::update($_POST['id'], $_POST['name'], $_POST['espb'], $_POST['semester'], $connection);
    
    if($response){ echo "Update successful...";}
    else {echo "Update unsuccessful...";}
}
?>