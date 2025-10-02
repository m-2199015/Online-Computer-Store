<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up page</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/signup.css">

</head>

<body>

    <?php
    include 'header.php';
    ?>

    <main>
        <!-- Biggest box in body to set background -->
        <div class=signupDisplay>

            <!-- Welcome box -->
            <div class="WelcomeSignup"> Sign Up NOW!
            </div>

            <!-- Set up sign up content -->
            <div class="signupBox">
                <!-- <div class= signupLogo>
                    <img src="image/logo.png" alt="KAH TECH Logo">
                </div> -->

                <form action="includes/updateacc.php" method="POST">
                    <label for id="Username">Name :</label><br>
                    <input type="text" id="Username" name="newUsername" placeholder="Enter Username">
                    <br><br>
                    <label for id="Email">Email :</label><br>
                    <input type="email" id="Email" name="newEmail" placeholder="Enter Email">
                    <br><br>
                    <label for id="Phone">Phone Number :</label><br>
                    <input type="text" id="Phone" name="newPhone" placeholder="Enter Phone Number">
                    <br><br>
                    <!-- <label for id="Address">Address :</label><br>
                    <textarea type="text" name="newAddress" placeholder="Enter address"> </textarea>
                    <br><br> -->
                    <label for id="Address">Address :</label><br>
                    <input type="text" id="Address" name="newAddress" placeholder="Enter address">
                    <br><br>
                    <label for id="newPassword">New Password :</label><br>
                    <input type="password" id="newPassword" name="newPassword" placeholder="Enter New Password">
                    <br><br>
                    <label for id="confirmPassword">Confirm Password :</label><br>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
                    <br>
                    <button class="signupButton" type="submit">Sign up </button>
                </form>

            </div>

            <!-- back to login account  -->
            <a class="haveAcc" href="login.php"> Already have an account? </a>

        </div>


    </main>

    <?php
    include 'footer.php';
    ?>

</body>

</html>