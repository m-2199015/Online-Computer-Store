<?php
session_start();
include "dbh.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_items = $_POST['item_id'];
    $method = $_POST['payment'];
    $id = $_POST['user'];
    $address = $_POST['newAddress'];
    $totalPrice = $_POST['totalPrice'];

    if ($method == "TNG") {
        $proofImage = $_FILES["proofImage"]["name"];

        //create new file name
        $new_file_name = uniqid("", true) . "." . pathinfo($proofImage, PATHINFO_EXTENSION);

        //query
        $insertOrderQuery = "INSERT INTO orders (delivery_address, total_price, payment_type, screenshot, user_id) 
                         VALUES ('$address', '$totalPrice', '$method', '$new_file_name', '$id')";
    } else {
        $insertOrderQuery = "INSERT INTO orders (delivery_address, total_price, payment_type, user_id) 
        VALUES ('$address', '$totalPrice', '$method', '$id')";
    }

    if (mysqli_query($conn, $insertOrderQuery)) {
        $orderId = mysqli_insert_id($conn);

        foreach ($selected_items as $cart_id) {
            $getItemQuery = "SELECT qty, item_id FROM cart WHERE user_id = $id AND id = $cart_id;";
            $result = mysqli_query($conn, $getItemQuery);

            $row = mysqli_fetch_assoc($result);
            $qty = $row['qty'];
            $itemId = $row['item_id'];

            $itemPrice = mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM items WHERE id = $itemId;"))["price"];

            $insertOrderItemQuery = mysqli_query($conn, "INSERT INTO orderitems (qty, item_id, item_price, order_id) 
            VALUES ('$qty', '$itemId', $itemPrice, '$orderId');");

            $reduce_stock = mysqli_query($conn, "UPDATE items SET stock_qty = stock_qty - $qty WHERE id = $itemId;");

            $removeFromCartQuery = mysqli_query($conn, "DELETE FROM cart WHERE id = '$cart_id';");
        }

        if ($method == "TNG") {
            //insert screenshot into folder
            move_uploaded_file($_FILES["proofImage"]["tmp_name"], "../../Image/" . $new_file_name);
        }

        echo "<script>alert('Place Order Successfully'); window.location.href='../index.php';</script>";
    }
}
