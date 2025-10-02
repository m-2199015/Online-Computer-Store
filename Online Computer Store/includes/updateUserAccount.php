<?php
session_start();
require_once "dbh.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = htmlspecialchars($_POST["newUsername"]);
    $email = htmlspecialchars($_POST["newEmail"]);
    $phone = htmlspecialchars($_POST["newPhone"]);
    $address = htmlspecialchars($_POST["newAddress"]);
    $password = htmlspecialchars($_POST["newPassword"]);
    $confirmPassword = htmlspecialchars($_POST["confirmPassword"]);
    $img1 = $_FILES["accountimg"];

    // Database connection
    if (!$conn) {
        die("Database connection failed");
    }
    if ($confirmPassword != $password) {
        echo "<script>alert('Confirm password error'); window.history.back();</script>";
    }else{

    // Prepare SQL statement to prevent SQL injection
    $id = $_SESSION['ID'];
    $oriImgPath = mysqli_fetch_assoc(mysqli_query($conn, "SELECT user_image FROM users WHERE id = $id;"));
    $query = "UPDATE users SET user_name='$name', email='$email', phone='$phone', user_Address='$address', pwd='$password' WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        // Update image if there are changes
        if (!empty($img1["name"])) {
            $img1_file_name = uniqid("", true) . "." . pathinfo($img1["name"], PATHINFO_EXTENSION);
            $query = "UPDATE users SET user_image = '$img1_file_name' WHERE id = $id;";
            if (mysqli_query($conn, $query)) {
                move_uploaded_file($img1["tmp_name"], "../image/" . $img1_file_name);
                if ($oriImgPath["accountimg"] != "") {
                    $file = "../image/" . $oriImgPath["accountimg"];
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            } else {
                echo "<script>alert('Account updated unsuccessful'); window.location.href='../editAccountForm.php';</script>";
            }
        }

        echo "<script>alert('Account update successfully'); window.location.href='../accountPage.php';</script>";
    } else {
        echo "<script>alert('Account update failed'); window.location.href='../editAccountForm.php';</script>";
    }
}
}
?>