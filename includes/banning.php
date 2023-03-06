<?php
    require_once('dbh.inc.php');
    require_once('functions.inc.php');

    if(isset($_POST['BannedFromComplain'])){
        $banId = $_POST['userBanId'];
        $klacht = $_POST['klacht'];
        $banName = $_POST['userName'];

        createBan($conn, $banId, $klacht, $banName, "../error.php?type=bannedFromKlacht");
    }