<?php
require_once "dbh.inc.php";

if (!$conn) {
    die("Database connection failed");
} else {
    //Declare variables
    if (!isset($_POST["fromDate"]) || !isset($_POST["toDate"]) || !isset($_POST["summaryBy"])) {
        $currentDate = date("Y-m-d");
        $fromDate = date("Y-m-d", strtotime($currentDate . "-6 day"));
        $toDate = date("Y-m-d", strtotime($currentDate . "+1 day"));
        $summaryBy = "Daily";
    } else {
        $fromDate = $_POST["fromDate"];
        $toDate = $_POST["toDate"];
        $summaryBy = $_POST["summaryBy"];
    }

    //Summary Stats
    $summarySales = number_format((float)mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_price) AS sales FROM orders WHERE status_id <= 5 AND order_date >= '" . $fromDate . " 00:00:00' AND order_date < '" .  $toDate . " 00:00:00';"))["sales"], 2, ".", "");

    $summaryItemSold = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(orderitems.qty) AS total_qty FROM orderitems LEFT JOIN orders ON orderitems.order_id = orders.id WHERE orders.status_id <= 5 AND orders.order_date >= '" . $fromDate . " 00:00:00' AND orders.order_date < '" .  $toDate . " 00:00:00';"))["total_qty"];

    $summaryOrders = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE status_id <= 5 AND order_date >= '" . $fromDate . " 00:00:00' AND order_date < '" .  $toDate . " 00:00:00';"));

    // Total sales chart
    if ($summaryBy == "Daily") {
        $totalSalesQuery = "SELECT DATE(order_date) AS label, SUM(total_price) AS sales FROM orders WHERE status_id <= 5 AND order_date >= '" . $fromDate . " 00:00:00' AND order_date < '" .  $toDate . " 00:00:00' GROUP BY DATE(order_date) ORDER BY label ASC;";
    } else if ($summaryBy == "Monthly") {
        $totalSalesQuery = "SELECT DATE_FORMAT(order_date, '%Y-%m') AS label, SUM(total_price) AS sales FROM orders WHERE status_id <= 5 AND order_date >= '" . $fromDate . " 00:00:00' AND order_date < '" .  $toDate . " 00:00:00' GROUP BY DATE_FORMAT(order_date, '%Y-%m') ORDER BY label ASC;";
    } else {
        $totalSalesQuery = "SELECT YEAR(order_date) AS label, SUM(total_price) AS sales FROM orders WHERE status_id <= 5 AND order_date >= '" . $fromDate . " 00:00:00' AND order_date < '" .  $toDate . " 00:00:00' GROUP BY YEAR(order_date) ORDER BY label ASC;";
    }

    $totalSalesResult = mysqli_query($conn, $totalSalesQuery);
    $totalSales_dataPoints = array();

    if ($summaryBy == "Daily") {
        $tempDate = strtotime($fromDate);
        $endDate = strtotime($toDate);
        $row = mysqli_fetch_assoc($totalSalesResult);
        while ($tempDate < $endDate) {
            if ($row) { //database not empty
                if ($tempDate == strtotime($row["label"])) { //database have
                    $sales = (float)$row["sales"];
                    $label = date("d M Y", strtotime($row["label"]));
                    $row = mysqli_fetch_assoc($totalSalesResult);
                } else { //database don't have
                    $sales = 0;
                    $label = date("d M Y", $tempDate);
                }
            } else { //database empty
                $sales = 0;
                $label = date("d M Y", $tempDate);
            }

            $totalSales_dataPoints[] = array("y" => $sales, "label" => $label);
            $tempDate = strtotime("+1 day", $tempDate);
        }
    } else if ($summaryBy == "Monthly") {
        $tempDate = date("Ym", strtotime($fromDate));
        $endDate = date("Ym", strtotime($toDate . "-1 day"));
        $row = mysqli_fetch_assoc($totalSalesResult);
        while ($tempDate <= $endDate) {
            if ($row) { //database not empty
                if ($tempDate == date("Ym", strtotime($row["label"] . "-01"))) { //database have
                    $sales = (float)$row["sales"];
                    $label = date("M Y", strtotime($row["label"] . "-01"));
                    $row = mysqli_fetch_assoc($totalSalesResult);
                } else { //database don't have
                    $sales = 0;
                    $label = date("M Y", strtotime($tempDate . "01"));
                }
            } else { //database empty
                $sales = 0;
                $label = date("M Y", strtotime($tempDate . "01"));
            }

            $totalSales_dataPoints[] = array("y" => $sales, "label" => $label);
            $tempDate = date("Y-m-d", strtotime($tempDate . "01"));
            $tempDate = date("Ym", strtotime($tempDate . "+1 month"));
        }
    } else {
        $tempDate = date("Y", strtotime($fromDate));
        $endDate = date("Y", strtotime($toDate . "-1 day"));
        $row = mysqli_fetch_assoc($totalSalesResult);
        while ($tempDate <= $endDate) {
            if ($row) { //database not empty
                if ($tempDate == $row["label"]) { //database have
                    $sales = (float)$row["sales"];
                    $label = $row["label"];
                    $row = mysqli_fetch_assoc($totalSalesResult);
                } else { //database don't have
                    $sales = 0;
                    $label = $tempDate;
                }
            } else { //database empty
                $sales = 0;
                $label = $tempDate;
            }

            $totalSales_dataPoints[] = array("y" => $sales, "label" => $label);
            $tempDate = $tempDate + 1;
        }
    }

    //Category sales chart
    $categorySalesQuery = "SELECT items.category_id AS category, SUM(orderitems.item_price * orderitems.qty) AS category_sales FROM orderitems LEFT JOIN items ON orderitems.item_id = items.id LEFT JOIN orders ON orderitems.order_id = orders.id WHERE orders.status_id <= 5 AND orders.order_date >= '" . $fromDate . " 00:00:00' AND orders.order_date < '" .  $toDate . " 00:00:00' GROUP BY items.category_id ORDER BY category ASC;";

    $categorySalesResult = mysqli_query($conn, $categorySalesQuery);
    $categorySales_dataPoints = array();

    while ($row = mysqli_fetch_assoc($categorySalesResult)) {
        $categoryName = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM categories WHERE id = " . $row['category'] . ";"))["category_name"];
        $categorySales = (float)$row["category_sales"];
        $categorySales_dataPoints[] = array("y" => $categorySales, "label" => $categoryName);
    }

    //Payment distribution chart
    $paymentDistributionQuery = "SELECT payment_type, SUM(total_price) AS payment_amount FROM orders WHERE status_id <= 5 AND order_date >= '" . $fromDate . " 00:00:00' AND order_date < '" .  $toDate . " 00:00:00' GROUP BY payment_type;";

    $total_payment_amount = (float)mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_price) AS total_payment_amount FROM orders WHERE status_id <= 5 AND order_date >= '" . $fromDate . " 00:00:00' AND order_date < '" .  $toDate . " 00:00:00';"))["total_payment_amount"];

    $paymentDistributionResult = mysqli_query($conn, $paymentDistributionQuery);
    $paymentDistribution_dataPoints = array();

    while ($row = mysqli_fetch_assoc($paymentDistributionResult)) {
        $paymentType = $row["payment_type"];
        $paymentAmount = (float)$row["payment_amount"];
        $paymentPercent = number_format($paymentAmount / $total_payment_amount * 100, 2, ".", "");
        $paymentDistribution_dataPoints[] = array("y" => $paymentAmount, "label" => $paymentType, "percent" => $paymentPercent);
    }
}
