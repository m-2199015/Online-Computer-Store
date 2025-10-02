<?php
require_once "includes/security.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAH TECH - Store</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/store.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>
    <?php
    include 'header.php';
    include 'includes/storeGetVar.php';
    ?>

    <main>
        <div class="store_head">
            <!-- search bar -->
            <form class="search_bar" action="store.php" method="$_GET">
                <div class="search_box">
                    <input type="text" name="search" placeholder="Search">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>

            <!-- category bar -->
            <div class="category_bar">
                <?php
                if (!isset($category)) { //no chosen category
                    echo '<a class="category_button selected" href="store.php">ALL</a>';
                    while ($row = mysqli_fetch_assoc($categoryResult)) {
                        echo '<a class="category_button" href="store.php?category=' . $row["category_name"] . '">' . strtoupper($row["category_name"]) . '</a>';
                    }
                } else { //got chosen category
                    echo '<a class="category_button" href="store.php">ALL</a>';
                    while ($row = mysqli_fetch_assoc($categoryResult)) {
                        if (strtolower($row["category_name"]) === strtolower($category)) {
                            echo '<a class="category_button selected" href="store.php?category=' . $row["category_name"] . '">' . strtoupper($row["category_name"]) . '</a>';
                        } else {
                            echo '<a class="category_button" href="store.php?category=' . $row["category_name"] . '">' . strtoupper($row["category_name"]) . '</a>';
                        }
                    }
                }
                ?>
            </div>
        </div>

        <div class="store_body">
            <?php //no result
            if (mysqli_num_rows($itemResult) == 0) {
                echo '<p class="no_result">No Result</p>';
            } else { //got result
                echo '<table class="item_display">';
                while ($row = mysqli_fetch_assoc($itemResult)) {
            ?>
                    <tr>
                        <!-- image -->
                        <td style="width: 20%;">
                            <a href="itemDetails.php?item=<?php echo $row['id']; ?>">
                                <img class="item_image" src="../Image/<?php echo $row['image1']; ?>" alt="<?php echo $row['item_name']; ?>">
                            </a>
                        </td>

                        <!-- details -->
                        <td style="width: 80%;">
                            <div class="item_details">
                                <a class="item_details_link" href="itemDetails.php?item=<?php echo $row['id']; ?>">
                                    <div>
                                        <p class="item_name"><?php echo $row["item_name"]; ?></p>
                                        <p class="item_desc"><?php echo $row["description"]; ?></p>
                                    </div>
                                    <div>
                                        <p class="item_price"><?php echo 'RM ' . $row["price"]; ?></p>
                                        <?php
                                        if ($row["stock_qty"] == 0) {
                                            echo '<p class="item_stock" style="color: rgb(255, 52, 52);">Stock: ' . $row["stock_qty"] . '</p>';
                                        } else {
                                            echo '<p class="item_stock" style="color: rgb(60, 179, 113);">Stock: ' . $row["stock_qty"] . '</p>';
                                        }
                                        ?>
                                    </div>
                                </a>
                                <a class="add_to_cart_button" href="includes/addToCart.php?item=<?php echo $row['id']; ?>&qty=1">ADD TO CART</a>
                            </div>
                        </td>
                    </tr>
            <?php
                }
                echo '</table>';
            }
            ?>
        </div>
    </main>

    <?php
    include 'footer.php';
    ?>

</body>

</html>