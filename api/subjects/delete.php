<?php
 
require "../../db_connection.php";
require "../../data_model/subjects.php";
  
if(isset($_POST['id'])) {
    $response = Subject::delete($_POST['id'], $connection);
    
    if($response){ echo "Deletion successful...";}
    else {echo "Deletion unsuccessful...";}
}
?>
