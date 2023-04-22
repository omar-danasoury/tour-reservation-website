<?php

/**
 * OMAR AHMED REFAAT ELDANASOURY, 202005808
 * ITCS333-SEC 03 , COURSE PROJECT, ALONE
 */
session_start();
if (isset($_POST["signin"])) {
    require("functions.php");

    $msg = "";
    $password = $_POST["password"];
    $email = $_POST["email"];

    // email
    if (preg_match("/^[a-zA-Z0-9\._\-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/i", $email) == 0)
        $msg .= "Wrong Email!<br>";

    // password
    if (preg_match("/^[\w!@#$%^&*()]{8,}$/i", $password) == 0)
        $msg .= "Wrong Password!<br>";

    if ($msg != "")
        header("location: signin.php?err=$msg");


    try {
        require("connection.php");
        $email = checkInput($_POST["email"]); // input is filtered
        $enteredPassword = checkInput($_POST["password"]);
        $rows = $db->query("SELECT * FROM USERS WHERE EMAIL = '$email'");
    } catch (PDOException $ex) {
        $msg .= "Error while signing in or the user does not exist in the database!";
        header("location: signin.php?err=$msg");
    }

    if ($row = $rows->fetch()) {
        // if we entered here, then the user exists in the database
        $id = $row[0];
        $username = $row[1];
        $hashedPassword = $row[3];
        // we check the password
        if (password_verify($enteredPassword, $hashedPassword)) { // here we update the session
            // user is signed in!
            $_SESSION["activeUser"] = array($id, $username, $email);
            header("location: home.php");
        }
    }

    $db = null;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>

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

            <h1 style="font-size: 2em; color: white;">Sign in</h1>
            <br>
            <form method="post" style="color: white;">
                <label for="email">Email:*</label><br>
                <input type="text" placeholder="email@example.com" name="email" id="email">
                <label for="email"></label>
                <br>

                <label for="password">Password:*</label><br>
                <input type="password" placeholder="***********" name="password" id="password">
                <label for="password"></label>
                <br>

                <input type="submit" class="butn primary-butn sign-butn" name="signin" id="signin" value="Sign in!">

            </form>

            <br>
            <p>Don't have an account? <br><a href="signup.php" style="font-size: 0.75em;background-color: #D79922; color: white;" class="butn primary-butn sign-butn">Create One</a></p>
            <?php
            if (isset($_GET["err"])) {
                $err = $_GET["err"];
                echo "<p style='color: white; font-weight: 600;'>$err</p>";
            }
            ?>
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