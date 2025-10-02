<?php
require_once "dbh.inc.php";

if (!$conn) {
    die("Database connection failed");
} else {
    //Get variable from url
    if (!isset($_GET["category"]) && !isset($_GET["search"])) {
        //category and search is null
        $itemResult = mysqli_query($conn, "SELECT items.id, items.item_name, items.price, items.stock_qty, items.description, items.image1, items.image2, items.image3, items.image4, items.image5, categories.category_name FROM items LEFT JOIN categories ON items.category_id = categories.id WHERE item_status = 'Active';");
    } else if (isset($_GET["category"]) && !isset($_GET["search"])) {
        //category is not null & search is null
        $category = $_GET["category"];
        $itemResult = mysqli_query($conn, "SELECT items.id, items.item_name, items.price, items.stock_qty, items.description, items.image1, items.image2, items.image3, items.image4, items.image5, categories.category_name FROM items LEFT JOIN categories ON items.category_id = categories.id WHERE item_status = 'Active' AND LOWER(categories.category_name) = LOWER('$category');");
    } else {
        //search is not null
        $search = $_GET["search"];
        $itemResult = mysqli_query($conn, "SELECT items.id, items.item_name, items.price, items.stock_qty, items.description, items.image1, items.image2, items.image3, items.image4, items.image5, categories.category_name FROM items LEFT JOIN categories ON items.category_id = categories.id WHERE item_status = 'Active' AND (LOWER(items.item_name) LIKE LOWER('%$search%') OR LOWER(items.description) LIKE LOWER('%$search%') OR LOWER(categories.category_name) LIKE LOWER('%$search%'));");
    }

    //Get category name
    $categoryResult = mysqli_query($conn, "SELECT category_name FROM categories;");
}
