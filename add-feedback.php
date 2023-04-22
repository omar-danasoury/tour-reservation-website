<?php

/**
 * OMAR AHMED REFAAT ELDANASOURY, 202005808
 * ITCS333-SEC 03 , COURSE PROJECT, ALONE
 */


try {
    require("functions.php");
    $feedback = $_POST["rate"];
    $words = checkInput($_POST["words"]);
    $tid = $_GET["tid"];
    require("connection.php");
    $db->beginTransaction();
    $statement = $db->prepare("UPDATE RESERVATIONS SET FEEDBACK = ?, NUMOFSTARS = ? WHERE TRIPID = ?");
    $statement->execute(array($words, $feedback, $tid));
    if ($statement->rowCount() == 1) {
        $db->commit();
        header("location: history.php");
    } else {
        $db->rollBack();
        header("location: history.php?feedback=failed");
    }
} catch (PDOException $ex) {
    $db->rollBack();
    echo "Error: " . $ex->getMessage();
}

$db = null;
