<?php

/**
 * OMAR AHMED REFAAT ELDANASOURY, 202005808
 * ITCS333-SEC 03 , COURSE PROJECT, ALONE
 */
function checkInput($input)
{
    return htmlspecialchars(stripslashes(trim($input)));
}
