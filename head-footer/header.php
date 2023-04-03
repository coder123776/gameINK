<?php
if($_SESSION['fileType'] == 1){include_once('includes/dbh.inc.php');}elseif($_SESSION['fileType'] == 2){include_once('../includes/dbh.inc.php');}
// if(!isset($_GET['checkIfLegal'])) {
//     $redirect_url = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] . '&checkIfLegal=true';
//     header('Location: ' . $redirect_url);
//     exit;
// }
?>
<link rel="stylesheet" href="<?php if($_SESSION['fileType'] == 1){echo "css/index.css";}elseif($_SESSION['fileType'] == 2){echo "../css/index.css";}?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?php if($_SESSION['fileType'] == 1){echo "docs/logoWeb.png";}elseif($_SESSION['fileType'] == 2){echo "../docs/logoWeb.png";}?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Rubik:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>

    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin="anonymous"></script>
    <script src="<?php if($_SESSION['fileType'] == 1){echo "app.js";}elseif($_SESSION['fileType'] == 2){echo "../app.js";}?>"></script>
</head>
<div id="dropdown1">
    <i id="close" onclick="Dropdown()" class="fa fa-close"></i>
    <div class="Searchbar">
        <form id="searchBar" action="">
            <button type="submit"><i class="fa fa-search"></i></button>
            <input disabled type="text" placeholder="Search GameINK..." name="search">
        </form>
    </div>
    <a id="inc" href="<?php if($_SESSION['fileType'] == 1){echo "index.php";}elseif($_SESSION['fileType'] == 2){echo "../index.php";}?>">Home</a>
    <a id="inc" href="<?php if($_SESSION['fileType'] == 1){echo "User/profile.php?setting=account";}elseif($_SESSION['fileType'] == 2){echo "../User/profile.php?setting=account";}?>">Profile</a>
    <a id="inc" href="<?php if($_SESSION['fileType'] == 1){echo "User/friendz.php?friendz";}elseif($_SESSION['fileType'] == 2){echo "../User/friendz.php?friendz";}?>">Friends</a>
    <a id="inc" href="<?php if($_SESSION['fileType'] == 1){echo "User/complaint.php";}elseif($_SESSION['fileType'] == 2){echo "../User/complaint.php";}?>">Complain</a>
    <a id="inc" href="<?php if($_SESSION['fileType'] == 1){echo "discover.php";}elseif($_SESSION['fileType'] == 2){echo "../discover.php";}?>">Store</a>
    <a id="inc" href="<?php if($_SESSION['fileType'] == 1){echo "aboutUs.php";}elseif($_SESSION['fileType'] == 2){echo "../aboutUs.php";}?>">About Us</a>
    <button onclick="Lightmode()" ondblclick="Darkmode()" id="Lightmode">Toggle Light Mode <i id="BrightIcon" class='fas fa-moon'></i></button>
</div>
    <nav id="Navbar">
    <a id="pad" onclick="Dropdown()"><i id="dropdownParent">
            <L id="line"></L>
            <L id="line"></L>
            <L id="line"></L>
        </i></a>
        <?php
        if (isset($_SESSION['userid'])) {
            if ($isadmin == true){?>
        <a href="<?php if($_SESSION['fileType'] == 1){echo "index.php";}elseif($_SESSION['fileType'] == 2){echo "../index.php";}?>" id="logo1"><img id="logo" src="<?php if($_SESSION['fileType'] == 1){echo "docs/logo.png";}elseif($_SESSION['fileType'] == 2){echo "../docs/logo.png";}?>"></a>
        <?php
        }else{?>
        <a href="<?php if($_SESSION['fileType'] == 1){echo "index.php";}elseif($_SESSION['fileType'] == 2){echo "../index.php";}?>" id="logo2"><img id="logo" src="<?php if($_SESSION['fileType'] == 1){echo "docs/logo.png";}elseif($_SESSION['fileType'] == 2){echo "../docs/logo.png";}?>"></a>
        <?php
        }
        }else{?>
        <a href="<?php if($_SESSION['fileType'] == 1){echo "index.php";}elseif($_SESSION['fileType'] == 2){echo "../index.php";}?>" id="logo3"><img id="logo" src="<?php if($_SESSION['fileType'] == 1){echo "docs/logo.png";}elseif($_SESSION['fileType'] == 2){echo "../docs/logo.png";}?>"></a>
        <?php
        }
        ?>
        <div class="ProfileThings">
            <?php
                if (isset($_SESSION['userid'])) {?>
                    <img onclick="Dropdown2()" class="user-profile-icon" src="<?php if($profilePic == ""){ if($_SESSION['fileType'] == 1){echo "docs/emptyInput.png";}elseif($_SESSION['fileType'] == 2){echo "../docs/emptyInput.png";};}else{ if($_SESSION['fileType'] == 1){echo "User/".$profilePic;}elseif($_SESSION['fileType'] == 2){echo "../User/".$profilePic;}} ?>">
                    <?php
                    if(isset($_SESSION['cart'])){
                        $count = count($_SESSION['cart']);
                        if($_SESSION['fileType'] == 1){
                            echo '<a href="User/cart.php"><i class="fa fa-shopping-cart" id="user"></i><div id="cartCount"><h1 id="cartCount">'.$count.'</h1></div></a>';
                        }elseif($_SESSION['fileType'] == 2){
                            echo '<a href="../User/cart.php"><i class="fa fa-shopping-cart" id="user"></i><div id="cartCount"><h1 id="cartCount">'.$count.'</h1></div></a>';
                        }}else{
                        echo '<a href="User/cart.php"><i class="fa fa-shopping-cart" id="user"></i><div id="cartCount"><h1 id="cartCount">0</h1></div></a>';
                    }
                    if($_SESSION['fileType'] == 1){
                        echo '<a href="User/friendz.php?friendz"><i class="fas fa-user-friends" id="user"></i></a>';
                    }elseif($_SESSION['fileType'] == 2){
                        echo '<a href="../User/friendz.php?friendz"><i class="fas fa-user-friends" id="user"></i></a>';
                    }
                    if ($isadmin == true){
                    if($_SESSION['fileType'] == 1){
                        echo '<a href="admin.php"><i class="fa fa-gear" id="user"></i></a>';
                    }elseif($_SESSION['fileType'] == 2){
                        echo '<a href="../admin.php"><i class="fa fa-gear" id="user"></i></a>';
                    }
                    }
                }else{
                    echo'
                    <a  onclick="Dropdown2()"><i class="fas fa-user-circle" id="user"></i></a>
                    ';
                }
            ?>
        </div>
    </nav>
    <!-- <img class="user-profile-icon" src="User/../docs/emptyInput.png"> -->
    
    <?php
    if (isset($_SESSION['userid'])) {
        if($_SESSION['fileType'] == 1){
            echo '
            <div id="dropdown2">
            <a id="signuplink" href="User/profile.php?setting=account">
            <i id= "SigninDrop"><h1>Profile Page</h1><i id="drop" class="fas fa-id-card"></i></i></a>
            <a href="includes/logout.inc.php">
            <i id="LoginDrop"><h1>Log Out</h1><i id="drop" class="fas fa-sign-in-alt"></i></i></a>
            </div>
            ';
        }elseif($_SESSION['fileType'] == 2){
            echo '
            <div id="dropdown2">
            <a id="signuplink" href="../User/profile.php?setting=account">
            <i id= "SigninDrop"><h1>Profile Page</h1><i id="drop" class="fas fa-id-card"></i></i></a>
            <a href="../includes/logout.inc.php">
            <i id="LoginDrop"><h1>Log Out</h1><i id="drop" class="fas fa-sign-in-alt"></i></i></a>
            </div>
            ';
        }
    }
    else    
    {
        if($_SESSION['fileType'] == 1){
            echo '
            <div id="dropdown2">
            <a id="signuplink" href="User/signup.php">
            <i id= "SigninDrop"><h1>Sing in</h1><i id="drop" class="fa fa-user"></i></i></a>
            <a href="User/login.php">
            <i id="LoginDrop"><h1>Log in</h1><i id="drop" class="fa fa-user"></i></i></a>
            </div>
            ';
        }elseif($_SESSION['fileType'] == 2){
            echo '
            <div id="dropdown2">
            <a id="signuplink" href="../User/signup.php">
            <i id= "SigninDrop"><h1>Sing in</h1><i id="drop" class="fa fa-user"></i></i></a>
            <a href="../User/login.php">
            <i id="LoginDrop"><h1>Log in</h1><i id="drop" class="fa fa-user"></i></i></a>
            </div>
            ';
        }
    }
    ?>