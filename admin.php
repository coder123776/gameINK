<?php
session_start();
$_SESSION['fileType'] = 1;
include_once('head-footer/header.php');
include_once('includes/functions.inc.php');
include_once('includes/dbh.inc.php');
$_SESSION['fileType'] = 1;
if(!isset($_SESSION['userid'])) {
    header("location: index.php");
}
else
include_once('head-footer/chatbot.php');
CheckIfBanned($conn, $uid, 1); SetBudget($conn, $uid); CheckLastTimeOnline($conn, $uid); CheckWhereLiving($conn, $uid); CheckLevel($conn, $uid);
if($uid == $admin1 || $uid == $admin2 || $uid == $admin3 || $uid == $admin4){
}else{
    header("location: index.php");
}
?>
<title>Welcome GameINK Admin</title>
<div class="admin-product">
    <h1>Gamebuilder TOOL (READ BELOW FIRST)</h1>
    <p>
        Hey Admin! READ THIS FIRST!! .you can use the colums here below to add products to the site.
         its easy to understand but some things don't so i will explain it.<br>
        1. game name: just a game name of a game doesent matter witch one.<br>
        2. game price: just a game price of a game doesent matter how much but don't make it ridicilous.<br>
        3. game discount: discount of the price just a lower price of the current price.<br>
        4. game image: the image of the game. make sure the height is minimum 1.5x higher than the width. plus the image must come from a link.<br>
        6. game image logo: the logo of the game from a link.<br>
        7. game video: go to youtube and find a trailer, when you are there and go to the link. you will see this in it (watch?v=(id)) you need to copy the id.<br>
        8. game genre: genre like action simulation, casual.<br>
        9. game pegi name: the name of the pegi like: PEGI 18 or PEGI 16 or PEGI 3 etc.. MAKE SURE ITS CAPS<br>
        10. game pegi img: a image of a pegi laber, just search on google the pegi and you will see it.<br>
        11. game state: the game state like: POPULAR TRENING FREE etc.. (MAKE SURE ITS IN CAPS).<br>
        12. game info: a game information just copy/paste it from a site or google.<br>
        13. game company: the company that maked the game.<br>
        14. game Rating: hot good the game is from 0/10 to 10/10.<br>
        15. game release: the date of the release date for example: 15 January 2023.<br>
        16. game platform: the platfom where you can play it on like: windows, playstation, mobile etc....<br>
        <br>
        make sure everything goes good or you will get a warning and all will be removed. (so make a copy if this your first time or some)
    </p>
    <form id="game-tool" action="includes/admin.inc.php" method="post">
    <label for="gamename">Game Name (example: Returnal™)</label>
    <input id="game-builder" type="text" name="gamename" placeholder="Game Name..." required="" maxlength="60">
    <label for="gameprice">Game Price (example: 59)</label>
    <input type="number" id="game-builder" type="text" name="gameprice" placeholder="Game Price..." required="" maxlength="3">
    <label for="gamename">Game Discount (example: 25)</label>
    <input type="number" id="game-builder" type="text" name="gameprice2" placeholder="Game (Discount)..." required="" maxlength="3">
    <label for="gameimage">Game image (example: https://image.api.playstation.com/vulcan/ap/rnd/202011/0415/baDQkNRWTpSLNwtdHbw09SUs.jpg)</label>
    <input id="game-builder" type="text" name="gameimage" placeholder="Game Image..." required="">
    <label for="gameimage2">Game Image Logo (example: https://www.goha.ru/s/f/Ca/6V/ocCPzyDElT.jpg)</label>
    <input id="game-builder" type="text" name="gameimage2" placeholder="Game Image (logo)..." required="">
    <label for="gamevideo">Game Video (example: OKZV00Esu54)</label>
    <input id="game-builder" type="text" name="gamevideo" placeholder="Game Video..." required="" maxlength="25">
    <label for="gamegenre">Game Genre (example: action adventure)</label>
    <input id="game-builder" type="text" name="gamegenre" placeholder="Game Genre..." required="">
    <label for="gamepegname">Game Pegi name (example: PEGI 18)</label>
    <input id="game-builder" type="text" name="gamepegname" placeholder="Game Pegi name..." required="" maxlength="7">
    <label for="gamepegimg">Game Pegi img (example: https://upload.wikimedia.org/wikipedia/commons/thumb/7/75/PEGI_18.svg/1677px-PEGI_18.svg.png)</label>
    <input id="game-builder" type="text" name="gamepegimg" placeholder="Game Pegi img..." required="">
    <label for="gamestate">Game State (example: TRENDING)</label>
    <input id="game-builder" type="text" name="gamestate" placeholder="Game State..." required="">
    <label for="gameinfo">Game Info (example: (game info this would be too long))</label>
    <input id="game-builder" type="text" name="gameinfo" placeholder="Game info..." required="">
    <label for="gamecompany">Game Company (example: Housemarque, Climax Studios)</label>
    <input id="game-builder" type="text" name="gamecompany" placeholder="Game company..." required="">
    <label for="gamerating">Game Rating (example: 8/10)</label>
    <input  id="game-builder" type="text" name="gamerating" placeholder="Game rating..." required="" maxlength="5">
    <label for="gamerelease">Game Release (example: 23 March 2014)</label>
    <input id="game-builder" type="text" name="gamerelease" placeholder="Game release..." required="" maxlength="16">
    <label for="gameplatform">Game Platform (example: Windows Playstation)</label>
    <input id="game-builder" type="text" name="gameplatform" placeholder="Game platform..." required="">
    <button type="submit" name="addGame" id="game-builder">Make Product</button>
    </form>
</div>

<div class="admin-unban">
<h1>Unbanning TOOL</h1>
<form action="includes/admin.inc.php" method="post">
<input id="admin-unban" type="text" name="unbanInp" placeholder="Username to get unbanned..." maxlength="13">
<button type="submit" name="unban" id="admin-unban">Unban User</button>
</form>
</div>

<?php
include_once('head-footer/footer.php');
?>