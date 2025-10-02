<?php
session_start();

// Database connection
require_once "dbh.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_SESSION['ID'];
  // Collect form data
  $file_name = $_FILES['image']['name'];
  $tempname = $_FILES['image']['tmp_name'];
  $folder = '../image/' . $file_name;


  $query = "UPDATE users SET user_image = '$file_name' WHERE id = '$id'";

  if (mysqli_query($conn, $query)) {
    // Move uploaded file to the specified folder
    if (move_uploaded_file($tempname, $folder)) {
      echo "<p>FILE UPLOADED SUCCESSFULLY</p>";
      header("location: ../accountPage.php");
    } else {
      echo "<p>FILE UPLOADED SUCCESSFULLY BUT FAILED TO MOVE TO DESTINATION FOLDER</p>";
      header("location: ../accountPage.php");
    }
  }
}
