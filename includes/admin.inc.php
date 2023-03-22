<?php

require_once('dbh.inc.php');
require_once('functions.inc.php');

if (isset($_POST['addGame'])){
    //MAKING A GAME
    function createGame($conn, $naam, $prijs, $gameDiscount, $gameImage, $gameLogo, $gameVideo, $gameGenre, $gamePegi, $gamePegiImg, $gameState, $gameInfo, $gameCompany, $gameRating, $gameRelease, $gamePlatform) {
        $sql = "INSERT INTO games (naam, prijs, image, genre, Company, State, info, prijs2, image2, video, rating, pegName, pegImg, platform) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('location: ../User/signup.php?error=stmtfailed');
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ssssssssssssss", $naam, $prijs, $gameImage, $gameGenre, $gameCompany, $gameState, $gameInfo, $gameDiscount, $gameLogo, $gameVideo, $gameRating, $gamePegi, $gamePegiImg, $gamePlatform);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header('location: ../admin.php');
        exit();
    }

    $gameName = $_POST['gamename'];
    $gamePrice = $_POST['gameprice'];
    $gameDiscount = $_POST['gameprice2'];
    $gameImage = $_POST['gameimage'];
    $gameLogo = $_POST['gameimage2'];
    $gameVideo = $_POST['gamevideo'];
    $gameGenre = $_POST['gamegenre'];
    $gamePegi = $_POST['gamepegname'];
    $gamePegiImg = $_POST['gamepegimg'];
    $gameState = $_POST['gamestate'];
    $gameInfo = $_POST['gameinfo'];
    $gameCompany = $_POST['gamecompany'];
    $gameRating = $_POST['gamerating'];
    $gameRelease = $_POST['gamerelease'];
    $gamePlatform = $_POST['gameplatform'];

    print_r($gameRelease);
    createGame($conn, $gameName, $gamePrice, $gameDiscount, $gameImage, $gameLogo, $gameVideo, $gameGenre, $gamePegi, $gamePegiImg, $gameState, $gameInfo, $gameCompany, $gameRating, $gameRelease, $gamePlatform);
}
else
{
    header("location: ../admin.php");
    echo "something went wrong";
    exit();
}
if (isset($_POST['unban'])){
    $user = $_POST['unbanInp'];

    createUnban($conn, $user);
}else{
    header("location: ../admin.php");
    echo "something went wrong";
    exit();
}