<?php
    require_once('dbh.inc.php');
    require_once('functions.inc.php');

    if(isset($_POST['BannedFromComplain'])){
        $banId = $_POST['userBanId'];
        $klacht = $_POST['klacht'];
        $banName = $_POST['userName'];
        $time = $_POST['userTime'];

        createReview($conn, $banId, $klacht, $banName, "BANNED", "", $time, "", "../error.php?type=bannedFromKlacht");
    }
    if(isset($_POST['givefbb'])){
        $review = $_POST['givefbl'];
        $name = $_POST['givefbn'];
        $id = $_POST['givefbi'];
        $time = $_POST['givefbd'];
        $profilep = $_POST['givefbpp'];

        createReview($conn, $id, "", $name, "MESSAGE", $review, $time, $profilep,"../User/profile.php?setting=feedback&sended");
    }