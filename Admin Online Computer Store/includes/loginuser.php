<?php
session_start();
require_once "dbh.inc.php";

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!$conn) {
        die("Database connection failed");
    } else {
        if (isset($_POST['login'])) {
            // Collect form data
            $username = $_POST['Username'];
            $password = $_POST['UserPassword'];
            $email = $_POST['UserEmail']; // Assuming email is also submitted

            $query = mysqli_query($conn, "SELECT * FROM admins WHERE admin_name = '$username' AND admin_email = '$email'");
            $row = mysqli_fetch_assoc($query);

            if (mysqli_num_rows($query) == 0 || $row['admin_pwd'] != $password) {
                echo "<script> alert ('Wrong name, email or password'); window.history.go(-1);</script>";
            } else {
                $_SESSION['ID'] = $row['id'];
                $_SESSION['AdminName'] = $row['admin_name'];
                
                echo "<script>alert ('Log in successfully'); window.location.href='../home.php'; </script>";
            }
        }
    }
}
