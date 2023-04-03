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
        $_SESSION["password"] = $uidExists["Password"];
        $_SESSION['profilePic'] = $uidExists['profileImg'];
        $_SESSION['bio'] = $uidExists['Bio'];
        $_SESSION['level'] = $uidExists['level'];
        $_SESSION['onlinedate'] = $uidExists['onlineDate'];
        $_SESSION['land'] = $uidExists['Land'];
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
        if($MaxCards1 < 15){
        ?>
        <form id="cardslide1" method="post"><button name="add" id="addToCart"><div class="card card1">
        <div class="gameImage1"><img id="gameImage1" src="<?php echo $row['image']?>"></div>
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
        <div class="gameImage2"><img id="gameImage2" src="<?php echo $row['image']?>"></div>
        <h1 id="gameName2"><?php echo $row['naam']?></h1>
        <p id="gameInf"><?php echo $row['info']?></p>
        <h1 id="gamePrice2"><?php echo $productPrice?></h1>
        <input type="hidden" name="productId" value='<?php echo $row['Id']?>'></div></button></form>
        <?php
        $MaxCards2++;
        }
    }elseif($displ == 3){
        if($MaxCards3 < 15){
        ?>
        <form method="post"><button name="add" id="addToCart"><div class="card card2">
        <div class="gameImage1"><img id="gameImage1" src="<?php echo $row['image']?>"></div>
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
        <div class="gameImage3"><img id="gameImage3" src="<?php echo $row['image']?>"></div>
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
    <input type="hidden" name="removeId" value="'.$productId.'">
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
        <iframe id="game-vid" src="https://www.youtube.com/embed/'.$productVideo.'?autoplay=1&mute=1&controls=0" frameborder="0" style="pointer-events: none;"></iframe>
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
                <div class="b wallet"><i class="fa fa-money"></i><h1>Wallet: <?php if($wallet < -2){echo "you owe us money, report this before you can get banned";}elseif($wallet < 2){echo "you have no money yet";}elseif($wallet > 2107483647){echo "infinite money";}else {echo "&#128178;". $wallet;}?></h1></div>
                <h1 id="titl">PAYMENT METHODS</h1>
                <div onclick="showReedem()" class="b reedem"><img src="https://cdn0.iconfinder.com/data/icons/ecommerce-121/24/gift-card-512.png"><h1>Reedem code</h1></div>
                <div id="reedem" class="b reedema"><input name="codesent" type="text" maxlength="25"><button type="submit" name="submitCode">Reedem Code</button></div>
                <h1><?php echo $codetext?></h1>
                <div onclick="showPaym()" class="b"><img src="https://cdn.freebiesupply.com/logos/large/2x/paypal-icon-logo-png-transparent.png"><h1>Payments Methods</h1></div>
                <div class="paypal" id="paypal"></div>
                <script src="https://www.paypal.com/sdk/js?client-id=AZLZpIsRImLEzb0Lib54PbLsNg_POLIU3uBKdahm4Uycn_A5sRoSPllpOxH6rBFH-7sJNbut-KRVB4EA" data-namespace="paypal_sdk"></script>
                <script>
                var totalprice = document.getElementById('TotalpriceForjs').value;
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
                    country_code : "NL"
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
                        window.location.href = "../User/profile.php?setting=orders";
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
                    $_SESSION['AllIds'] = array();
                    $_SESSION['AllNames'] = array();
                    $_SESSION['AllImages'] = array();
                    $_SESSION['AllPrices'] = array();
                    $_SESSION['AllInfos'] = array();
                    while ($row = mysqli_fetch_assoc($result)){
                        foreach ($itemId as $id){
                            if($row['Id'] == $id){
                                GameDisplay5($row['image'],$row['naam'],$row['prijs']);
                                $total = $total + (int)$row['prijs'];
                                $_SESSION['AllIds'][] = $id;
                                $_SESSION['AllNames'][] = $row['naam'];
                                $_SESSION['AllImages'][] = $row['image'];
                                $_SESSION['AllPrices'][] = $row['prijs'];
                                $_SESSION['AllInfos'][] = $row['info'];
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
function createReview($conn, $banId, $klacht, $banName, $status, $review, $time, $userimg, $loc) {
    $sql = "INSERT INTO review (uid, klacht, Username, status, review, time, userimg) VALUES (?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../User/signup.php?error=stmtfailed');
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssss", $banId, $klacht, $banName, $status, $review, $time, $userimg);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header('location: '.$loc.'');
    exit();
}
function createUnban($conn, $username){
    mysqli_query($conn, "DELETE FROM review WHERE Username = $username AND status = 'BANNED' OR Username = $username AND status = 'BANNED2';");
}
function CheckIfBanned($conn, $uid, $file) {
    $result = mysqli_query($conn, "SELECT * FROM review WHERE uid = $uid AND status = 'BANNED' OR uid = $uid AND status = 'BANNED2';");
    if (mysqli_num_rows($result)>0) {
        if ($file == 1) {
            header('location: error.php?type=banned');
        }else{
            header('location: ../error.php?type=banned');
        }
    }

}
function CheckLevel($conn, $uid){
    $result = getData($conn, "SELECT level FROM gebruiker WHERE Id = $uid;");

    while ($row = mysqli_fetch_assoc($result)){
        $level = $row['level'];
        $_SESSION['level'] = $level;
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

function CheckOwnedProducts($conn, $uid) {
    $result = mysqli_query($conn, "SELECT * FROM orders WHERE gebruikerId = $uid");
    $ownedGamegs = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $ownedGamegs[] = $row['bestelimage'];
    }
    $_SESSION['ownedgamesImg'] = $ownedGamegs;
}

//FRIENDS
function ShowFriendPage($conn, $friendsname, $friendLevel, $friendImg, $friendBio, $uid, $friendId){
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
            <h1 id="Bio">Owned games</h1>
            <div class="ownedgames">
            <?php
            CheckOwnedProducts($conn, $friendId);
            $allgames = $_SESSION['ownedgamesImg'];
            if (count($allgames) == 0) {
                echo "de gebruiker heeft geen games";
            } else {
                foreach ($allgames as $gameimages) {?>
                    <img src="<?php echo $gameimages ?>">
                <?php
                }
            }
            ?>
            </div>
        </div>
        <div class="profile-child2">
            <h1 id="level">Level <?php if($friendLevel > 100000){echo "GOD";}else{echo $friendLevel;} ?></h1>
            <?php
            if ($uid == $friendId){?>
            <div onclick="showProfilepic(1)" class="friend-option"><h1>Change Bio</h1></div>
            <div onclick="showProfilepic(2)" class="friend-option"><h1>Change ProfileImg</h1></div>
            <div onclick="showProfilepic(3)" class="friend-option"><h1>Change Username</h1></div>
            <div onclick="showProfilepic(4)" class="friend-option"><h1>Change Email</h1></div>
            <div onclick="showProfilepic(5)" class="friend-option"><h1>Change Password</h1></div>
            <?php
            }else{?>
            <form id="form1" action="../includes/search.inc.php" method="post"><div onclick="submit('form1')" class="friend-option"><h1><?php echo $btnTitle ?></h1></div>
            <input type="hidden" name="friendrequestSender" value="<?php echo $uid?>">
            <input type="hidden" name="friendrequestReceiver" value="<?php echo $friendId?>"></form>
            <form id="form2" action="../includes/search.inc.php" method="post"><div onclick="submit('form2')" class="friend-option"><h1>Delete Friend</h1></div>
            <input type="hidden" name="friendDeleteSender" value="<?php echo $uid?>">
            <input type="hidden" name="friendDeleteReceiver" value="<?php echo $friendId?>"></form>
            <form id="form3" action="?messages" method="post"><div onclick="submit('form3')" class="friend-option"><h1>Messages</h1></div>
            <input type="hidden" name="friendPageId" value="<?php echo $friendId?>">
            <input type="hidden" name="friendPageName" value="<?php echo $friendsname?>">
            <input type="hidden" name="friendPageImg" value="<?php echo $friendImg?>"></form>
            <form id="form4" action="../includes/search.inc.php" method="post"><div onclick="submit('form4')" class="friend-option"><h1>Follow</h1></div>
            <input type="hidden" name="friendFollowSender" value="<?php echo $uid?>">
            <input type="hidden" name="friendFollowReceiver" value="<?php echo $friendId?>"></form>
            <?php
            }
            ?>
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

function showFriends($conn, $uid, $type, $resultA, $resORsendr){
    $queryB = "SELECT * FROM gebruiker WHERE Id = $resORsendr";
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
                    <div class="messages-nav-inf"><h1><?php echo $friendsname?></h1><p><?php if($msg == ""){echo "no message from this user yet";}else{echo $msg;}?></p></div>
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
function getFriends($conn, $uid, $type){
    $queryA = "SELECT * FROM friends WHERE senderId = ".$uid." AND status = 'FRIENDS' OR receiverId = ".$uid." AND status = 'FRIENDS';";
    $resultA = mysqli_query($conn, $queryA);

    if (mysqli_num_rows($resultA) > 0){
        while($row = mysqli_fetch_assoc($resultA)){
            $sender = $row['senderId'];
            $reciver = $row['receiverId'];
            $status = $row['status'];

            if ($uid == $sender){
                showFriends($conn, $uid, $type, $resultA, $reciver);
            }elseif($uid == $reciver){
                showFriends($conn, $uid, $type, $resultA, $sender);
        }else{
        echo "you have no friends";
            }
        }
    }
}

function getBotChats(){?>
    <nav class="messages-body1"><img src="../profilePics/6404b87c90d4ctester.png"><h1>INKbot</h1></nav>
    <div id="messages" class="messages"><div class="message">
    <h1 id="messageReceiver"></h1></div></div>
    <nav class="messages-body2"><input id="messageTobot" type="text" name="msgToChatbot" value="" placeholder="Type in your message" minlength="1">
    <button id="JSclick" type="submit"></button>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
    function data(){
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function(){
            document.getElementById("messages").innerHTML = this.responseText;
        }
        xhttp.open("POST", "<?php if($_SESSION['fileType'] == 1){echo "head-footer/chatbotchats.php";}elseif($_SESSION['fileType'] == 2){echo "../head-footer/chatbotchats.php";}?>");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("getchats2");
    }
    data();

    function scrolldownChatbot(){
        document.getElementById("messages").scrollTo(0, 999999999999);
    }

    $(document).ready(function() {
        $("#messageTobot").keyup(function(event) {
        if (event.keyCode === 13) {
            $("#JSclick").click();
        }});
            $("#JSclick").click(function() {
            var msgtoBot = $("#messageTobot").val();
            var filetype = 0;
            $(document).load("../index.php", {
                msgToChatbot: msgtoBot,
                otherfile: filetype
            });
            data();
            setTimeout( function () {
            scrolldownChatbot();
            } , 300 );
        });
    });

    function showBotchat() {
        document.getElementById("chatbotChild").classList.toggle("chatbot-show");
        scrolldownChatbot();
    }
    </script>
    <?php
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
    <nav class="messages-body2"><input id="messageTouser" type="text" name="messageTouser" value="" placeholder="Type in your message" minlength="1">
    <input id="friendidtouser" type="hidden" name="friendId" value="<?php echo $friendId ?>">
    <input id="date" type="hidden" name="currTime" value="<?php echo date("H:i")?>">
    <button id="JSclickMsg" type="submit"></button>
    </nav>
    <?php
    }else{
    ?>
    <nav class="messages-body1"><img src="<?php if($profileImg == ""){echo "../docs/emptyInput.png";}else{echo $profileImg;} ?>"><h1><?php echo $friendname?></h1></nav>
    <div id="messages" class="messages">
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
    <nav class="messages-body2"><input id="messageTouser" type="text" name="messageTouser" value="" placeholder="Type in your message" minlength="1">
    <input id="friendidtouser" type="hidden" name="friendId" value="<?php echo $friendId ?>">
    <input id="date" type="hidden" name="currTime" value="<?php echo date("H:i")?>">
    <input id="friendimg" type="hidden" name="friendimg" value="<?php echo $profileImg ?>">
    <input id="friendname" type="hidden" name="friendname" value="<?php echo $friendname?>">
    <button id="JSclickMsg" type="submit"></button>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
    function startTime() {
    const today = new Date();
    let h = today.getHours();
    let m = today.getMinutes();
    h = checkTime(h);
    m = checkTime(m);
    currtime =  h + ":" + m;
    return currtime;
    setTimeout(startTime, 1000);
    }
    startTime();

    function checkTime(i) {
    if (i < 10) {i = "0" + i};
    return i;
    }
    function scrolldownChatbot(){
        document.getElementById("messages").scrollTo(0, 999999999999);
    }
    function data(){
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function(){
            document.getElementById("messages").innerHTML = this.responseText;
        }
        xhttp.open("POST", "<?php if($_SESSION['fileType'] == 1){echo "head-footer/chatbotchats.php";}elseif($_SESSION['fileType'] == 2){echo "../head-footer/chatbotchats.php";}?>");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("getfriendchats");
    }

    function searchforNewchats() {
    setTimeout(function() {
        data();
        searchforNewchats();
    }, 1000)
    }
    searchforNewchats(); 
    $(document).ready(function() {
        $("#messageTouser").keyup(function(event) {
        if (event.keyCode === 13) {
            $("#JSclickMsg").click();
        }});
            $("#JSclickMsg").click(function() {
            var msgtofriend = $("#messageTouser").val();
            var friendid = $("#friendidtouser").val();
            var date = currtime;
            $(document).load("", {
                messageTouser: msgtofriend,
                friendId: friendid,
                currTime: date
            });
            setTimeout( function () {
            scrolldownChatbot();
            } , 300 );
        });
    });
    </script>
    </nav>
    <?php
    }
}
//chatbot
function botSend($msg){?>
    <div class="message"><h1 id="chatSender"><?php echo $msg?></h1></div>
<?php
}
function botReceiv($msg){?>
    <div class="message"><h1 id="chatReceiver"><?php echo $msg?></h1></div>
<?php
}
function INKbotMsg($msg, $replay){
    if ($msg == ""){
        botReceiv($replay);
    }else{
        botSend($msg);
        botReceiv($replay);
    }
}
function INKbotMsg2($msg, $replay){
    if ($msg == ""){
        messageReceiver($replay);
    }elseif($replay == ""){
        messageSender($msg);
    }else{
        messageSender($msg);
        messageReceiver($replay);
    }
}

function botToSql($conn, $userinp, $type){
    if($_SESSION["fileType"] == 1){include_once("includes/dbh.inc.php");}elseif($_SESSION["fileType"] == 2){include_once("../includes/dbh.inc.php");}
    $checkifinsql = 0;
    $userWords = explode(" ", $userinp);
    if ($type == 1){
        foreach ($userWords as $DDwords) {
            $sql = "SELECT * FROM games WHERE naam LIKE '$DDwords%';";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $checkifinsql = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $botgamename = $row["naam"];
                    $botgameid = $row['Id'];
         }}}
        if ($checkifinsql == 1){
            if($_SESSION["fileType"] == 1){$dest = "User/game.php";}elseif($_SESSION["fileType"] == 2){$dest = "../User/game.php";}
                if (isset($_SESSION['cart'])){
                    $_SESSION['CurrentGame'] = $botgameid;
                    $_SESSION['SqlBotReplay'] = mysqli_real_escape_string($conn, "ja wij hebben  $botgamename in onze website Klik <a href=$dest>Hier</a> om naar de game te gaan");
                }else{
                    $_SESSION['SqlBotnoReplay'] = "er is een plorbleem met je winkelwagen, ga even naar de homepage en kilk op een random game, daarna kun je de vraag weer stellen";
    }}}
    if ($type == 2){
        foreach ($userWords as $DDwords) {
            $sql = "SELECT * FROM gebruiker WHERE Username LIKE '$DDwords%';";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $checkifinsql = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $botFid = $row["Id"];
                    $botFname = $row["Username"];
                    $botFlevel = $row["level"];
                    $botFimg = $row["profileImg"];
                    $botFbio = $row["Bio"];
                    $botFdate = $row["onlineDate"];
         }}}
        if ($checkifinsql == 1){
            if($_SESSION["fileType"] == 1){$dest = "User/friendz.php?friendProfile";}elseif($_SESSION["fileType"] == 2){$dest = "../User/friendz.php?friendProfile";}
                    $_SESSION['friendId'] = $botFid;
                    $_SESSION['friendsname'] = $botFname;
                    $_SESSION['friendLevel'] = $botFlevel;
                    $_SESSION['friendImg'] = $botFimg;
                    $_SESSION['friendBio'] = $botFbio;
                    $_SESSION['friendDate'] = $botFdate;

                    $_SESSION['SqlBotReplay'] = mysqli_real_escape_string($conn, "ja  $botFname is een gebruiker in onze website Klik <a href=$dest>Hier</a> om naar hem/haar te gaan");
                }else{
                    $_SESSION['SqlBotnoReplay'] = "controleer of je de naam goed hebt gespeld, als de naam toch goed is bestaat hij niet op de site";
    }}
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
//admins
function showAdminGebruikers($conn, $sql){
    $maxNmr = 0;
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)){
            if ($maxNmr < 10){
                $img = $row['profileImg'];
                $usern = $row['Username'];
                $rname = $row['Name'];
                $email = $row['Email'];
                $budget = $row['budget'];
                $level = $row['level'];
                $land = $row['Land'];
                $lastonline = $row['onlineDate'];
                $id = $row['Id'];
                ?>
                    <div class="gebruikerDisp-head">
                        <div class="gebruikerDisp-1">
                            <img class="gebruikerDisp" src="<?php if($img == ""){ if($_SESSION['fileType'] == 1){echo "docs/emptyInput.png";}elseif($_SESSION['fileType'] == 2){echo "../docs/emptyInput.png";};}else{ if($_SESSION['fileType'] == 1){echo "User/".$img;}elseif($_SESSION['fileType'] == 2){echo "../User/".$img;}} ?>">
                            <div class="namestag"><label for="username">Username</label><h1 name="username"><?php echo $usern?></h1></div>
                            <div class="namestag"><label for="username">Real name</label><h1 name="username"><?php echo $rname?></h1></div>
                            <div class="namestag"><label for="username">Email</label><h1 name="username"><?php echo $email?></h1></div>
                        </div>
                        <div class="gebruikerDisp-1">
                            <div class="namestag"><label for="username">Budget</label><h1 name="username"><?php echo $budget?></h1></div>
                            <div class="namestag"><label for="username">Level</label><h1 name="username"><?php echo $level?></h1></div>
                            <div class="namestag"><label for="username">Land</label><h1 name="username"><?php echo $land?></h1></div>
                            <div class="namestag"><label for="username">Last Online</label><h1 name="username"><?php echo $lastonline?></h1></div>
                            <div class="namestag"><label for="username">Id</label><h1 name="username"><?php echo $id?></h1></div>
                            <div class="namestag"><label for="username">admin</label><h1 name="username"><?php
                                if ($_SESSION['isadmin'] == false){echo "false";}else{echo "true";}
                                ?></h1></div>
                        </div>
                        <div class="gebruikerDisp-3">
                                <form method="post"><button id="admin-option" class="noshow" type="submit" name="makeAdmin"><div class="admin-option"><h1>Make Admin</h1></div></button><input type="hidden" name="id" value="<?php echo $id?>"><input type="hidden" name="user" value="<?php echo $usern?>"></form>
                                <form method="post"><button id="admin-option" class="noshow" type="submit" name="changebudget"><div class="admin-option"><h1>Change Budget</h1></div></button></form>
                                <form method="post"><button id="admin-option" class="noshow" type="submit" name="changelevel"><div class="admin-option"><h1>Change Level</h1></div></button></form>
                                <form method="post"><button id="admin-option" class="noshow" type="submit" name="changeusername"><div class="admin-option"><h1>Change Username</h1></div></button></form>
                                <form method="post"><button id="admin-option" class="noshow" type="submit" name="changepassword"><div class="admin-option"><h1>Change Password</h1></div></button></form>
                                <form method="post"><button id="admin-option" class="noshow" type="submit" name="changeemail"><div class="admin-option"><h1>Change Email</h1></div></button></form>
                        </div>
                    </div>
                <?php
            }
        }
    }else{
        echo "<h1 id='noresult'>Nothing has found</h1>";
    }
}


//orders
function DisplayOrder($conn, $uid, $type, $sql){
    if ($type == 1) {
        $result = getData($conn, "SELECT * FROM orders WHERE gebruikerId = $uid;");
    }elseif ($type == 2) {
        $result = mysqli_query($conn, $sql);
    }
    if ($result){
        while ($row = mysqli_fetch_assoc($result)){
            $element = '
            <tr>
            <td>'.$row['Id'].'</td>
            <td>'.$row['bestelproduct'].'</td>
            <td>'.$row['besteldatum'].'</td>
            <td>&nbsp; &#128178;'.$row['bestelprijs'].'</td>
            <td><img src="'.$row['bestelimage'].'"></img></td>
            </tr>
            ';
            echo $element;
            }
    }else{
        echo "no orders Yet";
    }
}