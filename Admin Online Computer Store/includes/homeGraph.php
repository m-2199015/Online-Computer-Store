<?php
require_once "dbh.inc.php";

if (!$conn) {
    die("Database connection failed");
} else {
    //Site stats
    $custVisited = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));

    $tempCustPlacedOrder = mysqli_num_rows(mysqli_query($conn, "SELECT user_id FROM orders WHERE status_id <= 5 GROUP BY user_id;"));
    $custPlacedOrder = number_format($tempCustPlacedOrder / $custVisited * 100, 2, ".", "");

    $tempCustCustomizedPC = mysqli_num_rows(mysqli_query($conn, "SELECT user_id FROM mylist GROUP BY user_id;"));
    $CustCustomizedPC = number_format($tempCustCustomizedPC / $custVisited * 100, 2, ".", "");

    //Top items chart
    $topItemsQuery = "SELECT items.item_name AS item_name, SUM(orderitems.qty) AS item_qty, SUM(orderitems.item_price * orderitems.qty) AS item_sales FROM orderitems LEFT JOIN items ON orderitems.item_id = items.id LEFT JOIN orders ON orderitems.order_id = orders.id WHERE orders.status_id <= 5 GROUP BY orderitems.item_id ORDER BY item_qty DESC, item_sales DESC LIMIT 10;";

    $topItemsResult = mysqli_query($conn, $topItemsQuery);
    $topItems_dataPoints = array();

    while ($row = mysqli_fetch_assoc($topItemsResult)) {
        $itemName = $row["item_name"];
        if (strlen($itemName) > 10) {
            $formatName = substr($itemName, 0, 10) . '...';
        } else {
            $formatName = $itemName;
        }
        $itemQty = (int)$row["item_qty"];
        $itemSales = (float)$row["item_sales"];
        $topItems_dataPoints[] = array("y" => $itemQty, "label" => $formatName, "item_sales" => $itemSales, "item_name" => $itemName);
    }
}
