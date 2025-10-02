<?php
require_once "dbh.inc.php";

if (!$conn) {
    die("Database connection failed");
} else {
    //Get user id
    $userID = $_SESSION["ID"];

    //Get orders
    if (!isset($_GET["status"])) {
        //status is null
        $orderResult = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = $userID ORDER BY order_date DESC;");
    } else {
        //status is not null
        $status = $_GET["status"];
        $orderResult = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = $userID AND status_id = $status ORDER BY order_date DESC;");
    }

    //Get category name
    $statusResult = mysqli_query($conn, "SELECT * FROM orderstatus;");
}
