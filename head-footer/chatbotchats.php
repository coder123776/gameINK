<?php
include_once('../includes/dbh.inc.php');
include_once('../includes/functions.inc.php');
session_start();

if(isset($_POST['getchats'])){
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
if(isset($_POST['getchats2'])){
    $uid = $_SESSION['userid'];
    $searchRespo = "SELECT * FROM inkbotchats WHERE userId = $uid;";
    $searchReslut = mysqli_query($conn, $searchRespo);
    while ($row = mysqli_fetch_assoc($searchReslut)){
        $userSend = $row['userSender'];
        $Replay = $row['chatbotReplay'];
        $userid = $row['userId'];
        if ($uid == $userid){
            INKbotMsg2($userSend, $Replay);
        }
    }
}
if(isset($_POST['getfriendchats'])){
    $uid = $_SESSION['userid'];
    $friendId = $_SESSION['liveFriend'];
    $searchChat = "SELECT * FROM chat WHERE $uid = ChatSender AND $friendId = ChatReceiver OR  $uid = ChatReceiver AND $friendId = ChatSender ORDER BY chat.Id ASC;";
    $chat = mysqli_query($conn, $searchChat);
    while ($row = mysqli_fetch_assoc($chat)){
        $sender = $row['ChatSender'];
        $receiver = $row['ChatReceiver'];
        $msg = $row['message'];

        if ($uid == $sender){
            messageSender($msg);
        }elseif ($uid == $receiver){
            messageReceiver($msg);
        }
    }
}
