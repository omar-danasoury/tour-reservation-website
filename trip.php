<?php

/**
 * OMAR AHMED REFAAT ELDANASOURY, 202005808
 * ITCS333-SEC 03 , COURSE PROJECT, ALONE
 */
session_start(); // for the header
// here we get show the information of the trip
global $avg;
$avg = 0;

global $total;
$total = 0;

global $customers;
$customers = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Name</title>

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

    <?php
    require("header.php");
    // then we get the trip date again:

    try {
        $tid = $_GET["tid"];
        require("connection.php");
        $rows = $db->query("SELECT * FROM TRIPS WHERE TRIPID = $tid");
    } catch (PDOException $ex) {
        echo "Error: " . $ex->getMessage();
    }


    ?>


    <main class="trip-view-main" style="background-color: white; background-image: none; text-align: left;">
        <div class="trips-main">
            <!-- Here this is one card -->

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
                        <a <?php echo "href='payment.php?tid=$id'" ?> class="butn primary-butn">Reserve Now!</a>
                    </div>
                </div>





            <?php
            }
            ?>

        </div>
    </main>

    <div class="location">
        <h3 style="text-align: center; padding: 1em; color: #4056A1;">Location</h3>
        <section class="section">

            <?php echo $location ?>
        </section>
    </div>


    <div class="reviews">
        <h3 style="color: #EFE2BA;">Reviews</h3>
        <section class="section feedback">


            <?php
            try {
                require("connection.php");
                $reservationRows = $db->query("SELECT FEEDBACK, NUMOFSTARS, USERID FROM RESERVATIONS WHERE TRIPID = $tid");
            } catch (PDOException $ex) {
                echo "Error: " . $ex->getMessage();
            }

            while ($resRow = $reservationRows->fetch()) {
                $usrId = $resRow[2];
                $rows = $db->query("SELECT USERNAME, PROFILEPHOTOPATH FROM USERS WHERE USERID = $usrId");
                $name = $rows->fetch()[0];
                $photoPath = "";
                $photoPath = $rows->fetch()[1] ?? '/uploads/default-avatar.jpg';
                $feedbackText = $resRow[0];
                $stars = $resRow[1];

                $noFeedback = false;
                if ($stars == 0) {
                    $noFeedback = true;
                    continue;
                } else {
                    $total += $stars;
                    $customers++;
                }
            ?>
                <div class="icons-sec1">
                    <img class="reviewer" <?php echo "src=\"/333Project/" . $photoPath . "\"" ?> alt="">
                    <h2 class="name"><?php echo $name ?></h2>
                    <?php
                    $count = 5;
                    $counter = 0;
                    while ($counter < $stars and !$noFeedback) {
                        echo '<span class="fa fa-star checked"></span>';
                        $counter++;
                    }

                    while ($counter < $count and !$noFeedback) {
                        echo '<span class="fa fa-star"></span>';
                        $counter++;
                    }
                    // echo "</div>";
                    ?>
                    <p class="light-font300 italic">"<?php echo $feedbackText ?>"
                    </p>
                </div>




            <?php
            }



            if ($total == 0) {
                echo "<p class='light-font300 italic'>Unfortunately, there is avaiable reviews at the moment!</p>";
            } else {
                $avg = $total / $customers;
            }
            ?>


        </section>
        <p style="color: #EFE2BA; font-weight: 600; font-size: 1.5em; color: #4056A1;">Average Reviews: <?php echo $avg ?></p>
        <!-- then the number of starts -->
    </div>




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