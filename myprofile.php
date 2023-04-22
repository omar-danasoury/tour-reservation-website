<?php

/**
 * OMAR AHMED REFAAT ELDANASOURY, 202005808
 * ITCS333-SEC 03 , COURSE PROJECT, ALONE
 */
session_start();
if (!isset($_SESSION["activeUser"]))
    header("location: index.php");

global $imagePath;
try {
    require("connection.php");
    $userId = $_SESSION["activeUser"][0];
    $rows = $db->query("SELECT * FROM USERS WHERE USERID = $userId");
    if ($row = $rows->fetch()) {
        $storedPassword = $row[3];
        $imagePath1 = $row[5] ?? 'uploads/default-avatar.jpg'; // we got the image path

    }
    $email = $_SESSION["activeUser"][2];
    $username = $_SESSION["activeUser"][1];
    $db = null;
} catch (PDOException $ex) {
    echo "Error: " . $ex->getMessage();
}


if (isset($_POST["reset-password"]))
    header("location: reset-password.php");


if (isset($_POST["update-profile"])) {

    require("functions.php");


    // first check any change in username and email
    $inputUsername = checkInput($_POST["username"]);
    $inputEmail = checkInput($_POST["email"]);

    // if so update them
    if ($inputEmail != $_SESSION["activeUser"][2] and $inputEmail != "") {
        try {
            require("connection.php");
            $userId = $_SESSION["activeUser"][0];
            $db->beginTransaction();
            $rows = $db->query("UPDATE USERS SET EMAIL = '$inputEmail' WHERE USERID = $userId");
            $db->commit();
            $_SESSION["activeUser"][2] = $inputEmail;
        } catch (PDOException $ex) {
            $db->rollBack();
            echo "Error: " . $ex->getMessage();
        }

        $db = null;
        $updated = true;
    }


    // if so update them
    if ($inputUsername != $_SESSION["activeUser"][1] and $inputUsername != "") {
        try {
            require("connection.php");
            $userId = $_SESSION["activeUser"][0];
            $db->beginTransaction();
            $rows = $db->query("UPDATE USERS SET username = '$inputUsername' WHERE USERID = $userId");
            $db->commit();

            $_SESSION["activeUser"][1] = $inputUsername;
        } catch (PDOException $ex) {
            $db->rollBack();
            echo "Error: " . $ex->getMessage();
        }
        $db = null;
    }
}
// then check profile image

if (isset($_FILES["timg"])) {
    $finalPath = "uploads/";
    $images = array_filter($_FILES["timg"]["name"]);
    $imagesCount = count($images);

    $finalPath = "uploads/";
    $tmpFilePath = $_FILES["timg"]["tmp_name"][0];
    $imagePath = $_FILES["timg"]["name"][0];
    $finalPath = $finalPath . $imagePath;

    if (move_uploaded_file($tmpFilePath, $finalPath)) {
        // if it is moved successfully, all values to the database
        try {
            require("connection.php");
            $sql = "UPDATE USERS SET PROFILEPHOTOPATH = ? WHERE USERID = ?";
            $db->beginTransaction();
            $statement = $db->prepare($sql);
            $statement->execute(array($finalPath, $userId));
            $db->commit();
            $updated = true;
        } catch (PDOException $e) {
            $db->rollBack();
            header("location: myprofile.php?success=false");
            echo "Error: " . $e->getMessage();
        }
    } else
        throw new PDOException("Error uploading the image!");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>

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

            <h1 style="font-size: 2em; color: white;">My Profile</h1>
            <br>
            <form enctype="multipart/form-data" method="post" style="color: white;">
                <img class="reviewer" <?php if (isset($_FILES["timg"])) echo "src=\"/333Project/" . $finalPath . "\"";
                                        else echo "src=\"/333Project/" . $imagePath1 . "\"" ?> alt="">
                <br>
                <input type="file" name="timg[]" multiple="multiple"> <br><br>
                <label for="username">Username:*</label>
                <br>
                <input type="text" <?php echo "placeholder='$username'" ?> name="username" id="username">
                <br>

                <label for="email">Email:*</label><br>
                <input type="text" <?php echo "placeholder='$email'" ?> name="email" id="email">
                <br>

                <br>
                <input type="submit" class="butn primary-butn sign-butn" name="update-profile" id="update-profile" value="Update Profile!">
                <br><br>
                <input type="submit" class="butn primary-butn sign-butn" name="reset-password" id="reset-password" value="Change Password!">

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