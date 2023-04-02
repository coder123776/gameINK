<?php

$serverName = 'localhost';
$dBUsername = 'root';
$dBPassword = "";
$dBName = "project3";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if(!$conn) {
    die("Connnection failed: " . mysqli_connect_error());
}

if(isset($_SESSION['userid'])) {
    $username = $_SESSION["user"];
    $email = $_SESSION["email"];
    $uid = $_SESSION["userid"];
    $name = $_SESSION['name'];
    $profilePic = $_SESSION['profilePic'];
    $userBio = $_SESSION['bio'];
    $userlevel = $_SESSION['level'];
    $userOnlineDate = $_SESSION['onlinedate'];
    $userland = $_SESSION['land'];

$ModeratorSql = "SELECT * FROM moderator";
$result = mysqli_query($conn, $ModeratorSql);
$admins = array();
while ($admin = mysqli_fetch_assoc($result)){
    $admins[] = $admin['gebruikerId'];
}
$isadmin = false;
foreach ($admins as $admin){
    if ($admin == $uid){
        $isadmin = true;
        $_SESSION['isadmin'] = true;
    }
}
}
//Codes
$reedemcode1 = "LanaRhoades";
$reedemcode2 = "MiaKhalifa";
$reedemcode3 = "jhohnnysins";
$reedemcode4 = "amerencio";

