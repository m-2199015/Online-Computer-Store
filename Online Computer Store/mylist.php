<?php
require_once "includes/security.php";
include 'includes/checkList.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAH TECH - My List</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/customize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>
    <?php
    include 'header.php';
    ?>

    <main>
        <!-- add cart button -->
        <div class="addCart">
            <a class="mylistButton new" href="customizePC.php">NEW</a>
        </div>
        <hr>

        <!-- Add cart description -->
        <div class="myListTitle">
            <p class="title">MY LIST</p>
            <?php
            if (isset($_GET["sortBy"])) {
                if ($_GET["sortBy"] == "lowToHigh") {
                    echo '<a class="filterButton" href="mylist.php?sortBy=highToLow">High to Low <i class="fa-solid fa-filter-circle-dollar"></i></a>';
                } else if ($_GET["sortBy"] == "highToLow") {
                    echo '<a class="filterButton" href="mylist.php?sortBy=lowToHigh">Low to High <i class="fa-solid fa-filter-circle-dollar"></i></a>';
                }
            } else {
                echo '<a class="filterButton" href="mylist.php?sortBy=lowToHigh">Low to High <i class="fa-solid fa-filter-circle-dollar"></i></a>';
            }
            ?>

        </div>
        <hr>
        <?php
        include "includes/dbh.inc.php";
        ?>

        <?php
        $id = $_SESSION['ID'];
        if (isset($_GET["sortBy"])) {
            if ($_GET["sortBy"] == "lowToHigh") {
                $rows = mysqli_query($conn, "SELECT mylist.id, mylist.list_name, mylist.user_id,
            cpu.item_name AS cpu_name, cpu.price AS cpu_price,
            motherboard.item_name AS motherboard_name, motherboard.price AS motherboard_price,
            memory.item_name AS memory_name, memory.price AS memory_price,
            gpu.item_name AS gpu_name, gpu.price AS gpu_price,
            psu.item_name AS psu_name, psu.price AS psu_price,
            storage.item_name AS storage_name, storage.price AS storage_price
            FROM mylist
            LEFT JOIN items AS cpu ON mylist.cpu_id = cpu.id
            LEFT JOIN items AS motherboard ON mylist.motherboard_id = motherboard.id
            LEFT JOIN items AS memory ON mylist.memory_id = memory.id
            LEFT JOIN items AS gpu ON mylist.gpu_id = gpu.id
            LEFT JOIN items AS psu ON mylist.psu_id = psu.id
            LEFT JOIN items AS storage ON mylist.storage_id = storage.id
            WHERE mylist.user_id = $id ORDER BY mylist.total_price ASC, mylist.id ASC;");
            } else if ($_GET["sortBy"] == "highToLow") {
                $rows = mysqli_query($conn, "SELECT mylist.id, mylist.list_name, mylist.user_id,
            cpu.item_name AS cpu_name, cpu.price AS cpu_price,
            motherboard.item_name AS motherboard_name, motherboard.price AS motherboard_price,
            memory.item_name AS memory_name, memory.price AS memory_price,
            gpu.item_name AS gpu_name, gpu.price AS gpu_price,
            psu.item_name AS psu_name, psu.price AS psu_price,
            storage.item_name AS storage_name, storage.price AS storage_price
            FROM mylist
            LEFT JOIN items AS cpu ON mylist.cpu_id = cpu.id
            LEFT JOIN items AS motherboard ON mylist.motherboard_id = motherboard.id
            LEFT JOIN items AS memory ON mylist.memory_id = memory.id
            LEFT JOIN items AS gpu ON mylist.gpu_id = gpu.id
            LEFT JOIN items AS psu ON mylist.psu_id = psu.id
            LEFT JOIN items AS storage ON mylist.storage_id = storage.id
            WHERE mylist.user_id = $id ORDER BY mylist.total_price DESC, mylist.id ASC;");
            }
        } else {
            $rows = mysqli_query($conn, "SELECT mylist.id, mylist.list_name, mylist.user_id,
            cpu.item_name AS cpu_name, cpu.price AS cpu_price,
            motherboard.item_name AS motherboard_name, motherboard.price AS motherboard_price,
            memory.item_name AS memory_name, memory.price AS memory_price,
            gpu.item_name AS gpu_name, gpu.price AS gpu_price,
            psu.item_name AS psu_name, psu.price AS psu_price,
            storage.item_name AS storage_name, storage.price AS storage_price
            FROM mylist
            LEFT JOIN items AS cpu ON mylist.cpu_id = cpu.id
            LEFT JOIN items AS motherboard ON mylist.motherboard_id = motherboard.id
            LEFT JOIN items AS memory ON mylist.memory_id = memory.id
            LEFT JOIN items AS gpu ON mylist.gpu_id = gpu.id
            LEFT JOIN items AS psu ON mylist.psu_id = psu.id
            LEFT JOIN items AS storage ON mylist.storage_id = storage.id
            WHERE mylist.user_id = $id ORDER BY mylist.id ASC;");
        }
        ?>

        <?php foreach ($rows as $row) : ?>
            <div class="myListContent">
                <table style="width: 100%;">
                    <tr class="mylistNameLine">
                        <td colspan="4" style="width: 30%; text-align:center;">
                            <p style="font-weight:bold; padding-bottom:8px"> <?php echo $row['list_name'] ?></p>
                        </td>
                    </tr>
                    <tr class="mylistrows">
                        <td class="mylistCategory">
                            <p>CPU NAME </p>
                            <p>MEMORY NAME</p>
                            <p>MOTHERBOARD NAME </p>
                            <p>STORAGE NAME</p>
                            <p>GPU NAME</p>
                            <p>PSU NAME</p>
                        </td>
                        <td style="width:50%">
                            <p class="mylistAccesoryNameData">: <?php echo isset($row['cpu_name']) ? $row['cpu_name'] : '(Not Available)'; ?></p>
                            <p class="mylistAccesoryNameData">: <?php echo isset($row['memory_name']) ? $row['memory_name'] : '(Not Available)'; ?></p>
                            <p class="mylistAccesoryNameData">: <?php echo isset($row['motherboard_name']) ? $row['motherboard_name'] : '(Not Available)'; ?></p>
                            <p class="mylistAccesoryNameData">: <?php echo isset($row['storage_name']) ? $row['storage_name'] : '(Not Available)'; ?></p>
                            <p class="mylistAccesoryNameData">: <?php echo isset($row['gpu_name']) ? $row['gpu_name'] : '(Not Available)'; ?></p>
                            <p class="mylistAccesoryNameData">: <?php echo isset($row['psu_name']) ? $row['psu_name'] : '(Not Available)'; ?></p>
                        </td>
                        <td style="width: 15%;">
                            <p>RM <?php echo isset($row['cpu_price']) ? $row['cpu_price'] : '0.00'; ?></p>
                            <p>RM <?php echo isset($row['memory_price']) ? $row['memory_price'] : '0.00'; ?></p>
                            <p>RM <?php echo isset($row['motherboard_price']) ? $row['motherboard_price'] : '0.00'; ?></p>
                            <p>RM <?php echo isset($row['storage_price']) ? $row['storage_price'] : '0.00'; ?></p>
                            <p>RM <?php echo isset($row['gpu_price']) ? $row['gpu_price'] : '0.00'; ?></p>
                            <p>RM <?php echo isset($row['psu_price']) ? $row['psu_price'] : '0.00'; ?></p>
                        </td>
                        <td>
                            <div class="manage_list">
                                <a class="mylistButton edit" href="editMylistform.php?id=<?php echo $row['id'] ?>"><i class="fa-solid fa-pen-to-square"></i> EDIT</a>
                                <a class="mylistButton delete" href="includes/deleteMylist.php?id=<?php echo $row['id'] ?>"><i class="fa-solid fa-trash-can"></i> DELETE</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>TOTAL PRICE:</p>
                        </td>
                        <td></td>
                        <td>
                            <?php
                            $total_price = 0;
                            $total_price += isset($row['cpu_price']) ? $row['cpu_price'] : 0;
                            $total_price += isset($row['motherboard_price']) ? $row['motherboard_price'] : 0;
                            $total_price += isset($row['memory_price']) ? $row['memory_price'] : 0;
                            $total_price += isset($row['gpu_price']) ? $row['gpu_price'] : 0;
                            $total_price += isset($row['psu_price']) ? $row['psu_price'] : 0;
                            $total_price += isset($row['storage_price']) ? $row['storage_price'] : 0;
                            ?>
                            <p>RM <?php echo number_format($total_price, 2, ".", "") ?></p>
                        </td>
                        <td>
                            <div class="manage_list" style="height: 40px;">
                                <?php
                                $is_available = isset($row['cpu_name']) && isset($row['memory_name']) && isset($row['motherboard_name']) && isset($row['storage_name']) && isset($row['gpu_name']) && isset($row['psu_name']);
                                if ($is_available) {
                                    echo '<a class="mylistButton new" href="includes/mylistCart.php?id=' . $row['id'] . '"><i class="fa-solid fa-cart-shopping"></i> CART</a>';
                                } else {
                                    echo '<button class="mylistButton notAvailable" onclick="alertUnavailable()"><i class="fa-solid fa-ban"></i></button>';
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        <?php endforeach; ?>
    </main>

    <?php
    include 'footer.php';
    ?>

    <script>
        function alertUnavailable() {
            alert("Item(s) is unavailable.");
        }
    </script>
</body>

</html>