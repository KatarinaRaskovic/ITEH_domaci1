<?php
 
require "../../db_connection.php";
require "../../data_model/subjects.php";
  
if(isset($_POST['name'])) {
    $response = Subject::insert($_POST['name'], $_POST['espb'], $_POST['semester'], $connection);
    
    if($response){ echo "Insertion successful...";}
    else {echo "Insertion unsuccessful...";}
}
?>
