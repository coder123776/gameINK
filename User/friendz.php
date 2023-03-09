<?php
include_once('../includes/dbh.inc.php');
include_once('../head-footer/EXheader.php');
include_once('../includes/functions.inc.php');

if(!isset($_SESSION['userid'])) {
    header("location: ../User/login.php?error=loginfirst");
}else{
    CheckIfBanned($conn, $uid, 2);
    SetBudget($conn, $uid);
}
?>
<title>Your Friends at GameINK</title>
<form action="../includes/search.inc.php" method="post" enctype="multipart/form-data">
<div id="picparent" class="pic-parentt">
<div class="change-pic-parent">
    <i onclick="showProfilepic()" class="fa fa-close"></i>
    <img id="pic-child" src="<?php if($profilePic == ""){echo "../docs/emptyInput.png";}else{echo $profilePic;} ?>">
    <div class="change-pic-child">
        <input type="file" name="changePicFile" id="changePic" accept="image/*">
        <label class="changePic far" for="changePic">&#xf03e; Choose a picture</label>
        <button type="submit" name="changePic">Upload Image</button>
    </div>
</div>
</div>
</form>
<script>
        function showProfilepic() {
            document.getElementById("picparent").classList.toggle("pic-parent");
        }
</script>
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
            <form action="?groups" method="post"><button type="submit" name="groups" id="your friends" class='fa'><div>&#xf0c0;</div><div><h3>Groups</h3></div></button></form>
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
                ShowFriendPage($friendsname, $friendLevel, $friendImg, $friendBio, $uid, $friendId);
            }
            if(isset($_GET['alreadyfriends']) || isset($_GET['alreadypending']) || isset($_GET['alreadysend'])){
                $friendId = $_SESSION['friendId'];
                $friendsname = $_SESSION['friendsname'];
                $friendLevel = $_SESSION['friendLevel'];
                $friendImg = $_SESSION['friendImg'];
                $friendBio = $_SESSION['friendBio'];
                $friendDate = $_SESSION['friendDate'];
                ShowFriendPage($friendsname, $friendLevel, $friendImg, $friendBio, $uid, $friendId);
            }
        ?>
            <?php
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
            <?php
            getFriends($conn, $uid, 2);
            ?>
        </div>
        <div class="messages-body-line"></div>
        <div class="messages-body">
            <?php
            if(isset($_POST['getFriendsMessages'])){
                $friendId = $_POST['friendPageId'];
                $friendsname = $_POST['friendPageName'];
                $friendImg = $_POST['friendPageImg'];
                ShowMessages($conn, $uid, $friendId, $friendImg, $friendsname);
            }
            if(isset($_POST['messageTouser'])){
                $msg = $_POST['messageTouser'];
                $friendId = $_POST['friendId'];
                $time = $_POST['currTime'];

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
include_once '../head-footer/EXfooter.php';
?>