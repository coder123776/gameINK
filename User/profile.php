<?php
include_once('../includes/dbh.inc.php');
include_once('../head-footer/EXheader.php');
include_once('../includes/functions.inc.php');
include_once('../includes/transitions.inc.php');

if(!isset($_SESSION['userid'])) {
    header('location: ../User/login.php');
}else{
        CheckIfBanned($conn, $uid, 2);
        SetBudget($conn, $uid);
}
?>
<title>Your Profile at GameINK</title>
<section id="Profile">
    <nav id="Profile">
        <?php
        CreateSetting("ACCOUNT SETTINGS", "account");
        CreateSetting("ORDERS", "orders");
        CreateSetting("PAYMENT MANAGMENT", "payment");
        CreateSetting("PASSWORD & SECURITY", "security");
        CreateSetting("FEEDBACK", "feedback");
        CreateSetting("REEDEM CODE", "reedem");
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
                    <button id="account-label" type="submit"><i class="fa fa-pencil"></i></button>
                </div>
                <div class="account-button-parent">
                    <div class="account-label"><p>Username</p><h2><?php echo $username;?></h2></div>
                    <button id="account-label" type="submit"><i class="fa fa-pencil"></i></button>
                </div>
                <h1>Country</h1>
                <div class="account-button-parent">
                    <div class="account-label"><p>your country</p><h2><?php echo $userlocation['country'] ,'&nbsp;'. $userlocation['city'] ?></h2></div>
                    <button id="account-label" type="submit"><i class="fa fa-pencil"></i></button>
                </div>
                <h1 id="account-delete">Account Delete</h1>
                <div class="account-delete">
                    <p id="account-delete">
                        note: if you click to delete your account there is no way back
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
                <p>History</p>
                <table class="tableOrders">
                    <thead>
                        <tr>
                            <th>OrderId</th>
                            <th>Name</th>o
                            <th>Email</th>
                            <th>product Name</th>
                            <th>product Price</th>
                            <th>product Image</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    DisplayOrder($conn, $uid);
                    ?>
                    </tbody>
                </table> 
            </div>
            </div>
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
        if ($_GET['setting'] == "security"){
            $elemnt = '
            <div class="profile-parent">
            <div class="account-body">
                <h1 id="account-title">SECURITY SETTINGS</h1>
                <h1>Welcome Full name</h1>
                <p>ID: UserId</p>
                <p>Username: Username</p>  
            </div>
            </div>
            ';
            echo $elemnt;
        }
        if ($_GET['setting'] == "feedback"){
            $elemnt = '
            <div class="profile-parent">
            <div class="account-body">
                <h1 id="account-title">GIVE FEEDBACKS</h1>
                <h1>Welcome Full name</h1>
                <p>ID: UserId</p>
                <p>Username: Username</p>  
            </div>
            </div>
            ';
            echo $elemnt;
        }
        if ($_GET['setting'] == "reedem"){
            $elemnt = '
            <div class="profile-parent">
            <div class="account-body">
                <h1 id="account-title">REEDEM CODES</h1>
                <h1>Welcome Full name</h1>
                <p>ID: UserId</p>
                <p>Username: Username</p>  
            </div>
            </div>
            ';
            echo $elemnt;
        }
    }


    ?>

</section>


<?php
include_once '../head-footer/EXfooter.php';
?>

<!-- retourpolicy
geschiedenis
email
payment
password
leverancier
klacht -->