<?php
require_once "dbh.inc.php";

if (!$conn) {
    die("Database connection failed");
} else {
    $id = $_SESSION['ID'];
    $rows = mysqli_query($conn, "SELECT * FROM mylist WHERE user_id = $id;");

    while ($row = mysqli_fetch_assoc($rows)) {

        $CPUPrice = 0;
        $MemoryPrice = 0;
        $MotherBoardPrice = 0;
        $StoragePrice = 0;
        $GPUPrice = 0;
        $PSUPrice = 0;

        if ($row['cpu_id'] != "") {
            $cpuStatus = mysqli_num_rows(mysqli_query($conn, "SELECT item_status FROM items WHERE item_status = 'Active' AND id = {$row['cpu_id']};"));
            if ($cpuStatus == 0) {
                mysqli_query($conn, "UPDATE mylist SET cpu_id = NULL WHERE id = {$row['id']};");
            } else {
                $CPUPrice = (float)mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM items WHERE id = {$row['cpu_id']}"))["price"];
            }
        }

        if ($row['memory_id'] != "") {
            $memoryStatus = mysqli_num_rows(mysqli_query($conn, "SELECT item_status FROM items WHERE item_status = 'Active' AND id = {$row['memory_id']};"));
            if ($memoryStatus == 0) {
                mysqli_query($conn, "UPDATE mylist SET memory_id = NULL WHERE id = {$row['id']};");
            } else {
                $MemoryPrice = (float)mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM items WHERE id = {$row['memory_id']}"))["price"];
            }
        }

        if ($row['motherboard_id'] != "") {
            $moboStatus = mysqli_num_rows(mysqli_query($conn, "SELECT item_status FROM items WHERE item_status = 'Active' AND id = {$row['motherboard_id']};"));
            if ($moboStatus == 0) {
                mysqli_query($conn, "UPDATE mylist SET motherboard_id = NULL WHERE id = {$row['id']};");
            } else {
                $MotherBoardPrice = (float)mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM items WHERE id = {$row['motherboard_id']}"))["price"];
            }
        }

        if ($row['storage_id'] != "") {
            $storageStatus = mysqli_num_rows(mysqli_query($conn, "SELECT item_status FROM items WHERE item_status = 'Active' AND id = {$row['storage_id']};"));
            if ($storageStatus == 0) {
                mysqli_query($conn, "UPDATE mylist SET storage_id = NULL WHERE id = {$row['id']};");
            } else {
                $StoragePrice = (float)mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM items WHERE id = {$row['storage_id']}"))["price"];
            }
        }

        if ($row['gpu_id'] != "") {
            $gpuStatus = mysqli_num_rows(mysqli_query($conn, "SELECT item_status FROM items WHERE item_status = 'Active' AND id = {$row['gpu_id']};"));
            if ($gpuStatus == 0) {
                mysqli_query($conn, "UPDATE mylist SET gpu_id = NULL WHERE id = {$row['id']};");
            } else {
                $GPUPrice = (float)mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM items WHERE id = {$row['gpu_id']}"))["price"];
            }
        }

        if ($row['psu_id'] != "") {
            $psuStatus = mysqli_num_rows(mysqli_query($conn, "SELECT item_status FROM items WHERE item_status = 'Active' AND id = {$row['psu_id']};"));
            if ($psuStatus == 0) {
                mysqli_query($conn, "UPDATE mylist SET psu_id = NULL WHERE id = {$row['id']};");
            } else {
                $PSUPrice = (float)mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM items WHERE id = {$row['psu_id']}"))["price"];
            }
        }

        //Calculate total price
        $ListId = $row["id"];

        $totalPrice = number_format($CPUPrice + $MemoryPrice + $MotherBoardPrice + $StoragePrice + $GPUPrice + $PSUPrice, 2, ".", "");

        $addPriceQuery = "UPDATE mylist SET total_price = $totalPrice WHERE id = $ListId;";
        mysqli_query($conn, $addPriceQuery);
    }
}
