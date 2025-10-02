<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAH TECH - Sign Up</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/signup.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <main>

        <div class="signUpDisplay">
            <form id="signupForm" class="signUpBox" method="post" action="includes/signupUser.php">
                <div class="signUpLogo">
                    <img src="../Image/logo.png" alt="KAH TECH Logo">
                </div>
                <div class="signUpInfo">
                    <label for="Username">Name :</label>
                    <input required type="text" id="Username" name="newUsername" placeholder="Enter Username">
                    <label for="Email">Email :</label>
                    <input required type="email" id="Email" name="newEmail" placeholder="Enter Email">
                    <label for="Phone">Phone Number :</label>
                    <input required type="text" id="Phone" name="newPhone" placeholder="Enter Phone Number">
                    <label for="Address">Address :</label>
                    <input required type="text" id="Address" name="newAddress" placeholder="Enter address">
                    <label for="newPassword">New Password :</label>
                    <input required type="password" id="newPassword" name="newPassword" placeholder="Enter New Password">
                    <label for="confirmPassword">Confirm Password</label>
                    <input required type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
                    <p class="pwd_confirmation" id="pwd_confirmation">Password not match</p>
                    <button class="signUp" type="submit" id="submit_btn" disabled>Sign up</button>
                    <p class="haveAcc">Already have an account? <a class="logIn" href="login.php">Log In</a>.</p>
                </div>
            </form>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script>
        document.getElementById('newPassword').addEventListener('input', validatePassword);
        document.getElementById('confirmPassword').addEventListener('input', validatePassword);

        function validatePassword() {
            var password = document.getElementById('newPassword').value;
            var confirmPassword = document.getElementById('confirmPassword').value;
            var pwd_confirmation = document.getElementById('pwd_confirmation');

            if (confirmPassword != password) {
                pwd_confirmation.style.display = "block";  
                submit_btn.disabled = true;
            } else {
                pwd_confirmation.style.display = "none";
                submit_btn.disabled = false;
            }
        }
    </script>

</body>

</html>