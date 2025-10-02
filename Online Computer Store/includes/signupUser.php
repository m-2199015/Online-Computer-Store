<?php
require_once "dbh.inc.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect form data
    $name = htmlspecialchars($_POST["newUsername"]);
    $email = htmlspecialchars($_POST["newEmail"]);
    $phone = htmlspecialchars($_POST["newPhone"]);
    $address = htmlspecialchars($_POST["newAddress"]);
    $password = htmlspecialchars($_POST["newPassword"]);
    $confirmPassword = htmlspecialchars($_POST["confirmPassword"]);

    // Insert into database
    $query = "INSERT INTO users (user_name, email, phone, user_address, pwd) VALUES ('$name', '$email', '$phone', '$address', '$password');";
    $result =  mysqli_query($conn, $query);

    echo "<script>alert('Sign up successfully'); window.location.href='../login.php';</script>";
}
