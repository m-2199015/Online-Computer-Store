<?php
require_once "includes/security.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAH TECH - Account</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/accountPage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


</head>

<body>
    <?php
    include 'header.php';
    ?>

    <main>
        <div class=accDisplay>
            <div class="accBox">
                <!-- Welcome box -->
                <div class="FirstAccBox">
                    <P>My Account</P>
                </div>

                <!-- content box-->
                <div class="MainAccBox">
                    <div class=accImage>

                        <?php
                        require_once "includes/dbh.inc.php";
                        $id = $_SESSION['ID'];
                        $query = mysqli_query($conn, "SELECT user_image FROM users WHERE id = '$id'");

                        if ($query) {
                            // Fetch the updated user information
                            $row = mysqli_fetch_assoc($query);
                        }
                        ?>
                        <?php ?>
                        <img class="accountImg" src="image/<?php echo $row['user_image'] ?>">

                    </div>

                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'");
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <div class=showAccountDetails>
                        <div style="margin-bottom: 5px;">
                            <label for="Username">Name :</label>
                            <input required type="text" id="Username" value="<?php echo $row['user_name'] ?>" readonly>
                        </div>
                        <div style="margin-bottom: 5px;">
                            <label for="Email">Email :</label>
                            <input required type="email" id="Email" value="<?php echo $row['email'] ?>" readonly>
                        </div>
                        <div style="margin-bottom: 5px;">
                            <label for=" Phone">Phone Number :</label>
                            <input required type="text" id="Phone" value="<?php echo $row['phone'] ?>" readonly>
                        </div>
                        <div style="margin-bottom: 25px;">
                            <label for="Address">Address :</label>
                            <input required type="text" id="Address" value="<?php echo $row['user_address'] ?>" readonly>
                        </div>
                        <div class="buttons">
                            <a class="editButton" href="editAccountForm.php">EDIT</a>
                            <a class="logOutButton" href="includes/logoutAccount.php">LOG OUT</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php
    include 'footer.php';
    ?>
</body>

</html>