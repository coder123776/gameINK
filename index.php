<?php
include_once('head-footer/header.php');
include_once('includes/functions.inc.php');
include_once('includes/dbh.inc.php');
$_SESSION['fileType'] = 1;
?>
    <?php
    if (isset($_POST['add'])){
        if(!isset($_SESSION['userid'])) {
            header("location: User/login.php?error=loginfirst");
        }else{
        if (isset($_SESSION['cart'])){
            $_SESSION['CurrentGame'] = $_POST['productId'];
            header("location: User/game.php");
        }else{
            $item_ary = array('productId' => $_POST['productId']);
            $_SESSION['cart'][0] = $item_ary;
            $_SESSION['CurrentGame'] = $_POST['productId'];
            header("location: User/game.php");
        }
    }
}
?> 
<title>Welcome at GameINK</title>
<section id="oneIndex">
    <div class="main-banner" id="main-banner"><div class="imgban" id="imgban4"></div><div class="imgban" id="imgban3"></div>
    <div class="imgban" id="imgban2"></div><div class="imgban" id="imgban1"></div></div>
        <div class="Side">
            <?php 
            if (isset($_SESSION['userid'])) {
                include_once('head-footer/chatbot.php');
                CheckIfBanned($conn, $uid, 1); SetBudget($conn, $uid); CheckLastTimeOnline($conn, $uid); CheckWhereLiving($conn, $uid);
                echo '<h1 id="welcome">welcome '.$username.'</h1><div id="inform"><h1>you may want to play..</h1>';
            }
            else
            {
                echo '<h1 id="welcome">welcome</h1><div id="inform"><h1>you may want to play..</h1> ';
            }
            ?>
            <div id="RecGames">
            <h1 id="recGameH1">Grand Theft Auto</h1>
            <p id="recGameP">Grand Theft Auto is a series of action-adventure games created by David Jones and Mike Dailly. Later titles were developed under the oversight of brothers Dan and Sam Houser, Leslie Benzies and Aaron Garbut.</p>
            <div class="banner-line-parent"> <div onclick="bn(1)" class="banner-line" id="bnrLine1"></div> <div onclick="bn(2)" class="banner-line" id="bnrLine2"></div>
            <div onclick="bn(3)" class="banner-line" id="bnrLine3"></div> <div onclick="bn(4)" class="banner-line" id="bnrLine4"></div></div></div></div>
    </section>
    <div id="HeightCorrection"><div class="line"></div>
    <div class="HeightCorrection-2"><h1 id="txt-2">INK</h1><h1 id="txt-1">Game</h1>
    <?php
    if (isset($_SESSION['userid'])){
    if ($uid == $admin1 || $uid == $admin2 || $uid == $admin3 || $uid == $admin4) {
        echo '<h1 id="txt-1">Welcome Admin &nbsp;&nbsp;&nbsp;</h1><a id=admin-link href="admin.php">Admin TOOL</a>';
    }
    }
    ?>
    </div></div>

    <!-- GAMES SECTION ----------------------------------------------------------------------------------------------------------------------->

    <form action="" method="post"></form>
    <section id="spotlight">
        <nav id="Spotlight"><h1 id="spotlightTxt"><?php echo date('F') ?> Spotlight games<a id="spotlightTxt" href="discover.php">View More</a></h1></nav>
        <div class="spotlight1">
            <?php GameDisplay($conn, 'TRENDING', 1); ?>
        </div>
        <div class="spotlight2">
        <?php GameDisplay($conn, 'TRENDING2', 2); ?>
        </div>
        <nav id="Spotlight2"><h1 id="spotlightTxt">Populaire games<a id="spotlightTxt" href="discover.php?filter=Pgames">View More</a></h1></nav>
        <div class="spotlight2">
        <?php GameDisplay($conn, 'POPULAR', 3); ?>
        </div>
        <div class="Spotlight3"><nav id="Spotlight22"><h1 id="spotlightTxt2">Now Free games</h1></nav>
        <div class="spot4">
        <?php GameDisplay($conn, 'FREE', 4); ?>
        </div></div>

        <div class="Spotlight5"><img id="gameImage5" src="docs/GameIdCatalog.png">
        <div class="exploreC"><h1 id="exploreCtitle">Explore our catalog</h1><h1 id="exploreCinfo">catalog info</h1><button id="exploreCbutton"><a href="discover.php">BROWSE ALL</a></button></div></div>
    </section>

<script>

var bannerStatus = 1;

function bn(nmr) {
    bannerStatus = nmr;
}

function bannerLoop() {

    if (bannerStatus === 1) {
        document.getElementById("imgban2").style.opacity = "0";
        setTimeout(function() {
        document.getElementById("imgban1").style.right = "0%";
        document.getElementById("imgban1").style.zIndex = "1000";
        document.getElementById("imgban2").style.right = "-100%";
        document.getElementById("imgban2").style.zIndex = "1500";
        document.getElementById("imgban3").style.right = "-200%";
        document.getElementById("imgban3").style.zIndex = "500";
        document.getElementById("imgban4").style.right = "100%";
        document.getElementById("imgban4").style.zIndex = "100";
    }, 1000);
    setTimeout(function(){
        document.getElementById("imgban2").style.opacity = "1";
    }, 4000);
        bannerStatus = 2;
        setTimeout(function(){
            document.getElementById("bnrLine1").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine2").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine3").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine4").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine1").style.backgroundColor = "rgb(255, 255, 255)";
            document.getElementById("recGameH1").innerHTML = "Grand Theft Auto";
            document.getElementById("recGameP").innerHTML = "Grand Theft Auto is a series of action-adventure games created by David Jones and Mike Dailly. Later titles were developed under the oversight of brothers Dan and Sam Houser, Leslie Benzies and Aaron Garbut.";
        }, 1300);
    }
    else if (bannerStatus === 2) {
        document.getElementById("imgban3").style.opacity = "0";
        setTimeout(function() {
        document.getElementById("imgban2").style.right = "0%";
        document.getElementById("imgban2").style.zIndex = "1000";
        document.getElementById("imgban3").style.right = "-100%";
        document.getElementById("imgban3").style.zIndex = "1500";
        document.getElementById("imgban4").style.right = "-200%";
        document.getElementById("imgban4").style.zIndex = "500";
        document.getElementById("imgban1").style.right = "100%";
        document.getElementById("imgban1").style.zIndex = "100";
    }, 1000);
    setTimeout(function(){
        document.getElementById("imgban3").style.opacity = "1";
    }, 2000);
        bannerStatus = 3;
        setTimeout(function(){
            document.getElementById("bnrLine1").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine2").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine3").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine4").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine2").style.backgroundColor = "rgb(255, 255, 255)";
            document.getElementById("recGameH1").innerHTML = "Apex Legends";
            document.getElementById("recGameP").innerHTML = "Apex Legends is a battle royale game developed by Respawn Entertainment and published by EA. The free game was released on February 4, 2019 for PlayStation 4, Windows and Xbox One. It also became available for Nintendo Switch in 2021";
        }, 1300);
    }
    else if (bannerStatus === 3) {
        document.getElementById("imgban4").style.opacity = "0";
        setTimeout(function() {
        document.getElementById("imgban3").style.right = "0%";
        document.getElementById("imgban3").style.zIndex = "1000";
        document.getElementById("imgban4").style.right = "-100%";
        document.getElementById("imgban4").style.zIndex = "1500";
        document.getElementById("imgban1").style.right = "-200%";
        document.getElementById("imgban1").style.zIndex = "500";
        document.getElementById("imgban2").style.right = "100%";
        document.getElementById("imgban2").style.zIndex = "100";
    }, 1000);
    setTimeout(function(){
        document.getElementById("imgban4").style.opacity = "1";
    }, 4000);
        bannerStatus = 4;
        setTimeout(function(){
            document.getElementById("bnrLine1").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine2").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine3").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine4").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine3").style.backgroundColor = "rgb(255, 255, 255)";
            document.getElementById("recGameH1").innerHTML = "EA Sports FIFA 23";
            document.getElementById("recGameP").innerHTML = "FIFA 23 is a football simulation game from the FIFA computer game series. The game was released on September 30, 2022. This time, Kylian Mbappé appears on the cover of all editions together with Sam Kerr.";
        }, 1300);
    }
    else if (bannerStatus === 4) {
        document.getElementById("imgban1").style.opacity = "0";
        setTimeout(function() {
        document.getElementById("imgban4").style.right = "0%";
        document.getElementById("imgban4").style.zIndex = "1000";
        document.getElementById("imgban1").style.right = "-100%";
        document.getElementById("imgban1").style.zIndex = "1500";
        document.getElementById("imgban2").style.right = "-200%";
        document.getElementById("imgban2").style.zIndex = "500";
        document.getElementById("imgban3").style.right = "100%";
        document.getElementById("imgban3").style.zIndex = "100";
    }, 1000);
    setTimeout(function(){
        document.getElementById("imgban1").style.opacity = "1";
    }, 4000);
        bannerStatus = 1;
        setTimeout(function(){
            document.getElementById("bnrLine1").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine2").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine3").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine4").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine4").style.backgroundColor = "rgb(255, 255, 255)";
            document.getElementById("recGameH1").innerHTML = "The Last of Us Part II";
            document.getElementById("recGameP").innerHTML = "The Last of Us Part II is a 2020 action-adventure game developed by Naughty Dog and published by Sony Interactive Entertainment for the PlayStation 4.";
        }, 1300);
    }
}
bannerLoop();

window.onload=function(){
var startLoop = setInterval(function() {
    bannerLoop();
}, 4000);
}
</script>

<?php
include_once('head-footer/footer.php');
?>