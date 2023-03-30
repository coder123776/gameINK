<?php
session_start();
$_SESSION['fileType'] = 2;
include_once('../includes/dbh.inc.php');
include_once('../head-footer/header.php');
include_once('../includes/functions.inc.php');
if(!isset($_SESSION['userid'])) {
    header("location: ../User/login.php?error=loginfirst");
}else{
    CheckIfBanned($conn, $uid, 1); SetBudget($conn, $uid); CheckLastTimeOnline($conn, $uid); CheckWhereLiving($conn, $uid);
}
?>
<title>Your Friends at GameINK</title>
<!-- settings -->
<form action="../includes/search.inc.php" method="post" enctype="multipart/form-data"><div id="picparent1" class="pic-parentt">
<div class="change-pic-parent">
    <i onclick="showProfilepic(1)" class="fa fa-close"></i>
    <textarea name="newbio" id="nbio" cols="30" rows="10" value="" maxlength="400" placeholder="type in your bio...."></textarea>
    <div class="extraLaag1"></div>
    <button class="nbio" type="submit" name="changeBio">Verstuur</button>
</div></div></form>
<!-- picture -->
<form action="../includes/search.inc.php" method="post" enctype="multipart/form-data"><div id="picparent2" class="pic-parentt">
<div class="change-pic-parent">
    <i onclick="showProfilepic(2)" class="fa fa-close"></i>
    <img id="pic-child" src="<?php if($profilePic == ""){echo "../docs/emptyInput.png";}else{echo $profilePic;} ?>"> 
    <div class="change-pic-child">
        <input type="file" name="changePicFile" id="changePic" accept="image/*">
        <label class="changePic far" for="changePic">&#xf03e; Choose a picture</label>
        <button class="nbio" type="submit" name="changePic">Upload Image</button>
</div></div></div></form>
<!-- username -->
<form action="../includes/search.inc.php" method="post"><div id="picparent3" class="pic-parentt">
<div class="change-pic-parent">
    <i onclick="showProfilepic(3)" class="fa fa-close"></i>
        <label for="oldU">type in your old username</label>
        <input id="change-inp" name="oldU" type="text" placeholder="old username...">
        <label for="newU">type in your new username</label>
        <input id="change-inp" name="newU" type="text" placeholder="new username...">
        <button class="nbio" type="submit" name="changeUsern">Change Username</button>
</div></div></form>
<!-- email -->
<form action="../includes/search.inc.php" method="post"><div id="picparent4" class="pic-parentt">
<div class="change-pic-parent">
    <i onclick="showProfilepic(4)" class="fa fa-close"></i>
        <label for="oldU">type in your old email</label>
        <input id="change-inp" name="oldE" type="text" placeholder="old email...">
        <label for="newU">type in your new email</label>
        <input id="change-inp" name="newE" type="text" placeholder="new email...">
        <button class="nbio" type="submit" name="changeEmail">Change email</button>
</div></div></form>
<!-- password -->
<form action="../includes/search.inc.php" method="post"><div id="picparent5" class="pic-parentt">
<div class="change-pic-parent">
    <i onclick="showProfilepic(5)" class="fa fa-close"></i>
        <label for="oldU">type in your old Password</label>
        <input id="change-inp" name="oldPw" type="text" placeholder="old password...">
        <label for="newU">type in your new Password</label>
        <input id="change-inp" name="newPw" type="text" placeholder="new password...">
        <button class="nbio" type="submit" name="changePwd">Change Password</button>
</div></div></form>


<section class="friends-parent">
    <div class="friends-parent-head">
        <img onclick="showProfilepic()" class="userPic" src="<?php if($profilePic == ""){echo "../docs/emptyInput.png";}else{echo $profilePic;} ?>">
        <h1><?php echo $username ?></h1>
    </div>
    <div class="friends-parent">
        <nav class="friends-parent">
            <form action="?friendz" method="post"><button type="submit" name="myfriends" id="your friends" class='fas'><div>&#xf4fc;</div><div><h3>Your Friends</h3></div></button></form>
            <form action="?add" method="post"><button type="submit" name="addfriends" id="your friends" class='fas'><div>&#xf234;</div><div><h3>Add Friends</h3></div></button></form>
            <form action="?request" method="post"><button type="submit" name="reqfriends" id="your friends" class='fas'><div>&#xf0e0;</div><div><h3>Friend Request</h3></div></button></form>
            <form action="?messages" method="post"><button type="submit" name="messages" id="your friends" class='fa'><div>&#xf086;</div><div><h3>Messages</h3></div></button></form>
            <form action="?mypage" method="post"><button type="submit" name="mypage" id="your friends" class='fa'><div>&#xf406;</div><div><h3>My Page</h3></div></button></form>
            <hr id="friend-hr">
        </nav>

        <?php
        // if (isset($_GET['notuploaded'])){
        //     echo "<script>alert('you didn\'t put a file before uploading or got a error'); </script>";
        // }
        if(isset($_GET['friendProfile'])){
            if(isset($_POST['friendsBtn'])){
                $friendId = $_POST['friendPageId'];
                $friendsname = $_POST['friendPageName'];
                $friendLevel = $_POST['friendPageLevel'];
                $friendImg = $_POST['friendPageImg'];
                $friendBio = $_POST['friendPageBio'];
                $friendDate = $_POST['friendPageDate'];

                $_SESSION['friendId'] = $friendId;
                $_SESSION['friendsname'] = $friendsname;
                $_SESSION['friendLevel'] = $friendLevel;
                $_SESSION['friendImg'] = $friendImg;
                $_SESSION['friendBio'] = $friendBio;
                $_SESSION['friendDate'] = $friendDate;
                ShowFriendPage($conn, $friendsname, $friendLevel, $friendImg, $friendBio, $uid, $friendId);
            }
            elseif(isset($_GET['alreadyfriends']) || isset($_GET['alreadypending']) || isset($_GET['alreadysend'])){
                $friendId = $_SESSION['friendId'];
                $friendsname = $_SESSION['friendsname'];
                $friendLevel = $_SESSION['friendLevel'];
                $friendImg = $_SESSION['friendImg'];
                $friendBio = $_SESSION['friendBio'];
                $friendDate = $_SESSION['friendDate'];
                ShowFriendPage($conn, $friendsname, $friendLevel, $friendImg, $friendBio, $uid, $friendId);
            }
            elseif(isset($_SESSION['friendId']) && isset($_SESSION['friendsname']) && isset($_SESSION['friendLevel']) && isset($_SESSION['friendImg']) && isset($_SESSION['friendBio']) &&isset($_SESSION['friendDate'])){
                $friendId = $_SESSION['friendId'];
                $friendsname = $_SESSION['friendsname'];
                $friendLevel = $_SESSION['friendLevel'];
                $friendImg = $_SESSION['friendImg'];
                $friendBio = $_SESSION['friendBio'];
                $friendDate = $_SESSION['friendDate'];
                ShowFriendPage($conn, $friendsname, $friendLevel, $friendImg, $friendBio, $uid, $friendId);
            }
        }
        if(isset($_GET['mypage'])){
            $friendId = $uid;
            $friendsname = $username;
            $friendLevel = $userlevel;
            $friendImg = $profilePic;
            $friendBio = $userBio;
            $friendDate = $userOnlineDate;
            ShowFriendPage($conn, $friendsname, $friendLevel, $friendImg, $friendBio, $uid, $friendId);
        }
        if(isset($_GET['friendz'])){
            if(isset($_SESSION['friendnumber'])){
                $friendcount = $_SESSION['friendnumber'];
            }
        ?>

            <div class="rows-friends">
                <nav>
                    <h1>Your Friends <?php
                    if(isset($_SESSION['friendnumber'])){
                        echo $friendcount. " / 200";
                    }else{
                        echo "0 / 200";
                    }
                    ?></h1>
                    <button onclick="gotoadd()" type="submit" name="addfriends" class="fas"> &#xf234; <h1>Add Friends</h1></button>
                    <script>function gotoadd() {window.location.href = "?add"}</script>
                </nav>
                <input id="inputFriend" type="text" name="searchfriends" placeholder="search your friends">
                <div id="friendsz" class="row-friendz">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
                <script type="text/javascript">
                        $(document).ready(function(){
                        $("#inputFriend").keyup(function(){
                        var input = $(this).val();
                        // alert(input);
                        if(input != ""){
                        $.ajax({
                                url:"../includes/search.inc.php", method:"post", data:{searchFriendz:input},
                                success:function(data){ $("#friendsz").html(data); $("#friendsz").css("display", "flex");
                        }});}});});
                </script>
                    <?php
                    getFriends($conn, $uid, 1);
                    ?>
                </div>
            </div>
        <?php
        }
        if(isset($_GET['add'])){
        ?>
            <div class="rows-friends">
                <nav>
                    <h1>Add Friends</h1>
                </nav>
                <input type="text" class="form-control" id="live_search" autocomplete="off" placeholder="search...">
                <div id="searchresult" class="row-friendz">
                </div>
            </div>
        <?php
        }
        if(isset($_GET['request'])){
            function makeReqCard($friendimg, $friendname, $friendId){
            ?>
            <div class="row-friendz-child"><img src="<?php if($friendimg == ""){echo "../docs/emptyInput.png";}else{echo $friendimg;} ?>"><div><h1><?php echo $friendname?></h1>
                <div>
                    <form id="acceptRequest" action="../includes/search.inc.php" method="post"><i onclick="submit('acceptRequest')" id="fasfacheck" class="fa fa-check"></i><input type="hidden" name="acceptRequest" value="<?php echo $friendId?>"></form>
                    <form id="rejectRequest" action="../includes/search.inc.php" method="post"><i onclick="submit('rejectRequest')" id="fasfaclose" class="fa fa-close"></i><input type="hidden" name="rejectRequest" value="<?php echo $friendId?>"></form>
                </div>
                </div>
            </div>
                <script>
                function submit(id){
                    let form = document.getElementById(id);
                    form.submit();
                    }
                </script>
            <?php
            }
        ?>
        <?php
        ?>
            <div class="rows-friends">
                <nav>
                    <h1>Friends Request</h1>
                </nav>
                <div class="row-friendz">
                <input type="text" name="addfriends" placeholder="search for friend requests">
                    <div class="row-friendz">
                        <?php 
                        $uid = $_SESSION['userid'];
                        $queryF = "SELECT * FROM friends WHERE receiverId = $uid AND status = 'PENDING';";
                        $resultF = mysqli_query($conn, $queryF);
                        if (mysqli_num_rows($resultF) > 0){
                            while ($row = mysqli_fetch_assoc($resultF)){
                                $FId = $row['senderId'];
                                $queryF2 = "SELECT * FROM gebruiker WHERE Id = $FId";
                                $resultF2 = mysqli_query($conn, $queryF2);
                                if ($row2 = mysqli_fetch_assoc($resultF2)){
                                    $FImg = $row2['profileImg'];
                                    $FName = $row2['Username'];
                                    $FId = $row2['Id'];
                                    makeReqCard($FImg, $FName, $FId);
                                }
                            }
                        }else{
                            echo "<h1>You have no friend requests yet</h1>";
                        }
                        ?>
                    </div>
                    </div>
                </div>
            </div>
        <?php
        }
        if(isset($_GET['messages'])){?>
        <div class="messages-parent">
        <div class="messages-nav">
            <form action="?messages" method="post"><button id="messages-nav-child" type="submit" name="getBotChat">
            <div class="messages-nav-child"><img src="../profilePics/6404b87c90d4ctester.png"><h1 id="date"><?php echo date("H:i") ?></h1>
            <div class="messages-nav-inf"><h1>INKbot</h1><p>hey i am INKbot and can help you with anything</p></div>
            <input type="hidden" name="friendPageId" value="123">
            <input type="hidden" name="friendPageName" value="INKbot">
            <input type="hidden" name="friendPageLevel" value="GOD">
            <input type="hidden" name="friendPageDate" value="<?php echo date("H:i")?>">
            <input type="hidden" name="friendPageImg" value="../profilePics/6404b87c90d4ctester.png">
            </div></button>
            <hr id="messages-nav">
            <?php
            getFriends($conn, $uid, 2);
            ?>
        </div>
        <div class="messages-body-line"></div>
        <div class="messages-body">
            <?php
            if(isset($_POST['getFriendsMessages'])){
                $friendId = $_POST['friendPageId'];
                $_SESSION['liveFriend'] = $friendId;
                $friendsname = $_POST['friendPageName'];
                $friendImg = $_POST['friendPageImg'];
                ShowMessages($conn, $uid, $friendId, $friendImg, $friendsname);
            }
            if(isset($_POST['getBotChat'])){
                getBotChats();
            }

            if(isset($_POST['messageTouser'])){
                $msg = $_POST['messageTouser'];
                $friendId = $_POST['friendId'];
                $time = $_POST['currTime'];
                if ($msg == ""){
                    header('location: ?');
                }else{
                    $sql = "INSERT INTO chat (ChatSender, ChatReceiver, message, time) VALUES (?, ?, ?, ?);";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header('location: ../error.php?error=stmtfailed');
                        exit();
                    }
                    mysqli_stmt_bind_param($stmt, "ssss", $uid, $friendId, $msg, $time);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                    exit();
                }
            }
            ?>
        </div>
        </div>
        <?php
        }
        ?>
    
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#live_search").keyup(function(){
                var input = $(this).val();
                // alert(input);
                if(input != ""){
                    $.ajax({
                        url:"../includes/search.inc.php",
                        method:"post",
                        data:{addfriends:input},

                        success:function(data){
                            $("#searchresult").html(data);
                            $("#searchresult").css("display", "flex");
                        }
                    });
                }else{
                    $("#searchresult").css("display", "none");
                }
            });
        });
    </script>
</section>

<?php
include_once('../head-footer/footer.php');

if (isset($_GET['passwordfalse'])){
    echo "<script>alert('password does not match')</script>";
}
if (isset($_GET['usernamedoesnotmatch'])){
    echo "<script>alert('username does not match')</script>";
}
if (isset($_GET['emaildontmatch'])){
    echo "<script>alert('email does not match')</script>";
}
if (isset($_GET[''])){
    echo "<script>alert('')</script>";
}
?>