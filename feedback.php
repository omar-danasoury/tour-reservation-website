<?php

/**
 * OMAR AHMED REFAAT ELDANASOURY, 202005808
 * ITCS333-SEC 03 , COURSE PROJECT, ALONE
 */
session_start(); // for the header

$tripId = $_GET["tid"];
try {
    $tid = $_GET["tid"];
    require("connection.php");
    $rows = $db->query("SELECT * FROM TRIPS WHERE TRIPID = $tripId");
    $db = null;
} catch (PDOException $ex) {
    echo "Error: " . $ex->getMessage();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>

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


    <main class="" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Rate Us!</h1>
        <div class="catalogue-main" style="flex-direction: column; text-align: center; background-color: #D79922;">
            <?php
            if ($row = $rows->fetch()) {
                $id = $row[0];
                $title = $row[1];
                $from = $row[2];
                $to = $row[3];
                $price = $row[4];
                $imagePath = $row[6];
                $location = $row[5]
            ?>
                <div class="trip-view-container">
                    <img class="trip-view-image" <?php echo "src=\"/333Project/" . $imagePath . "\"" ?> alt="">
                    <div class="trip-view-info">
                        <p class="info" style="color: #4056A1;"><?php echo $title ?></p>
                        <p class="info">From: <?php echo $from ?></p>
                        <p class="info">To: <?php echo $to ?></p>
                        <p class="info" style="color: #F13C20;"> <?php echo $price . " BHD" ?></p>
                    </div>
                </div>
            <?php
            }
            ?>

            <form <?php echo "action='add-feedback.php?tid=$id'" ?> method="post">
                <label style="color:#4056A1;" for="rate">Enter Your Rate out of 5:*</label>
                <br>
                <input type="number" name="rate" id="rate">
                <br>
                <label style="color:#4056A1;" for="words">What are your thoughts?:*</label>
                <br>
                <input type="text" name="words" id="words">
                <br>
                <input type="submit" class="butn primary-butn sign-butn" name="feedback-butn" id="feedback-butn" value="Submit Feedback!">
            </form>



        </div>
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