<?php 
require_once "dbh.inc.php";
    if (isset($_GET['id'])){
    $id = $_GET['id'];
    
    $result = mysqli_query ($conn,"DELETE FROM aboutus WHERE about_us_id = '$id';");
    
    echo 
    "<script>alert('Delete Successfully'); window.location.href='../homeEdit.php';</script>";
}
                            
