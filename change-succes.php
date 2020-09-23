<?php
//change-succes.php

session_start();

if (isset($_SESSION["email"])) {
    echo '<h3>Login Succes, Welcome - ' . $_SESSION["email"] . '</h3>';
    echo '<h3>Hier zou je normaal je wachtwoord aanpassen.</h3>';
    echo '<br><br><a href="logout.php">Eindig deze lege sessie.</a>';
} else {
    header("location:index.php");
}
