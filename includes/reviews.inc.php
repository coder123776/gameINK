<?php
    require_once('dbh.inc.php');
    require_once('functions.inc.php');
    session_start();

    if(isset($_POST['BannedFromComplain'])){
        $banId = $_POST['userBanId'];
        $klacht = $_POST['klacht'];
        $banName = $_POST['userName'];
        $time = $_POST['userTime'];
        $profilep = $_SESSION['profilePic'];

        createReview($conn, $banId, $klacht, $banName, "BANNED", $klacht, $time, $profilep, "../error.php?type=bannedFromKlacht");
    }
    if(isset($_POST['givefbb'])){
        $review = $_POST['givefbl'];
        $name = $_POST['givefbn'];
        $id = $_POST['givefbi'];
        $time = $_POST['givefbd'];
        $profilep = $_POST['givefbpp'];
        $uid = $_SESSION['userid'];

        $sql = "SELECT * FROM review WHERE uid = $uid";
        $checkIfmsgExist = mysqli_query($conn, $sql);
        if (mysqli_num_rows($checkIfmsgExist) > 0){
            $sql = "UPDATE review SET Username = '$name', review = '$review', time = '$time', userimg = '$profilep' WHERE uid = $uid";
            mysqli_query($conn, $sql);
            header('location: ../User/profile.php?setting=feedback&sended');
        }else{
            createReview($conn, $id, $review, $name, "MESSAGE", $review, $time, $profilep,"../User/profile.php?setting=feedback&sended");
        }
    }