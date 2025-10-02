<?php
session_start();
require_once "dbh.inc.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = mysqli_query($conn, "DELETE FROM mylist WHERE id = '$id';");

    echo
    "<script>alert('Delete Successfully'); window.location.href='../mylist.php';</script>";
}
