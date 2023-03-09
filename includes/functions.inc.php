<?php
function emptyInputSignup($name, $username, $email, $pwd, $pwdRepeat) {
    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}
function invalidUid($username) {
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}
function invalidEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}
function pwdMatch($pwd, $pwdRepeat) {
    if ($pwd !== $pwdRepeat) {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}
function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM gebruiker WHERE Username = ? OR Email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../User/signup.php?error=stmtfailed');
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    if($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else{
        $result = false;
        return $result;
    }
}

function createUser($conn, $name, $username, $email, $pwd) {
    $sql = "INSERT INTO gebruiker (Name, Username, Email, Password) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../User/signup.php?error=stmtfailed');
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header('location: ../User/signup.php?error=none');
    exit();
}
function emptyInputLogin($username, $pwd) {
    if (empty($username) || empty($pwd)) {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}
function loginUser($conn, $username, $pwd) {
    $uidExists = uidExists($conn, $username, $username);
    if ($uidExists === false) {
        header('location: ../User/login.php?error=userexist');
        exit();
    }

    $pwdHashed = $uidExists["Password"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header('location: ../User/login.php?error=passwordincorrect');
        exit();
    }
    elseif ($checkPwd === true) {
        session_start();
        $_SESSION["userid"] = $uidExists["Id"];
        $_SESSION["user"] = $uidExists["Username"];
        $_SESSION['email'] = $uidExists['Email'];
        $_SESSION['name'] = $uidExists['Name'];
        $_SESSION['profilePic'] = $uidExists['profileImg'];
        header('location: ../index.php');
        exit();
    }
}




//HOME PAGE GAME RIJ
function GameDisplay($conn, $state, $displ){
    $MaxCards1 = 0;
    $MaxCards2 = 0;
    $MaxCards3 = 0;
    $MaxCards4 = 0;

    $result = getData($conn, "SELECT * FROM games WHERE State LIKE '%$state%' ORDER BY RAND();");
    while($row = mysqli_fetch_assoc($result)){
    if ($row['prijs'] == 0){
        $productPrice = "free";
    }
    else
    {
        $productPrice = "&#128178;".$row['prijs'];
    }
    if     ($displ == 1){
        if($MaxCards1 < 5){
        ?>
        <form method="post"><button name="add" id="addToCart"><div class="card card1">
        <img id="gameImage1" src="<?php echo $row['image']?>">
        <h1 id="gameName1"><?php echo $row['naam']?></h1>
        <h1 id="gamePrice1"><?php echo $productPrice?></h1>
        <input type="hidden" name="productId" value='<?php echo $row['Id']?>'></div></button></form>
        <?php
        $MaxCards1++;
        }
    }elseif($displ == 2){
        if($MaxCards2 < 3){
        ?>
        <form method="post"><button name="add" id="addToCart2"><div class="kaart">
        <img id="gameImage2" src="<?php echo $row['image']?>">
        <h1 id="gameName2"><?php echo $row['naam']?></h1>
        <p id="gameInf"><?php echo $row['info']?></p>
        <h1 id="gamePrice2"><?php echo $productPrice?></h1>
        <input type="hidden" name="productId" value='<?php echo $row['Id']?>'></div></button></form>
        <?php
        $MaxCards2++;
        }
    }elseif($displ == 3){
        if($MaxCards3 < 5){
        ?>
        <form method="post"><button name="add" id="addToCart"><div class="card card1">
        <img id="gameImage1" src="<?php echo $row['image']?>">
        <h1 id="gameName1"><?php echo $row['naam']?></h1>
        <h1 id="gamePrice1"><?php echo $productPrice?></h1>
        <input type="hidden" name="productId" value='<?php echo $row['Id']?>'></div></button></form>
        <?php
        $MaxCards3++;
        }
    }elseif($displ == 4){
        if($MaxCards4 < 2){
        ?>
        <form method="post"><button name="add" id="addToCart"><div class="spotlight4">
        <img id="gameImage3" src="<?php echo $row['image']?>">
        <h1 id="gameName1"><?php echo $row['naam']?></h1>
        <h1 id="gameName2"><?php echo $row['info']?></h1>
        <h1 id="gamePrice1"><p>from &#128178;<?php echo $row['prijs2']?></p><p id="price2">to <?php echo $productPrice?></p></h1>
        <input type="hidden" name="productId" value='<?php echo $row['Id']?>'></div></button></form>
        <?php
        $MaxCards4++;
        }
        }
    }
}
//GAME CART
function GameCart($productName, $productPrice, $productImg, $productId, $company){

    if ($productPrice == 0){
        $productPrice = "free";
    }
    else
    {
        $productPrice = "&#128178;".$productPrice;
    }

    $element = '
    <form action="cart.php?action=remove&Id='.$productId.'" method="post">
    <div class="cartgames">
    <img id="cartGameImg" src="'.$productImg.'">
    <div class="cartGameText">
        <h1 id="Charcarpro">'.$productName.'</h1>
        <p id="Charcompany">Seller: '.$company.'</p>
        <p id="GameType">GameType: base game</p>
        <h1 id="CharPrice">'.$productPrice.'</h1>
        <div id="cartButtons">
            <button type="submit" name="Wishlist" id="AddWish">Add to Wishlist</button>
            <button type="submit" name="remove" id="RemoveCart">Remove</button>
        </div>
    </div>
    </div>
    </form>
    ';

    echo $element;
}
//PROFILE
function CreateSetting($accTxt, $location){
    $element = '
    <form action="profile.php?setting='.$location.'" method="post">
    <button type="submit" name="profileSet" id="profileSet">'.$accTxt.'</button>
    </form>
    ';
    echo $element;
}
// CURRENT GAME
function CreateGamePage($productName, $productVideo, $productInfo, $productGenre, $ratings, $gameImg, $gamePegi, $gamePegi2, $productPrice, $productOwner, $release, $platform, $productId){
    if ($productPrice == 0){
        $productPrice = "free";
    }
    else
    {
        $productPrice = "&#128178;".$productPrice;
    }

    $element = '
    <form method="post">
    <h1 id="game-title">'.$productName.'</h1>
    <div class="cartBody">
    <div class="gamedisplay-parent">
        <iframe id="game-vid" src="https://www.youtube.com/embed/'.$productVideo.'?autoplay=1&mute=1&controls=1" frameborder="0"></iframe>
        <p id="game-info">'.$productInfo.'</p>
        <h1 id="game-genre">Genre</h1>
        <p id="game-genre">'.$productGenre.'</p>
        <br>
        <hr id="game-hr">
        <h1 id="game-rating">Rating</h1>
        <p id="game-rating">'.$ratings.'</p>
    </div>
        <div class="gammeinfo-parent">
            <img id="game-img" src="'.$gameImg.'">
            <div class="pegi">
                <img id="pegi" src="'.$gamePegi.'">
                <h1>'.$gamePegi2.'</h1>
            </div>
            <h1 id="game-price">PRICE: '.$productPrice.'</h1>
            <button name="buy" id="game-buy">BUY NOW</button>
            <button name="set" id="game-cart">ADD TO CART</button>
            <input type="hidden" name="productId" value='.$productId.'>
            <p id="game-developer">Developer: '.$productOwner.'</p>
            <hr id="game-hr">
            <p id="game-developer">Launch: '.$release.'</p>
            <hr id="game-hr">
            <p id="game-developer">Platform: '.$platform.'</p>
            <hr id="game-hr">
        </div>
    </div>
    </form>
    ';
    echo $element;
}
//GAME PAGE
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
//Budget
function SetBudget($conn, $uid){
        $result = getData($conn, "SELECT budget FROM gebruiker WHERE Id = $uid;");

        while ($row = mysqli_fetch_assoc($result)){
            $budget = $row['budget'];
            $_SESSION['budget'] = $budget;
        }
}
function GameDisplay5($Gimg, $Gname, $Gprice){
    $element = '
    <div class="bestelling-card"><img src="'.$Gimg.'"><div><h1>'.$Gname.'</h1><p>PRICE: &#128178;'.$Gprice.'&nbsp;</p></div></div>
    ';
    echo $element;
}
?>
<?php
function buyGameScreen($conn, $user, $wallet, $Tprice, $type, $button, $colsebutton, $uid, $enoughMoney, $codetext){
    ?>
    <input id="TotalpriceForjs" type="hidden" value="<?php echo $Tprice?>">
    <form action="../includes/transitions.inc.php" method="post">
    <div class="order-parent">
    <div class="bestelling-parent">
        <div class="bestelling-parent-a">
            <div class="bestelling-parent-title"><h1>CHECKOUT</h1><h1>@<?php echo $user?></h1></div>
            <hr>
            <div class="body">
                <h1 id="titl">WALLET BALANCE</h1>$
                <div class="b wallet"><i class="fa fa-money"></i><h1>Wallet: <?php if($wallet < 2){echo "you have no money yet";}elseif($wallet > 2107483647){echo "infinite money";}else {echo "&#128178;". $wallet;}?></h1></div>
                <h1 id="titl">PAYMENT METHODS</h1>
                <div onclick="showReedem()" class="b reedem"><img src="https://cdn0.iconfinder.com/data/icons/ecommerce-121/24/gift-card-512.png"><h1>Reedem code</h1></div>
                <div id="reedem" class="b reedema"><input name="codesent" type="text" maxlength="25"><button type="submit" name="submitCode">Reedem Code</button></div>
                <h1><?php echo $codetext?></h1>
                <div onclick="showPaym()" class="b"><img src="https://cdn.freebiesupply.com/logos/large/2x/paypal-icon-logo-png-transparent.png"><h1>Payments Methods</h1></div>
                <div class="paypal" id="paypal"></div>
                <script src="https://www.paypal.com/sdk/js?client-id=AZLZpIsRImLEzb0Lib54PbLsNg_POLIU3uBKdahm4Uycn_A5sRoSPllpOxH6rBFH-7sJNbut-KRVB4EA" data-namespace="paypal_sdk"></script>
                <script>
                var totalprice = document.getElementById('TotalpriceForjs').value ;
                paypal_sdk.Buttons({
                createOrder : function(data, actions){
                return actions.order.create({
                    purchase_units : [{
                    amount : {
                        value : totalprice
                    }
                    }],
                    application_context: {
                        shipping_preference: "NO_SHIPPING",
                    },
                    country_code : "PH"
                })
                },
                style: {
                    color:  'blue',
                    shape:  'rect',
                    label:  'buynow',
                    size: 'responsive',
                    branding: true

                },
                onApprove: function(data, actions) {
                    // Capture the funds from the transaction
                    return actions.order.capture().then(function(details) {

                    return fetch('/pay-with-pp', {
                        method: 'post',
                        headers: {
                        'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                        orderID: data.orderID,
                        product_id : product_id,
                        _token : token
                        })
                    }).then(function(res){
                        window.location.href = "../includes/transitions.inc.php";
                    });
                    });
                },

                }).render('#paypal');

                function showReedem() {
                    document.getElementById("reedem").classList.toggle("reedemz");
                    }
                function showPaym() {
                document.getElementById("paypal").classList.toggle("showpay");
                }
                </script>
            </div>
            <br>
            <hr>
            <h1 id="total-price">TOTAL PRICE: &nbsp;&#128178;<?php echo round($Tprice);?>&nbsp;</h1>
            <input type="hidden" name="Tprice" value="<?php echo $Tprice?>">
            <p id="total-price">inclusive tax</p><br>
            <h1 id="enoughmoney"><?php echo $enoughMoney ?></h1>
        </div>
        <div class="bestelling-parent-b">
        <div class="bestelling-parent-title"><h1>order summary</h1><?php echo $colsebutton?></div>
        <div class="bestelling-card-parent">
            <?php
        if (isset($_SESSION['cart'])){
                $itemId = array_column($_SESSION['cart'], 'productId');
                $gameId = $_SESSION['CurrentGame'];
                $result = getData($conn, "SELECT * FROM games");
                $result2 = getData($conn, "SELECT * FROM gebruiker");
                $total = 0;
                if ($type == 1){
                    echo '<input type="hidden" name="buyHeader" value="../User/cart.php?doing=nomony">';
                    while ($row = mysqli_fetch_assoc($result)){
                        foreach ($itemId as $id){
                            if($row['Id'] == $id){
                                GameDisplay5($row['image'],$row['naam'],$row['prijs']);
                                $total = $total + (int)$row['prijs'];
                                echo '<input type="hidden" name="buyId" value="'.$id.'">';
                                echo '<input type="hidden" name="checkName" value="'.$row['naam'].'">';
                                echo '<input type="hidden" name="checkImg" value="'.$row['image'].'">';
                                echo '<input type="hidden" name="checkPrice" value="'.$row['prijs'].'">';
                                echo '<input type="hidden" name="checkInf" value="'.$row['info'].'">';
                            }
                        }
                    }
                    while ($row = mysqli_fetch_assoc($result2)){
                            if($row['Id'] == $uid){
                                echo '<input type="hidden" name="checkUsername" value="'.$row['Username'].'">';
                                echo '<input type="hidden" name="checkEmail" value="'.$row['Email'].'">';
                            }
                        }
                }elseif ($type == 2){
                    echo '<input type="hidden" name="buyHeader" value="../User/game.php?doing=nomony">';
                    echo '<input type="hidden" name="buyId" value="'.$gameId.'">';
                    while ($row = mysqli_fetch_assoc($result)){
                            if($row['Id'] == $gameId){
                                GameDisplay5($row['image'],$row['naam'],$row['prijs']);
                                $total = $total + (int)$row['prijs'];
                                // echo '<input type="hidden" name="buyId" value="'.$gameId.'">';
                                echo '<input type="hidden" name="checkName" value="'.$row['naam'].'">';
                                echo '<input type="hidden" name="checkImg" value="'.$row['image'].'">';
                                echo '<input type="hidden" name="checkPrice" value="'.$row['prijs'].'">';
                                echo '<input type="hidden" name="checkInf" value="'.$row['info'].'">';
                            }
                    }
                    while ($row = mysqli_fetch_assoc($result2)){
                        if($row['Id'] == $uid){
                            echo '<input type="hidden" name="checkUsername" value="'.$row['Username'].'">';
                            echo '<input type="hidden" name="checkEmail" value="'.$row['Email'].'">';
                        }
                    }
                }
            }
            ?>
    </div>
    <?php
    echo $button;
    ?>
</div>
</div>
</div>
</form>
<style>
    *{
        overflow-y: hidden;
    }
</style>
<?php
}
?>
<?php
// DISCOVER PAGE
function MakeFilter($name, $location) {
    $element = '
    <form action="discover.php?filter='.$location.'" method="post">
    <button id="addToCart" type="submit" name="filter"><a>'.$name.'</a>
    </button>
    </form>
    ';
    echo $element;
}
function filterRows($productImg, $productName, $productPrice, $productId) {
    if ($productPrice == 0){
        $productPrice = "free";
    }
    else
    {
        $productPrice = "&#128178;".$productPrice;
    }
    $element = '
    <form method="post">
    <button name="add" id="addToCart2">
    <div class="sugg-card">
    <img src="'.$productImg.'">
    <h1>'.$productName.'</h1>
    <h1>'.$productPrice.'</h1>
    </div>
    <input type="hidden" name="productId" value='.$productId.'>
    </button>
    </form>
    ';
    echo $element;
}
function EXgenre($name, $location, $img) {
    $element = '
    <form action="discover.php?filter='.$location.'" method="post">
    <button id="addToCart" type="submit" name="filter">
    <div class="genres-card">
    <img src="'.$img.'">
    <h1>'.$name.'</h1>
    </div>
    </button>
    </form>
    ';
    echo $element;
}


//GET USERS BANNED
function createBan($conn, $banId, $klacht, $banName, $loc) {
    $sql = "INSERT INTO banlist (Id, klacht, Username) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../User/signup.php?error=stmtfailed');
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $banId, $klacht, $banName);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header('location: '.$loc.'');
    exit();
}
function createUnban($conn, $username){
    mysqli_query($conn, "DELETE FROM banlist WHERE Username = $username");
}
function CheckIfBanned($conn, $uid, $file) {
    $result = mysqli_query($conn, "SELECT Id FROM banlist WHERE Id = $uid");
    if (mysqli_num_rows($result)>0) {
        if ($file == 1) {
            header('location: error.php?type=banned');
        }else{
            header('location: ../error.php?type=banned');
        }
    }

}
//Last Online
function CheckLastTimeOnline($conn, $uid){
    $date = date("j F Y");
    mysqli_query($conn, "UPDATE gebruiker SET onlineDate = '$date' WHERE gebruiker.Id = $uid;");
}
function CheckWhereLiving($conn, $uid){
    $userlocation = @unserialize (file_get_contents('http://ip-api.com/php/'));
    if ($userlocation && $userlocation['status'] == 'success') {
    }
    $location = $userlocation['country'];
    mysqli_query($conn, "UPDATE gebruiker SET Land = '$location' WHERE gebruiker.Id = $uid;");
}
//FRIENDS
function ShowFriendPage($friendsname, $friendLevel, $friendImg, $friendBio, $uid, $friendId){
    if(isset($_GET['alreadyfriends'])){
        $btnTitle = "Already Friends";
        echo "<script>alert('already friends')</script>";
    }elseif(isset($_GET['alreadypending'])){
        $btnTitle = "Already Pending";
        echo "<script>alert('your request is pending')</script>";
    }elseif(isset($_GET['alreadysend'])){
        $btnTitle = "Already Sent";
        echo "<script>alert('friend request sent')</script>";
    }else{
        $btnTitle = "Add Friends";
    }
    ?>
    <div class="row-friend-profile-parent">
    <div class="row-friend-profile"><img src="<?php if($friendImg == ""){echo "../docs/emptyInput.png";}else{echo $friendImg;} ?>"></div>
    <h1 id="mainTxt"><?php echo $friendsname?></h1>
    <div class="row-friend-profile-child">
        <div class="profile-child1">
        <h1 id="Bio">Bio</h1>
            <div class="bio">
                <h1 id="bi"><?php if($friendBio == ""){echo "This user don't have a bio yet";}else{echo $friendBio;} ?></h1>
            </div>
        </div>
        <div class="profile-child2">
            <h1 id="level">Level <?php if($friendLevel > 100000){echo "GOD";}else{echo $friendLevel;} ?></h1>
            <form id="form1" action="../includes/search.inc.php" method="post"><div onclick="submit('form1')" class="friend-option"><h1><?php echo $btnTitle ?></h1></div>
            <input type="hidden" name="friendrequestSender" value="<?php echo $uid?>">
            <input type="hidden" name="friendrequestReceiver" value="<?php echo $friendId?>">
            </form>
            <form id="form2" action="../includes/search.inc.php" method="post"><div onclick="submit('form2')" class="friend-option"><h1>Delete Friend</h1></div>
            <input type="hidden" name="friendDeleteSender" value="<?php echo $uid?>">
            <input type="hidden" name="friendDeleteReceiver" value="<?php echo $friendId?>">
            </form>
            <form id="form3" action="?messages" method="post"><div onclick="submit('form3')" class="friend-option"><h1>Messages</h1></div>
            <input type="hidden" name="friendPageId" value="<?php echo $friendId?>">
            <input type="hidden" name="friendPageName" value="<?php echo $friendsname?>">
            <input type="hidden" name="friendPageImg" value="<?php echo $friendImg?>">
            </form>
            <form id="form4" action="../includes/search.inc.php" method="post"><div onclick="submit('form4')" class="friend-option"><h1>Follow</h1></div>
            <input type="hidden" name="friendFollowSender" value="<?php echo $uid?>">
            <input type="hidden" name="friendFollowReceiver" value="<?php echo $friendId?>">
            </form>
        </div>
        <script>
            function submit(id){
                let form = document.getElementById(id);
                form.submit();
            }
        </script>
    </div>
    </div>
    <?php
    }

function getFriends($conn, $uid, $type){
    $queryA = "SELECT * FROM friends WHERE senderId = ".$uid." AND status = 'FRIENDS' OR receiverId = ".$uid." AND status = 'FRIENDS';";
    $resultA = mysqli_query($conn, $queryA);

    if (mysqli_num_rows($resultA) > 0){
        while($row = mysqli_fetch_assoc($resultA)){
            $sender = $row['senderId'];
            $reciver = $row['receiverId'];
            $status = $row['status'];

            if ($uid == $sender){
                $queryB = "SELECT * FROM gebruiker WHERE Id = $reciver";
                $resultB = mysqli_query($conn, $queryB);

                if(mysqli_num_rows($resultB) > 0){
                    if($row = mysqli_fetch_assoc($resultB)){
                        $friendsname = $row['Username'];
                        $profileImg = $row['profileImg'];
                        $friendId = $row['Id'];
                        $friendLevel = $row['level'];
                        $friendBio = $row['Bio'];
                        $friendDate = $row['onlineDate'];
                        $date = $row['onlineDate'];
                        $_SESSION['friendnumber'] = mysqli_num_rows($resultA);
                        if ($type == 1){
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
                        }elseif ($type == 2){
                            $sql = "SELECT * FROM chat WHERE ChatReceiver = $uid AND ChatSender = $friendId ORDER BY Id DESC LIMIT 1";
                            $res = mysqli_query($conn, $sql);
                            if($row = mysqli_fetch_assoc($res)){
                                $lastchat = $row['message'];
                                $currT = $row['time'];
                            }else{
                                $lastchat = "";
                                $currT = "";
                            }
                            $msg = $lastchat;
                            $time = $currT;
                            ?>
                            <form action="?messages" method="post"><button id="messages-nav-child" type="submit" name="getFriendsMessages">
                            <div class="messages-nav-child"><img src="<?php if($profileImg == ""){echo "../docs/emptyInput.png";}else{echo $profileImg;} ?>"><h1 id="date"><?php if($time == ""){echo date("H:i"); ;}else{echo $time;}?></h1>
                            <div class="messages-nav-inf"><h1><?php echo $friendsname?></h1><p><?php if($msg == ""){echo "no message yet";}else{echo $msg;}?></p></div>
                            </div></button>
                            <input type="hidden" name="friendPageId" value="<?php echo $friendId?>">
                            <input type="hidden" name="friendPageName" value="<?php echo $friendsname?>">
                            <input type="hidden" name="friendPageLevel" value="<?php echo $friendLevel?>">
                            <input type="hidden" name="friendPageBio" value="<?php echo $friendBio?>">
                            <input type="hidden" name="friendPageDate" value="<?php echo $friendDate?>">
                            <input type="hidden" name="friendPageImg" value="<?php echo $profileImg?>">
                            </form>
                            <hr id="messages-nav">
                            <?php
                        }
                    }
                }
            }elseif($uid == $reciver){
                $queryB = "SELECT * FROM gebruiker WHERE Id = $sender";
                $resultB = mysqli_query($conn, $queryB);

                if(mysqli_num_rows($resultB) > 0){
                    if($row = mysqli_fetch_assoc($resultB)){
                        $friendsname = $row['Username'];
                        $profileImg = $row['profileImg'];
                        $friendId = $row['Id'];
                        $friendLevel = $row['level'];
                        $friendBio = $row['Bio'];
                        $friendDate = $row['onlineDate'];
                        $date = $row['onlineDate'];
                        $_SESSION['friendnumber'] = mysqli_num_rows($resultA);
                        if ($type == 1){
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
                            }elseif ($type == 2){
                                $sql = "SELECT * FROM chat WHERE ChatReceiver = $uid AND ChatSender = $friendId ORDER BY Id DESC LIMIT 1";
                                $res = mysqli_query($conn, $sql);
                                if($row = mysqli_fetch_assoc($res)){
                                    $lastchat = $row['message'];
                                    $currT = $row['time'];
                                }else{
                                    $lastchat = "";
                                    $currT = "";
                                }
                                $msg = $lastchat;
                                $time = $currT;
                            ?>
                            <form action="?messages" method="post"><button id="messages-nav-child" type="submit" name="getFriendsMessages">
                            <div class="messages-nav-child"><img src="<?php if($profileImg == ""){echo "../docs/emptyInput.png";}else{echo $profileImg;} ?>"><h1 id="date"><?php if($time == ""){echo date("H:i"); ;}else{echo $time;}?></h1>
                            <div class="messages-nav-inf"><h1><?php echo $friendsname?></h1><p><?php if($msg == ""){echo "no message yet";}else{echo $msg;}?></p></div>
                            </div></button>
                            <input type="hidden" name="friendPageId" value="<?php echo $friendId?>">
                            <input type="hidden" name="friendPageName" value="<?php echo $friendsname?>">
                            <input type="hidden" name="friendPageLevel" value="<?php echo $friendLevel?>">
                            <input type="hidden" name="friendPageBio" value="<?php echo $friendBio?>">
                            <input type="hidden" name="friendPageDate" value="<?php echo $friendDate?>">
                            <input type="hidden" name="friendPageImg" value="<?php echo $profileImg?>">
                            </form>
                            <hr id="messages-nav">
                            <?php
                        }
                    }
                }
            }
        }
        ?>
        <?php
    }else{
        echo "you have no friends";
    }
}

function messageSender($msg){?>
    <div class="message"><h1 id="messageSender"><?php echo $msg ?></h1></div>
<?php
}
function messageReceiver($msg){?>
    <div class="message"><h1 id="messageReceiver"><?php echo $msg ?></h1></div>
<?php
}
function ShowMessages($conn, $uid, $friendId, $profileImg, $friendname){
    $searchChat = "SELECT * FROM chat WHERE $uid = ChatSender AND $friendId = ChatReceiver OR  $uid = ChatReceiver AND $friendId = ChatSender ORDER BY chat.Id ASC;";
    $chat = mysqli_query($conn, $searchChat);
    if(mysqli_num_rows($chat) == 0){?>
    <nav class="messages-body1"><img src="<?php if($profileImg == ""){echo "../docs/emptyInput.png";}else{echo $profileImg;} ?>"><h1><?php echo $friendname?></h1></nav>
    <div class="messages"><div class="message"><h1 id="messageReceiver">You have no chats with this user yet</h1></div></div>
    <nav class="messages-body2"><form method="post"><input id="messageTouser" type="text" name="messageTouser" value="" placeholder="Type in your message">
    <input type="hidden" name="friendId" value="<?php echo $friendId ?>">
    <input type="hidden" name="currTime" value="<?php echo date("H:i")?>">
    </form></nav>
    <?php
    }else{
    ?>
    <nav class="messages-body1"><img src="<?php if($profileImg == ""){echo "../docs/emptyInput.png";}else{echo $profileImg;} ?>"><h1><?php echo $friendname?></h1></nav>
    <div class="messages">
        <?php
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
        ?>
    </div>
    <nav class="messages-body2"><form method="post"><input id="messageTouser" type="text" name="messageTouser" value="" placeholder="Type in your message">
    <input type="hidden" name="friendId" value="<?php echo $friendId ?>">
    <input type="hidden" name="currTime" value="<?php echo date("H:i")?>">
    </form></nav>
    <?php
    }
}

    
//GET GLOABAL DATA FUCTION (FOR ALL) FROM DATABASE
function getData($dat, $sqlCommand){
    include_once('dbh.inc.php');
    $sqlD = $sqlCommand;
    $data = mysqli_query($dat, $sqlD);

    if(mysqli_num_rows($data)>0){
        return $data;
    }
}