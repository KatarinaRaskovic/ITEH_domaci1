<?php
 
require __DIR__."/../../db_connection.php";
require __DIR__."/../../data_model/obligations.php";

if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['date']) && isset($_POST['isDone']) && isset($_POST['subject_id'])) {
    $response = Obligation::insert($_POST['name'], $_POST['description'], $_POST['date'], $_POST['isDone'], $_POST['subject_id'], $connection);
    
    if($response){ echo "Insertion successful...";}
    else {echo "Insertion unsuccessful...";}
}
?>
