<?php
session_start();
$_SESSION['fileType'] = 1;
$checkifuserExist = false;
include_once('head-footer/header.php');
include_once('includes/functions.inc.php');
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
if (isset($_SESSION['userid'])){
    CheckIfBanned($conn, $uid, 1); SetBudget($conn, $uid); CheckLastTimeOnline($conn, $uid); CheckWhereLiving($conn, $uid); CheckOwnedProducts($conn, $uid); CheckLevel($conn, $uid);
    include_once('head-footer/chatbot.php');
    $checkifuserExist = true;
}
// botToSql($conn, "hebben jullie apex", 1);
// print_r($_SESSION['ownedgamesImg']);
?>
<!-- <iframe id="" height="200px" width="400px" src="https://www.youtube.com/embed/HGtyzEGcW3k?autoplay=1&mute=1&controls=0&showinfo=0&loop=1&playlist=HGtyzEGcW3k" frameborder="0"></iframe> -->
    <!-- <iframe id="" height="200px" width="400px" src="docs/cod.trailer.mp4"></iframe> -->
    <!-- <iframe id="" height="200px" width="400px" src="docs/cod.trailer.mp4?autoplay=1&mute=1&controls=0&loop=1" frameborder="0"></iframe> -->

<title>Welcome at GameINK</title>
<section id="oneIndex">
    <div class="main-banner" id="main-banner">
        <div class="imgban" id="imgban1"><video  class="vidban" src="docs/cod.trailer.mp4" loop muted autoplay="autoplay"></video></div>
        <div class="imgban" id="imgban2"><video  class="vidban" src="docs/minec.trailer.mp4" loop muted autoplay="autoplay"></video></div>
        <div class="imgban" id="imgban3"><video  class="vidban" src="docs/apex.trailer.mp4" loop muted autoplay="autoplay"></video></div>
        <div class="imgban" id="imgban4"><video id="getridof"  class="vidban" src="docs/gta.trailer.mp4" loop muted autoplay="autoplay"></video></div>
    </div>
        <div class="Side">
            <?php 
            if ($checkifuserExist == true) {
                echo '<h1 id="welcome">welcome '.$username.'</h1><div id="inform"><h1>you may want to play..</h1>';
            }
            else
            {
                echo '<h1 id="welcome">welcome</h1><div id="inform"><h1>you may want to play..</h1> ';
            }
            ?>
            <div id="RecGames">
            <h1 id="recGameH1">Call of Duty: Modern Warfare II</h1>
            <p id="recGameP">Call of Duty: Modern Warfare II is a 2022 first-person shooter game developed by Infinity Ward and published by Activision. It is a sequel to the 2019 reboot, and serves as the nineteenth installment in the overall Call of Duty series.</p>
            <div class="banner-line-parent"> <div onclick="bn(1)" class="banner-line" id="bnrLine1"></div> <div onclick="bn(2)" class="banner-line" id="bnrLine2"></div>
            <div onclick="bn(3)" class="banner-line" id="bnrLine3"></div> <div onclick="bn(4)" class="banner-line" id="bnrLine4"></div></div></div></div>
    </section>
    <div id="HeightCorrection"><div class="line"></div>
    <div class="HeightCorrection-2"><h1 id="txt-2">INK</h1><h1 id="txt-1">Game</h1>
    <?php
    if (isset($_SESSION['userid'])){
    foreach ($admins as $admin){
        if ($admin == $uid){
            echo '<h1 id="txt-1">Welcome Admin &nbsp;&nbsp;&nbsp;</h1>';
        }
    }
    // if ($uid == $admin1 || $uid == $admin2 || $uid == $admin3 || $uid == $admin4) {
    //     echo '<h1 id="txt-1">Welcome Admin &nbsp;&nbsp;&nbsp;</h1>';
    // }
    }
    ?>
    </div></div>

    <!-- GAMES SECTION ----------------------------------------------------------------------------------------------------------------------->

    <form action="" method="post"></form> 
    <section id="spotlight">
        <nav id="Fade6" class="Spotlight">
            <h1 id="spotlightTxt"><?php echo date('F') ?> Spotlight games<a id="spotlightTxt" href="discover.php">View More</a></h1>
            <i id="left1" class='fas fa-angle-left' style='font-size:24px'></i>
            <i id="right1" class='fas fa-angle-right' style='font-size:24px'></i>
        </nav>

        <div class="spotlight1-parent"><div id="Fade1" class="spotlight1"> <?php GameDisplay($conn, 'TRENDING', 1); ?> </div></div>
        <div id="Fade2" class="spotlight11"> <?php GameDisplay($conn, 'TRENDING2', 2); ?> </div>
        <nav class="nav-spotlight2">
            <h1 id="spotlightTxt">Populaire games<a id="spotlightTxt" href="discover.php?filter=Pgames">View More</a></h1>
            <i id="left2" class='fas fa-angle-left' style='font-size:24px'></i>
            <i id="right2" class='fas fa-angle-right' style='font-size:24px'></i>
        </nav>

        <div class="spotlight1-parent"><div id="Fade3" class="spotlight2"> <?php GameDisplay($conn, 'POPULAR', 3); ?> </div></div>
        <div id="Fade4" class="Spotlight3">
        <nav id="Fade8" class="Spotlight22"><h1 id="spotlightTxt2">Now Free games</h1></nav><div id="spotlight4" class="spot4"> <?php GameDisplay($conn, 'FREE', 4); ?> </div></div>

        <div id="Fade5" class="Spotlight5"><img id="gameImage5" src="docs/GameIdCatalog.png">
        <div class="exploreC"><h1 id="exploreCtitle">Explore our catalog</h1><h1 id="exploreCinfo">catalog info</h1><button id="exploreCbutton"><a href="discover.php">BROWSE ALL</a></button></div></div>
    </section>
    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  var originalMarginLeft = parseFloat($('.spotlight1').css('margin-left'));
  var clickCount = 0;

  $('#right1').click(function() {
    if (clickCount < 2) {
      clickCount++;
      originalMarginLeft -= 81.25;
      $('.spotlight1').css('margin-left', originalMarginLeft + 'vw');
      $('#right1').css({ 'border': '0.1vh solid var(--RGB-255)' });
    }
    if (clickCount === 2) {
        $('#right1').css('border','none');
        $('#right1').prop('disabled', true);
    }
  });

  $('#left1').click(function() {
    if (clickCount > 0) {
      clickCount--;
      originalMarginLeft += 81.25;
      $('.spotlight1').css('margin-left', originalMarginLeft + 'vw');
      $('#left1').css({ 'border': '0.1vh solid var(--RGB-255)' });
    }
    if (clickCount === 0) {
        $('#left1').css('border','none');
        $('#right1').prop('disabled', false);
    }
  });

  var originalMarginLeft2 = parseFloat($('.spotlight1').css('margin-left'));
  var clickCount2 = 0;

  $('#right2').click(function() {
    if (clickCount2 < 2) {
      clickCount2++;
      originalMarginLeft2 -= 81.25;
      $('.spotlight2').css('margin-left', originalMarginLeft2 + 'vw');
      $('#right2').css({ 'border': '0.1vh solid var(--RGB-255)' });
    }
    if (clickCount2 === 2) {
        $('#right2').css('border','none');
        $('#right2').prop('disabled', true);
    }
  });

  $('#left2').click(function() {
    if (clickCount2 > 0) {
      clickCount2--;
      originalMarginLeft2 += 81.25;
      $('.spotlight2').css('margin-left', originalMarginLeft2 + 'vw');
      $('#left2').css({ 'border': '0.1vh solid var(--RGB-255)' });
    }
    if (clickCount2 === 0) {
        $('#left2').css('border','none');
        $('#right2').prop('disabled', false);
    }
  });
});



function swipeL1(){
    var card = document.getElementsByClassName("card1");
    card.style.opacity = 0;
}
function swipeR1(){
    
}

var bannerStatus = 1;

function bn(nmr) {
    bannerStatus = nmr;
}
document.getElementById("getridof").src = "";

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
            document.getElementById("recGameH1").innerHTML = "Call of Duty: Modern Warfare II";
            document.getElementById("recGameP").innerHTML = "Call of Duty: Modern Warfare II is a 2022 first-person shooter game developed by Infinity Ward and published by Activision. It is a sequel to the 2019 reboot, and serves as the nineteenth installment in the overall Call of Duty series.";
        }, 1300);
    }
    else if (bannerStatus === 2) {
        document.getElementById("getridof").src = "docs/gta.trailer.mp4";
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
    }, 4000);
        bannerStatus = 3;
        setTimeout(function(){
            document.getElementById("bnrLine1").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine2").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine3").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine4").style.backgroundColor = "rgb(20, 20, 20)";
            document.getElementById("bnrLine2").style.backgroundColor = "rgb(255, 255, 255)";
            document.getElementById("recGameH1").innerHTML = "Minecraft";
            document.getElementById("recGameP").innerHTML = "Minecraft is a 3D sandbox game developed by Mojang Studios where players interact with a fully modifiable three-dimensional environment made of blocks and entities. Its diverse gameplay lets players choose the way they play, allowing for countless possibilities.";
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
            document.getElementById("recGameH1").innerHTML = "Apex Legends";
            document.getElementById("recGameP").innerHTML = "Apex Legends is a battle royale game developed by Respawn Entertainment and published by EA. The free game was released on February 4, 2019 for PlayStation 4, Windows and Xbox One. It also became available for Nintendo Switch in 2021";
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
            document.getElementById("recGameH1").innerHTML = "Grand Theft Auto";
            document.getElementById("recGameP").innerHTML = "Apex Legends is a battle royale game developed by Respawn Entertainment and published by EA. The free game was released on February 4, 2019 for PlayStation 4, Windows and Xbox One. It also became available for Nintendo Switch in 2021";
        }, 1300);
    }
}
bannerLoop();

window.addEventListener('load', check_fade_in);
window.addEventListener('scroll', check_fade_in);

window.onload=function(){
var startLoop = setInterval(function() {
    bannerLoop();
}, 4000);
}
</script>

<?php
include_once('head-footer/footer.php');
?>