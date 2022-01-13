<?php
 
require "../../db_connection.php";
require "../../data_model/obligations.php";
  
if(isset($_POST['id'])) {
    $response = Obligation::delete($_POST['id'], $connection);
    
    if($response){ echo "Deletion successful...";}
    else {echo "Deletion unsuccessful...";}
}
?>
