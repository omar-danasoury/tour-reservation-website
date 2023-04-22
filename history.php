<?php

/**
 * OMAR AHMED REFAAT ELDANASOURY, 202005808
 * ITCS333-SEC 03 , COURSE PROJECT, ALONE
 */
session_start(); // for the header

// here we need to get all the trips from the system
// and then generating cards in the html body

// 1 - getting the data from the database
try {
    require("connection.php");
    $userid = $_SESSION["activeUser"][0];
    $rows = $db->query("SELECT * FROM RESERVATIONS WHERE USERID = $userid");
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
    <title>My History</title>

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
        <h1 class="catalogue-header" style="color: #4056A1;">My History</h1>
        <div class="catalogue-main">
            <?php


            while ($row = $rows->fetch() and $rows->rowCount() != 0) {
                $tripId = $row[1];
                $userId = $row[2];
                $status = $row[3];
                $feedback = $row[4];
                $reservDate = $row[5];
                $numOfStars = $row[6];




                try {
                    require("connection.php");
                    $tRows = $db->query("SELECT * FROM TRIPS WHERE TRIPID = $tripId");
                    $db = null;
                } catch (PDOException $ex) {
                    echo "Error: " . $ex->getMessage();
                }
                while ($tRow = $tRows->fetch()) {
                    $id = $tRow[0];
                    $title = $tRow[1];
                    $from = $tRow[2];
                    $to = $tRow[3];
                    $price = $tRow[4];
                    $imagePath = $tRow[6];
            ?>

                    <div class="trip-container">
                        <img class="trip-image" <?php echo "src=\"/333Project/" . $imagePath . "\"" ?> alt="">
                        <div class="trip-info">
                            <p class="info" style="color: #4056A1;"><?php echo $title ?></p>
                            <p class="info">From: <?php echo $from ?></p>
                            <p class="info">To: <?php echo $to ?></p>
                            <p class="info" style="color: #F13C20;"> <?php echo $price . " BHD" ?></p>
                            <?php
                            // for the feedback
                            if ($feedback == null and $status != 0) {
                            ?>
                                <a <?php echo "href='feedback.php?tid=$id'" ?> class="butn primary-butn" style="text-align: center;margin-right: 1.5em;">Rate Us Now!</a>
                            <?php
                            } else if ($feedback != null) {
                                $count = 5;
                                $counter = 0;
                                echo "<div class='stars-history'>";
                                for ($i = 0; $i < $numOfStars; $i++) {
                                    echo '<span class="fa fa-star checked"></span>';
                                    $counter++;
                                }

                                while ($counter < $count) {
                                    echo '<span class="fa fa-star"></span>';
                                    $counter++;
                                }
                                echo "</div>";
                            } else { ?>


                                <p class="info">See You On-Time! :)</p>

                            <?php
                            }
                            ?>
                        </div>
                    </div>




                <?php
                }
                ?>


            <?php
            }

            if ($rows->rowCount() == 0) {
            ?>
                <div class="trip-container">
                    <div class="trip-info">
                        <p class="info" style="color: #F13C20; text-align: center;">You Have No Past Reservations :(</p>
                    </div>
                </div>


            <?php
            }
            ?>



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