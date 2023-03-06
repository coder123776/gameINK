<?php

$serverName = 'localhost';
$dBUsername = 'root';
$dBPassword = "";
$dBName = "project3";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if(!$conn) {
    die("Connnection failed: " . mysqli_connect_error());
}
//Admins
$admin1 = 123457;
$admin2 = 123458;
$admin3 = 15;
$admin4 = 19;

//Codes
$reedemcode1 = "LanaRhoades";
$reedemcode2 = "MiaKhalifa";
$reedemcode3 = "jhohnnysins";
