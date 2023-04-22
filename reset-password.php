<?php

/**
 * OMAR AHMED REFAAT ELDANASOURY, 202005808
 * ITCS333-SEC 03 , COURSE PROJECT, ALONE
 */
session_start();
if (!isset($_SESSION["activeUser"]))
    header("location: index.php");


if (isset($_POST["reset-password"])) {
    require("functions.php");

    $msg = "";
    $password = checkInput($_POST["password"]);
    $confirmPassword = checkInput($_POST["cpassword"]);

    if (preg_match("/^[\w!@#$%^&*()]{8,}$/i", $password) == 0)
        $msg .= "Invlaid Password, it must be more than 8 characters!<br>";
    if (preg_match("/^[\w!@#$%^&*()]{8,}$/i", $confirmPassword) == 0)
        $msg .= "Invlaid Password, it must be more than 8 characters!<br>";
    // do input validation in php, using regex
    // check the username, email, and the two passwords
    // later


    if ($password != $confirmPassword) {
        $msg .= "Passwords must be identical!<br>";
    }

    if ($msg != "")
        header("location: reset-password.phh?err=$msg");

    // if valid, add the data, but before that convert the passwords first to sha
    // convert password to sha:
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // then we add to the database
    try {
        require("connection.php");
        $sql = "UPDATE USERS SET PASSWORD = ? WHERE USERID = ?";
        $db->beginTransaction();
        $statement = $db->prepare($sql);
        $statement->execute(array($hashed_password, $_SESSION["activeUser"][0]));

        if ($statement->rowCount() != 1) {
            throw new PDOException();
        }

        $db->commit();
        $bd = null;
    } catch (PDOException $e) {
        $db->rollBack();
        echo "Error: " . $e->getMessage();
    }

    header("location: home.php?password-reset=true");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <!-- Adding the css files -->
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css" />

    <!-- Adding the Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    </style>

    <!-- Adding FontAwesome Kit -->
    <script src="https://kit.fontawesome.com/163915b421.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php require("header.php") ?>


    <main>
        <section class="sign-form">

            <h1 style="font-size: 2em; color: white;">Reset Password</h1>
            <br>
            <form action="" method="post" style="color: white;">
                <label for="password">New Password:*</label><br>
                <input type="password" placeholder="***********" name="password" id="password">
                <br>

                <label for="confirm-password">Confirm Password:*</label><br>
                <input type="password" placeholder="***********" name="cpassword" id="confirm-password">
                <br>


                <br>
                <input type="submit" class="butn primary-butn sign-butn" name="reset-password" id="reset-password" value="Reset Password!">
                <?php
                if (isset($_GET["err"])) {
                    $err = $_GET["err"];
                    echo "<p style='color: white; font-weight: 600;'>$err</p>";
                }
                ?>
            </form>
        </section>
    </main>



    <footer>
        <a href="catalogue.php">Browse Catalogue</a>
        <br>
        <a href="#" class="social">
            <i class="fa-brands fa-facebook"></i>
        </a>
        <a href="#" class="social">
            <i class="fa-brands fa-twitter"></i>
        </a>
        <a href="#" class="social">
            <i class="fa-brands fa-instagram"></i>
        </a>
        <p>Copyrights &copy; Omar Ahmed Eldanasoury, 202005808</p>
    </footer>

    <!-- Bootstrap via web -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>