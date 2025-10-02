<?php
require_once "dbh.inc.php";

$itemID = $_GET["item"];

//Query
$query = "UPDATE items SET item_status = 'Deleted' WHERE id = $itemID;";

//Delete item from database by changing the status
if (mysqli_query($conn, $query)) {
    echo "<script>alert('Item deleted successfully'); window.location.href='../store.php';</script>";
} else {
    echo "<script>alert('Item deleted unsuccessful'); window.location.href='../store.php';</script>";
}
