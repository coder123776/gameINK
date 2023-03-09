<?php
include_once('../includes/dbh.inc.php');
include_once('../includes/functions.inc.php');
session_start();

if(isset($_POST['getchats'])){
    echo "abcd";
    $uid = $_SESSION['userid'];
    $searchRespo = "SELECT * FROM inkbotchats WHERE userId = $uid;";
    $searchReslut = mysqli_query($conn, $searchRespo);
    while ($row = mysqli_fetch_assoc($searchReslut)){
        $userSend = $row['userSender'];
        $Replay = $row['chatbotReplay'];
        $userid = $row['userId'];
        if ($uid == $userid){
            INKbotMsg($userSend, $Replay);
        }
    }
}
