<?php
    require_once('../includes/dbh.inc.php');
    require_once('../includes/functions.inc.php');
    session_start();

    if(isset($_POST['addfriends'])){
        $input = $_POST['addfriends'];
        $uid = $_SESSION['userid'];

        $dataFriends = "SELECT * FROM gebruiker WHERE Username LIKE '{$input}%' AND NOT Id = ".$uid."";
        $result = mysqli_query($conn, $dataFriends);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $friendsname = $row['Username'];
                $profileImg = $row['profileImg'];
                $friendId = $row['Id'];
                $friendLevel = $row['level'];
                $friendBio = $row['Bio'];
                $friendDate = $row['onlineDate'];
                $date = $row['onlineDate'];
                $_SESSION['friendnumber'] = mysqli_num_rows($result);
                if ($friendBio == ""){
                    $friendBio = "i don't have a bio yet";
                }
                ?>
                <form action="?friendProfile" method="post">
                <button type="submit" name="friendsBtn">
                <div class="row-friendz-child">
                <img src="<?php if($profileImg == ""){echo "../docs/emptyInput.png";}else{echo $profileImg;} ?>">
                <div><h1><?php echo $friendsname?></h1><p>Last Online: <?php echo $date ?></p></div></div></button>
                <input type="hidden" name="friendPageId" value="<?php echo $friendId?>">
                <input type="hidden" name="friendPageName" value="<?php echo $friendsname?>">
                <input type="hidden" name="friendPageLevel" value="<?php echo $friendLevel?>">
                <input type="hidden" name="friendPageBio" value="<?php echo $friendBio?>">
                <input type="hidden" name="friendPageDate" value="<?php echo $friendDate?>">
                <input type="hidden" name="friendPageImg" value="<?php echo $profileImg?>">
                </form>
                <?php
            }
        }else{
            echo "no friends found";
        }
    }
    if(isset($_POST['searchFriendz'])){

        $friendz = $_POST['searchFriendz'];
        $uid = $_SESSION['userid'];

        $dataFriend = "SELECT * FROM gebruiker, friends WHERE Username LIKE '%{$friendz}%' AND senderId = ".$uid." AND friends.receiverId = gebruiker.Id AND status = 'FRIENDS'
        OR Username LIKE '%{$friendz}%' AND receiverId = ".$uid." AND friends.senderId = gebruiker.Id AND status = 'FRIENDS';";
        $result = mysqli_query($conn, $dataFriend);
        
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $friendsname = $row['Username'];
                $profileImg = $row['profileImg'];
                $friendId = $row['Id'];
                $friendLevel = $row['level'];
                $friendBio = $row['Bio'];
                $friendDate = $row['onlineDate'];
                $date = $row['onlineDate'];
                $_SESSION['friendnumber'] = mysqli_num_rows($result);
                if ($friendBio == ""){
                    $friendBio = "i don't have a bio yet";
                }
                ?>
                <form action="?friendProfile" method="post">
                <button type="submit" name="friendsBtn">
                <div class="row-friendz-child">
                <img src="<?php if($profileImg == ""){echo "../docs/emptyInput.png";}else{echo $profileImg;} ?>">
                <div><h1><?php echo $friendsname?></h1><p>Last Online: <?php echo $date ?></p></div></div></button>
                <input type="hidden" name="friendPageId" value="<?php echo $friendId?>">
                <input type="hidden" name="friendPageName" value="<?php echo $friendsname?>">
                <input type="hidden" name="friendPageLevel" value="<?php echo $friendLevel?>">
                <input type="hidden" name="friendPageBio" value="<?php echo $friendBio?>">
                <input type="hidden" name="friendPageDate" value="<?php echo $friendDate?>">
                <input type="hidden" name="friendPageImg" value="<?php echo $profileImg?>">
                </form>
                <?php
            }
        }else{
            echo "no friends found";
        }
    }
    if(isset($_POST['friendrequestSender'])){
        $friendsId = $_POST['friendrequestReceiver'];
        $userId = $_POST['friendrequestSender'];
        $status = "PENDING";
        $queryFriends = "SELECT * FROM friends WHERE senderId = $userId AND receiverId = $friendsId AND status = 'FRIENDS' OR receiverId = $userId AND senderId = $friendsId AND status = 'FRIENDS'";
        $queryPending = "SELECT * FROM friends WHERE senderId = $userId AND receiverId = $friendsId AND status = 'PENDING' OR receiverId = $userId AND senderId = $friendsId AND status = 'PENDING'";
        $resultFriends = mysqli_query($conn, $queryFriends);
        $resultPending = mysqli_query($conn, $queryPending);
        if(mysqli_num_rows($resultFriends) > 0){
            header("location: ../User/friendz.php?friendProfile&alreadyfriends");
        }elseif(mysqli_num_rows($resultPending) > 0){
            header("location: ../User/friendz.php?friendProfile&alreadypending");
        }else{
            $addFriend = "INSERT INTO friends (senderId, receiverId, status) VALUES (?, ?, ?);";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $addFriend)) {
                header('location: ../User/signup.php?error=stmtfailed');
                exit();
            }
        
            mysqli_stmt_bind_param($stmt, "sss", $userId, $friendsId, $status);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("location: ../User/friendz.php?friendProfile&alreadysend");
            exit();
        }
    }
    if(isset($_POST['friendDeleteSender'])){
        $friendId = $_POST['friendDeleteReceiver'];
        $uid = $_POST['friendDeleteSender'];
        $queryFriends = "SELECT * FROM friends WHERE senderId = $uid AND receiverId = $friendId AND status = 'FRIENDS' OR receiverId = $uid AND senderId = $friendId AND status = 'FRIENDS';";
        $resultFriends = mysqli_query($conn, $queryFriends);
        if(mysqli_num_rows($resultFriends) == 0){
            header("location: ../User/friendz.php?friendProfile&notfriends");
        }else{
            mysqli_query($conn, "DELETE FROM friends WHERE senderId = $uid AND receiverId = $friendId AND status = 'FRIENDS'  OR receiverId = $uid AND senderId = $friendId AND status = 'FRIENDS';");
            header("location: ../User/friendz.php?friendz");
        }
    }
    if(isset($_POST['acceptRequest'])){
        $friendId = $_POST['acceptRequest'];
        $uid = $_SESSION['userid'];
        mysqli_query($conn, "UPDATE friends SET status = 'FRIENDS' WHERE senderId = $friendId AND receiverId = $uid;");
        header("location: ../User/friendz.php?friendz");
    }
    if(isset($_POST['rejectRequest'])){
        $friendId = $_POST['rejectRequest'];
        $uid = $_SESSION['userid'];
        mysqli_query($conn, "DELETE FROM friends WHERE senderId = $friendId AND receiverId = $uid;");
        header("location: ../User/friendz.php?friendz");
    }

    

    if(isset($_POST['changePic'])){
        if(isset($_FILES['changePicFile'])){
            if (UPLOAD_ERR_OK === $_FILES["changePicFile"]["error"]){
                $src = $_FILES['changePicFile']['tmp_name'];
                $imgName = uniqid() . $_FILES['changePicFile']['name'];
                $target = "../profilePics/" . $imgName;
                $uid = $_SESSION['userid'];
                
                move_uploaded_file($src, $target);
                $q = "UPDATE gebruiker SET profileImg = '../profilePics/$imgName' WHERE Id = $uid";
                $_SESSION['profilePic'] = "../profilePics/$imgName";
                mysqli_query($conn, $q);
                header("location: ../User/friendz.php?friendz");
            }
        }
        if(!isset($_FILES)){
            echo "not uploaded";
        }
        // header("location: ../User/friendz.php?friendz&notuploaded");
    }
    //QUICK DISCOVER REMINDER
    if(isset($_POST['searchgames'])){

        $Sgames = $_POST['searchgames'];

        $dataGames = "SELECT * FROM games WHERE naam LIKE '%{$Sgames}%' OR genre LIKE '%{$Sgames}%' OR Company LIKE '%{$Sgames}%';";
        $result = mysqli_query($conn, $dataGames);
    
        while($row = mysqli_fetch_assoc($result)){
            if (mysqli_num_rows($result)>0){
                filterRows($row['image'],$row['naam'],$row['prijs'],$row['Id']);
        }else{
            echo "No games found";
        }
    }
    }

    if(isset($_POST['changeBio'])){
        $newbio = $_POST['newbio'];
        $uid = $_SESSION['userid'];

        $upd = "UPDATE gebruiker SET Bio = '$newbio' WHERE Id = $uid;";
        mysqli_query($conn, $upd);
        header("location: ../User/friendz.php?mypage");
        $_SESSION['bio'] = $newbio;
    }
    if(isset($_POST['changeUsern'])){
        $uid = $_SESSION['userid'];
        $username = $_SESSION['user'];
        $oldUser = $_POST['oldU'];
        $newUser = $_POST['newU'];
        if ($username == $oldUser){
            $upd = "UPDATE gebruiker SET Username = '$newUser' WHERE Id = $uid;";
            mysqli_query($conn, $upd);
            header("location: ../User/friendz.php?mypage");
            $_SESSION['user'] = $newUser;
        }else{
            header("location: ../User/friendz.php?mypage");
        }
    }
    if(isset($_POST['changeEmail'])){
        $uid = $_SESSION['userid'];
        $email = $_SESSION['email'];
        $oldE = $_POST['oldE'];
        $newE = $_POST['newE'];
        if ($email == $oldE){
            $upd = "UPDATE gebruiker SET Email = '$newE' WHERE Id = $uid;";
            mysqli_query($conn, $upd);
            header("location: ../User/friendz.php?mypage");
            $_SESSION['email'] = $newE;
        }else{
            header("location: ../User/friendz.php?mypage");
        }
    }
    if(isset($_POST['changePwd'])){
        $newbio = $_POST['newbio'];
        $uid = $_SESSION['userid'];

        $upd = "UPDATE gebruiker SET Bio = '$newbio' WHERE Id = $uid;";
        mysqli_query($conn, $upd);
        header("location: ../User/friendz.php?mypage");
        $_SESSION['bio'] = $newbio;
    }
