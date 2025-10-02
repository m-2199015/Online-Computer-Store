<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAH TECH - Home</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/header_footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>
    <header>
        <div>
            <!--Logo-->
            <a class="nav_button" href="index.php"><img src="../Image/logo.png" class="logo" alt="KAH TECH Logo"></a>

            <!-- About Us -->
            <a class="nav_button" href="index.php #about_us">About Us</a>

            <?php
            if (isset($_SESSION['ID'])) {
                //Customize Your Own
                echo '<a class="nav_button" style="font-weight: 800" href="mylist.php">Customize Your Own</a>';

                //Accessories
                echo '<a class="nav_button" href="store.php">Store</a>';
            } else {
                //Customize Your Own
                echo '<a class="nav_button" style="font-weight: 800" href="login.php">Customize Your Own</a>';

                //Accessories
                echo '<a class="nav_button" href="login.php">Store</a>';
            }
            ?>

        </div>
        <div>
            <?php
            if (isset($_SESSION['ID'])) {
                //Get pending received order and total item in cart
                require_once 'includes/dbh.inc.php';
                if (!$conn) {
                    die("Database connection failed");
                } else {
                    $toReceiveOrder = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE status_id <= 4 AND user_id = " . $_SESSION['ID'] . ";"));
                    $result = mysqli_query($conn, "SELECT qty FROM items INNER JOIN cart ON items.id = cart.item_id WHERE item_status = 'Active' AND user_id = " . $_SESSION['ID'] . ";");
                    $totalCartItem = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $totalCartItem += $row["qty"];
                    }
                }

                //Order
                echo '<a class="nav_button" href="order.php"><i class="fa-solid fa-clipboard-list"></i>';
                if ($toReceiveOrder > 0 && $toReceiveOrder < 100) {
                    echo '<p class="red_dot">' . $toReceiveOrder . '</p>';
                } else if ($toReceiveOrder >= 100) {
                    echo '<p class="red_dot">99+</p>';
                }
                echo '</a>';

                //Cart
                if ($totalCartItem > 0 && $totalCartItem < 100) {
                    echo '<a class="nav_button" href="userCart.php"><i class="fa-solid fa-cart-shopping"></i><p class="red_dot">' . $totalCartItem . '</p></a>';
                } else if ($totalCartItem >= 100) {
                    echo '<a class="nav_button" href="userCart.php"><i class="fa-solid fa-cart-shopping"></i><p class="red_dot">99+</p></a>';
                } else {
                    echo '<a class="nav_button" href="userCart.php"><i class="fa-solid fa-cart-shopping"></i></a>';
                }

                //Account
                echo '<a class="nav_button" href="accountPage.php"><i class="fa-solid fa-circle-user"></i></a>';
            } else {
                //Order
                echo '<a class="nav_button" href="login.php"><i class="fa-solid fa-clipboard-list"></i></a>';

                //Cart
                echo '<a class="nav_button" href="login.php"><i class="fa-solid fa-cart-shopping"></i></a>';

                //Account
                echo '<a class="nav_button" href="login.php"><i class="fa-solid fa-circle-user"></i></a>';
            }
            ?>
        </div>
    </header>
</body>

</html>