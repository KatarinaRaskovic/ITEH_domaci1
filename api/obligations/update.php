<?php
 
require "../../db_connection.php";
require "../../data_model/obligations.php";
  
if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['date']) && isset($_POST['isDone']) && isset($_POST['subject_id'])) {
    $response = Obligation::update($_POST['id'], $_POST['name'], $_POST['description'], $_POST['date'], $_POST['isDone'], $_POST['subject_id'], $connection);
    
    if($response){ echo "Update successful...";}
    else {echo "Update unsuccessful...";}
}
?>