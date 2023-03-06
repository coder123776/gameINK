<?php
session_start();

if(isset($_SESSION['userid'])) {
    $username = $_SESSION["user"];
    $email = $_SESSION["email"];
    $uid = $_SESSION["userid"];
    $name = $_SESSION['name'];
    $profilePic = $_SESSION['profilePic'];
}
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>GameINK</title> -->
    <link rel="stylesheet" href="../css/index.css">
    <link rel="icon" type="image/x-icon" href="../docs/logoWeb.png">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Rubik:ital@1&display=swap" rel="stylesheet">
    <script src="../app.js"></script>
</head>
<div id="dropdown1">
    <div class="Searchbar">
        <form id="searchBar" action="">
            <button type="submit"><i class="fa fa-search"></i></button>
            <input disabled type="text" placeholder="Search GameINK..." name="search">
        </form>
    </div>
    <a id="inc" href="../index.php">Home</a>
    <a id="inc" href="../User/profile.php?setting=account">Profile</a>
    <a id="inc" href="../User/friendz.php?friendz">Friends</a>
    <a id="inc" href="../User/complaint.php">Complain</a>
    <a id="inc" href="../discover.php">Store</a>
    <a id="inc" href="../User/cart.php">Cart</a>
    <button id="Lightmode">Toggle Light Mode <i id="BrightIcon" class='fas fa-moon'></i></button>
</div>
    <nav id="Navbar">
    <a id="pad" onclick="Dropdown()"><i id="dropdownParent">
            <L id="line"></L>
            <L id="line"></L>
            <L id="line"></L>
        </i></a>
        <a href="../index.php" id="logo"><img id="logo" src="../docs/logo.png"></a>
        <div class="ProfileThings">
            <?php
                if (isset($_SESSION['userid'])) {?>
                    <img onclick="Dropdown2()" class="user-profile-icon" src="<?php if($profilePic == ""){echo "../docs/emptyInput.png";}else{echo $profilePic;} ?>">
                    <?php
                    if(isset($_SESSION['cart'])){
                        $count = count($_SESSION['cart']);
                        echo '<a href="../User/cart.php"><i class="fa fa-shopping-cart" id="user"></i><div id="cartCount"><h1 id="cartCount">'.$count.'</h1></div></a>';
                    }
                    else
                    {
                        echo '<a ><i class="fa fa-shopping-cart" id="user"></i><div id="cartCount"><h1 id="cartCount">0</h1></div></a>';
                    }

        
                    echo'<a href="../User/friendz.php?friendz"><i class="fas fa-user-friends" id="user"></i></a>';
                }
                else
                {
                    echo'
                    <a  onclick="Dropdown2()"><i class="fas fa-user-circle" id="user"></i></a>
                    ';
                }
            ?>
        </div>
    </nav>
    
    <?php
    if (isset($_SESSION['userid'])) {
        echo '
        <div id="dropdown2">
        <a id="signuplink" href="../User/profile.php?setting=account">
        <i id= "SigninDrop"><h1>Profile Page</h1><i id="drop" class="fas fa-id-card"></i></i></a>
        <a href="../includes/logout.inc.php">
        <i id="LoginDrop"><h1>Log Out</h1><i id="drop" class="fas fa-sign-in-alt"></i></i></a>
        </div>
        ';
    }
    else    
    {
        echo '
        <div id="dropdown2">
        <a id="signuplink" href="../User/signup.php">
        <i id= "SigninDrop"><h1>Sing in</h1><i id="drop" class="fa fa-user"></i></i></a>
        <a href="../User/login.php">
        <i id="LoginDrop"><h1>Log in</h1><i id="drop" class="fa fa-user"></i></i></a>
        </div>
        ';
    }
    ?>