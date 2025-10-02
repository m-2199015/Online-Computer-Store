<?php
session_start();
require_once "dbh.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect form data
    $ListName = htmlspecialchars($_POST["myListName"]);
    $CPU = htmlspecialchars($_POST["CPU"]);
    $Memory = htmlspecialchars($_POST["Memory"]);
    $MotherBoard = htmlspecialchars($_POST["MotherBoard"]);
    $Storage = htmlspecialchars($_POST["Storage"]);
    $GPU = htmlspecialchars($_POST["GPU"]);
    $PSU = htmlspecialchars($_POST["PSU"]);
    $list_id = htmlspecialchars($_POST["id"]);
    $id = $_SESSION['ID'];
    var_dump($_POST);

    if (!$conn) {
        die("Database connection failed");
    } else {
        echo "Database connection successful";
    }

    // Update existing record
    $updateQuery = "UPDATE mylist SET 
            list_name = '$ListName', 
            cpu_id = '$CPU', 
            memory_id = '$Memory',   
            motherboard_id = '$MotherBoard', 
            storage_id = '$Storage', 
            gpu_id = '$GPU',  
            psu_id = '$PSU'
            WHERE user_id = $id AND id = $list_id";

    if (mysqli_query($conn, $updateQuery)) {

        //calculate total price
        $itemIdArray = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM mylist WHERE id = $list_id"));

        $CPUPrice = (float)mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM items WHERE id = {$itemIdArray['cpu_id']}"))["price"];
        $MemoryPrice = (float)mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM items WHERE id = {$itemIdArray['memory_id']}"))["price"];
        $MotherBoardPrice = (float)mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM items WHERE id = {$itemIdArray['motherboard_id']}"))["price"];
        $StoragePrice = (float)mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM items WHERE id = {$itemIdArray['storage_id']}"))["price"];
        $GPUPrice = (float)mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM items WHERE id = {$itemIdArray['gpu_id']}"))["price"];
        $PSUPrice = (float)mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM items WHERE id = {$itemIdArray['psu_id']}"))["price"];

        $totalPrice = number_format($CPUPrice + $MemoryPrice + $MotherBoardPrice + $StoragePrice + $GPUPrice + $PSUPrice, 2, ".", "");

        $addPriceQuery = "UPDATE mylist SET total_price = $totalPrice WHERE id = $list_id;";

        if (mysqli_query($conn, $addPriceQuery)) {
            echo "<script>alert('List updated successfully'); window.location.href='../mylist.php';</script>";
        } else {
            echo "<script>alert('List updated unsuccessful'); window.history.go(-1);</script>";
        }
    } else {
        echo "<script>alert('List updated unsuccessful'); window.history.go(-1);</script>";
    }
} else {
    echo "<script>alert('List updated unsuccessful'); window.history.go(-1);</script>";
}
