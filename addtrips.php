<?php

/**
 * OMAR AHMED REFAAT ELDANASOURY, 202005808
 * ITCS333-SEC 03 , COURSE PROJECT, ALONE
 */


if (isset($_POST["addTrip"])) {

    $name = $_POST["tname"];
    $start = $_POST["tstart"];
    $end = $_POST["tend"];
    $price = $_POST["tprice"];
    $location = $_POST["tlocation"];


    // here the input validation
    // if (empty($name) or empty($start) or empty($end) or empty($price) or empty($location) or empty($image)) {
    //     $db = null;
    //     header("location: addtrips.php?err=blanks");
    // }

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
            $sql = "INSERT INTO TRIPS VALUES (null, ?, ?, ?, ?, ?, ?)";
            $db->beginTransaction();
            $statement = $db->prepare($sql);
            $statement->execute(array($name, $start, $end, $price, $location, $finalPath));
            $db->commit();
        } catch (PDOException $e) {
            $db->rollBack();
            header("location: addtrips.php?success=false", true);
            echo "Error: " . $e->getMessage();
        }
    } else
        throw new PDOException("Error uploading the image!");

    if ($statement->rowCount() != 1) {
        throw new PDOException();
    }

    $db->commit();
    //     header("location: addNewEmployee.php?success=true", true);

} else {
    $msg = "";
    if (isset($_GET["err"]) and $_GET["err"] == "blanks")
        $msg = "<p style='color: red;'>All fields are required!</p>";
    else if (isset($_GET["success"]) and $_GET["success"] == "false")
        $msg = "<p style='color: red;'>Error While Adding Employee Or The Employee Already Exists!</p>";
    else if (isset($_GET["success"]) and $_GET["success"] == "true")
        $msg = "<p style='color: green;'>Employee Added Successfully!</p>";

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Trips</title>
    </head>

    <body>
        <h1>Add New Trip</h1>
        <form method="post" enctype="multipart/form-data">
            Trip Name: <input type="text" name="tname"><br><br>
            Start Time: <input type="datetime-local" name="tstart"><br><br>
            End Time: <input type="datetime-local" name="tend"><br><br>
            Price: <input type="text" name="tprice"><br><br>
            Trip Location: <input type="text" name="tlocation"><br><br>
            Trip Image: <input type="file" name="timg[]" multiple="multiple"><br><br>
            <input type="submit" name="addTrip" value="Add Trip">
        </form>
        <?php echo $msg ?>
    </body>

    </html>
<?php
}
?>