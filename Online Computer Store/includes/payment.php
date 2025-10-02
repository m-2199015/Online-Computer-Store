<?php
session_start();
include "dbh.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $selected_items = $_POST['item_id'];
    $method = $_POST['payment'];
    $id = $_POST['user'];
    var_dump($_POST);
   

    
}
?>