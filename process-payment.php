<?php

/**
 * OMAR AHMED REFAAT ELDANASOURY, 202005808
 * ITCS333-SEC 03 , COURSE PROJECT, ALONE
 */
session_start();

$tripId = $_GET["tid"];

try {
    require("connection.php");
    $sql = "INSERT INTO reservations VALUES (null, ?, ?, ?, ?, NOW(), null)";
    $db->beginTransaction();
    $statement = $db->prepare($sql);
    $userid = $_SESSION["activeUser"][0];
    $statement->execute(array($tripId, $userid, 0, null));

    if ($statement->rowCount() != 1) {
        header("location: home.php?reserved=false");
    } else {
        header("location: home.php?reserved=true");
    }
    $db->commit();
} catch (PDOException $e) {
    $db->rollBack();
    // header("location: home.php?reserved=notfalse");
    echo "Error: " . $e->getMessage();
}

$db = null;
