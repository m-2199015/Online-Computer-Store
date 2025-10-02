<?php
// Database connection
require_once "dbh.inc.php";

$id = $_SESSION['ID'];

// Debugging: Check if the database connection is successful
if (!$conn) {
    die("Database connection failed");
} else {

    $query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'");

    if ($query) {
        // Fetch the updated user information
        $row = mysqli_fetch_assoc($query);

        // if ($row) {
        //     echo $row['user_name'] . '<br><br>' . $row['email'] . '<br><br>' . $row['phone'] . '<br><br>' . $row['user_address'];
        // }
    }
}