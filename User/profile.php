<?php
session_start();
$_SESSION['fileType'] = 2;
include_once('../includes/dbh.inc.php');
include_once('../head-footer/header.php');
include_once('../includes/functions.inc.php');
include_once('../includes/transitions.inc.php');
if(!isset($_SESSION['userid'])) {
    header('location: ../User/login.php?error=loginfirst');
}else{
    CheckIfBanned($conn, $uid, 1); SetBudget($conn, $uid); CheckLastTimeOnline($conn, $uid); CheckWhereLiving($conn, $uid); CheckLevel($conn, $uid);
        include_once('../head-footer/chatbot.php');
}
// print_r($_SESSION['AllNames']);
?>
<title>Your Profile at GameINK</title>
<section id="Profile">
    <nav id="Profile">
        <?php
        CreateSetting("ACCOUNT SETTINGS", "account");
        CreateSetting("ORDERS", "orders");
        CreateSetting("PAYMENT MANAGMENT", "payment");
        CreateSetting("FEEDBACK", "feedback");
        ?>
    </nav>

    <!-- <div class="profile-parent">
            <div class="account-body">
                <h1 id="account-title">PAYMENT SETTINGS</h1>
                <h1>MY BUDGET</h1>
                <p>Total money: &nbsp;&#128178; </p>
            </div>
            </div> -->

    <?php
    if(isset($_GET['setting'])){
        if ($_GET['setting'] == "account"){
            $userlocation = @unserialize (file_get_contents('http://ip-api.com/php/'));
            if ($userlocation && $userlocation['status'] == 'success') {
            }
            ?>
            <div class="profile-parent">
            <div class="account-tumbnail"><img src="<?php if($profilePic == ""){echo "../docs/emptyInput.png";}else{echo $profilePic;} ?>"></div>
            <div class="account-body">
                <h1 id="account-title">ACCOUNT SETTINGS</h1>
                <h1>Welcome <?php echo $name;?></h1>
                <p>ID: <?php echo $uid;?></p>
                <p>Username: @<?php echo $username;?></p>

                <div class="account-button-parent">
                    <div class="account-label"><p>Real Name</p><h2><?php echo $name;?></h2></div>
                </div>
                <div class="account-button-parent">
                    <div class="account-label"><p>Username</p><h2><?php echo $username;?></h2></div>
                </div>
                <h1>Country</h1>
                <div class="account-button-parent">
                    <div class="account-label"><p>your country</p><h2><?php echo $userlocation['country'] ,'&nbsp;'. $userlocation['city'] ?></h2></div>
                </div>
                <h1>Bio</h1>
                <textarea name="message" rows="10" cols="40"><?php echo $userBio?></textarea>
                <H1>To change settings Click <a href="../User/friendz.php?mypage">>></a></H1>
                <h1 id="account-delete">Account Delete</h1>
                <div class="account-delete">
                    <p id="account-delete">
                        note: if you click to delete your account... <br> there is no way back
                        you still need to verify by your email to delete your account.
                    </p>
                    <button>Delete Account</button>
                </div>
            </div>
        </div>
        <?php
        }
        if ($_GET['setting'] == "orders"){
            ?>
            <div class="profile-parent">
            <div class="account-body">
                <h1 id="account-title">MY ORDERS</h1>
                <input class="searchOrders" id="searchOrders" type="text" name="searchOrders" placeholder="search your orders...">
                <p>History</p>
                <table class="tableOrders">
                    <thead>
                        <tr>
                            <th>OrderId</th>
                            <th>product Name</th>
                            <th>Date</th>
                            <th>product Price</th>
                            <th>product Image</th>
                        </tr>
                    </thead>
                    <tbody id="displayorders">
                    <?php
                    DisplayOrder($conn, $uid, 1, "");
                    ?>
                    </tbody>
                </table> 
            </div>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
            <script type="text/javascript">
                    $(document).ready(function(){
                    $("#searchOrders").keyup(function(){
                            var input = $(this).val();
                            if(input != ""){
                            $.ajax({
                                    url:"../includes/search.inc.php",
                                    method:"post",
                                    data:{searchorders:input},

                                    success:function(data){
                                    $("#displayorders").html(data);
                                    }
                            });
                            }
                    });
                    });
            </script>
            <?php

        }
        if ($_GET['setting'] == "payment"){
            $elemnt = '
            <div class="profile-parent">
            <div class="account-body">
                <h1 id="account-title">PAYMENT SETTINGS</h1>
                <h1>MY BUDGET</h1>
                <p>Total money: &nbsp;&#128178; '. $_SESSION["budget"] .' </p>
            </div>
            </div>
            ';
            echo $elemnt;
        }
        if ($_GET['setting'] == "feedback"){?>
            <div class="profile-parent">
            <div class="account-body">
                <h1 id="account-title">GIVE FEEDBACKS</h1>
                <h1>Welcome <?php echo $username?> can you give us a feedback, what can be better and whats good?</h1>
                <form action="../includes/reviews.inc.php" method="post">
                <div class="givefb">
                    <input id="givefbl" type="text" name="givefbl" maxlength="50" required placeholder="type your feedback...">
                    <button id="givefbb" type="submit" name="givefbb">post Feedback</button>
                    <input type="hidden" name="givefbn" value="<?php echo $username?>">
                    <input type="hidden" name="givefbi" value="<?php echo $uid?>">
                    <input type="hidden" name="givefbpp" value="<?php echo $profilePic?>">
                    <input type="hidden" name="givefbd" value="<?php echo date('jS F Y H:i');?>">
                    <?php
                    if(isset($_GET['sended'])){
                        echo "<p>you did send your message, scroll down to see it</p>";
                    }
                    ?>
                </div>
                </form>
            </div>
            </div>
            <?php
        }
    }


    ?>

</section>


<?php
include_once('../head-footer/footer.php');
?>

<!-- retourpolicy
geschiedenis
email
payment
password
leverancier
klacht -->