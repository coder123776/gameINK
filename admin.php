<?php
session_start();
$_SESSION['fileType'] = 1;
include_once('head-footer/header.php');
include_once('includes/functions.inc.php');
include_once('includes/dbh.inc.php');
if(!isset($_SESSION['userid'])) {
    header("location: index.php");
}
else
// include_once('head-footer/chatbot.php');
CheckIfBanned($conn, $uid, 1); SetBudget($conn, $uid); CheckLastTimeOnline($conn, $uid); CheckWhereLiving($conn, $uid); CheckLevel($conn, $uid);
if ($isadmin == false){
    header("location: index.php");
}

if(isset($_POST['makeAdmin'])){
    $gid = $_POST['id'];
    $gname = $_POST['user'];
    $sql = "INSERT INTO moderator (naam, gebruikerId) VALUES (?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../User/signup.php?error=stmtfailed');
    }
    mysqli_stmt_bind_param($stmt, "ss", $gname, $gid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header('location: admin.php');
    exit();
}

function showOptions($option, $post, $loc){
    echo '
    <form action="?'.$loc.'" method="post">
    <button class="noshow" type="submit" name="'.$post.'">
    <div class="admin-nav-option">
    <h1>'.$option.'</h1>
    </div>
    </button>
    </form>
    ';
}

if (isset($_POST['filterland'])){
    $adminsql = "SELECT * FROM gebruiker WHERE NOT Id = 123458 ORDER BY RAND();";
}
if (isset($_POST['filternaam'])){
    $adminsql = "SELECT * FROM gebruiker WHERE NOT Id = 123458 ORDER BY RAND();";
}
function createGame($conn, $AdminGamename, $AdminGamebeschrijving, $AdminGamegenres, $AdminGamestate, $AdminGameprijs, $AdminGamedropprijs, $AdminGamedevloper,
$AdminGamerelease, $AdminGameplatform, $AdminGamerating, $AdminGameimage, $AdminGamelogo, $AdminGamevideo, $AdminGamepegi, $AdminGamepegiImage) {
    $sql = "INSERT INTO games (naam, prijs, image, genre, Company, State, info, prijs2, image2, video, rating, platform, pegImg, pegName) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: admin.php?failed');
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssssssssssss", $AdminGamename, $AdminGameprijs, $AdminGameimage, $AdminGamegenres, $AdminGamedevloper, $AdminGamestate,
    $AdminGamebeschrijving, $AdminGamedropprijs, $AdminGamelogo, $AdminGamevideo, $AdminGamerating, $AdminGameplatform, $AdminGamepegiImage, $AdminGamepegi);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header('location: admin.php?succesgame');
    exit();
}
if (isset($_POST['makeGameProduct'])){
    $AdminGamename = $_POST['AdminGamename'];
    $AdminGamebeschrijving = $_POST['AdminGamebeschrijving'];
    $AdminGamegenres = $_POST['AdminGamegenres'];
    $AdminGamestate = $_POST['AdminGamestate'];
    $AdminGameprijs = $_POST['AdminGameprijs'];
    $AdminGamedropprijs = $_POST['AdminGamedropprijs'];
    $AdminGamedevloper = $_POST['AdminGamedevloper'];
    $AdminGamerelease = $_POST['AdminGamerelease'];
    $AdminGameplatform = $_POST['AdminGameplatform'];
    $AdminGamerating = $_POST['AdminGamerating'];
    $AdminGameimage = $_POST['AdminGameimage'];
    $AdminGamelogo = $_POST['AdminGamelogo'];
    $AdminGamevideo = $_POST['AdminGamevideo'];
    $AdminGamepegi = $_POST['AdminGamepegi'];
    $AdminGamepegiImage = "https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/PEGI_3.svg/1681px-PEGI_3.svg.png";

    $AdminGamerating = $AdminGamerating ."/10";
    if ($AdminGamepegi == "PEGI 18"){
        $AdminGamepegiImage = "https://rating.pegi.info/assets/images/games/age_threshold_icons/18.png";
    }elseif ($AdminGamepegi == "PEGI 16"){
        $AdminGamepegiImage = "https://upload.wikimedia.org/wikipedia/commons/thumb/8/8a/PEGI_16.svg/1681px-PEGI_16.svg.png";
    }elseif ($AdminGamepegi == "PEGI 12"){
        $AdminGamepegiImage = "https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/PEGI_12.svg/1200px-PEGI_12.svg.png";
    }elseif ($AdminGamepegi == "PEGI 3"){
        $AdminGamepegiImage = "https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/PEGI_3.svg/1681px-PEGI_3.svg.png";
    }

    createGame($conn, $AdminGamename, $AdminGamebeschrijving, $AdminGamegenres, $AdminGamestate, $AdminGameprijs, $AdminGamedropprijs, $AdminGamedevloper,
    $AdminGamerelease, $AdminGameplatform, $AdminGamerating, $AdminGameimage, $AdminGamelogo, $AdminGamevideo, $AdminGamepegi, $AdminGamepegiImage);
}
?>
<title>Welcome GameINK Admin</title>

<section class="admin-head">
    <div class="admin-nav-head">
        <div class="pijltjes"><i id="left3" class='fas fa-angle-left' style='font-size:24px'></i><i id="right3" class='fas fa-angle-right' style='font-size:24px'></i></div>
        <div class="admin-nav-body"><div class="admin-nav"><?php showOptions("Gebruikers", "GebruikersAdmin", "Gebruikers"); showOptions("Make Games", "GamesAdmin", "Games"); showOptions("UPD Games", "BotAdmin", "INKbot"); showOptions("Orders", "OrdersAdmin", "Orders"); showOptions("Reviews", "ReviewAdmin", "Reviews"); showOptions("Friends", "FriendAdmin", "Friends"); showOptions("Chats", "ChatAdmin", "Chats"); showOptions("Moderators", "ModeratorAdmin", "Moderators"); ?></div></div>
    </div>

    <?php 
    if (isset($_GET['Gebruikers'])){?>
    <div class="admin-body-m">
        <h1 id="admin-t">Welcome To Gebruiker TOOL</h1>
        <input id="<?php
        if (isset($_POST['filterland'])){
            echo "searchadminLand";
        }
        elseif (isset($_POST['filternaam'])){
            echo "searchadminNaam";
        }else{
            echo "searchadminElse";
        }
        ?>" class="search-Admin" type="text" placeholder="search gebruikers..">
        <div class="admin-filters">
        <form method="post"><button id="admin-option" class="noshow" type="submit" name="filterland"><div class="admin-filters-child"><h1>Filter Land</h1></div></button></form>
        <form method="post"><button id="admin-option" class="noshow" type="submit" name="filternaam"><div class="admin-filters-child"><h1>Filter naam</h1></div></button></form>
        </div>
        <div class="admin-line"></div>
        <div id="showedgebruikers" class="showedgebruikers">
        <?php showAdminGebruikers($conn, "SELECT * FROM gebruiker WHERE NOT Id = 123458 ORDER BY RAND();"); ?>
        </div>
    </div>
    <?php
    }
    if (isset($_GET['Games'])){?>
    <div class="admin-body-m">
        <h1 id="admin-t">Welcome To The Game TOOL</h1>
        <div class="admin-line"></div>
        <div class="admin-games">
        <div class="admin-game-options">
            <form action="" method="post">
            <label for="AdminGamename">THE GAME NAME</label>
            <input id="gameBodyCT1" class="admin-game-options" type="text" name="AdminGamename" placeholder="the game name..." required maxlength="100">
            <label for="AdminGamebeschrijving">THE GAME DISCRIPTION</label>
            <input id="gameBodyCB1" class="admin-game-options" type="text" name="AdminGamebeschrijving" placeholder="the game discription..." required>
            <label for="AdminGamegenres">THE GAME GENRE</label>
            <input id="gameBodyCGEN" class="admin-game-options" type="text" name="AdminGamegenres" placeholder="the game genres..." required>
            <label for="AdminGamestate">THE GAME STATE</label>
            <input id="gameBodyCSTA" class="admin-game-options" type="text" name="AdminGamestate" placeholder="the game state..." required>
            <label for="AdminGameprijs">THE GAME PRIJS</label>
            <input id="gameBodyCP1" class="admin-game-options" type="number" name="AdminGameprijs" placeholder="the game prijs..." required>
            <label for="AdminGamedropprijs">THE GAME DROP-PRIJS</label>
            <input id="gameBodyCDRP" class="admin-game-options" type="number" name="AdminGamedropprijs" placeholder="the game drop prijs..." required>
            <label for="AdminGamedevloper">THE GAME DEVELOPER</label>
            <input id="gameBodyCDEV" class="admin-game-options" type="text" name="AdminGamedevloper" placeholder="the game developer..." required>
            <label for="AdminGamerelease">THE GAME RELEASE</label>
            <input id="gameBodyCREL" class="admin-game-options" type="text" name="AdminGamerelease" placeholder="the game release..." required>
            <label for="AdminGameplatform">THE GAME PLATFORM</label>
            <input id="gameBodyCPLA" class="admin-game-options" type="text" name="AdminGameplatform" placeholder="the game platform..." required>
            <label for="AdminGamerating">THE GAME RATING</label>
            <input id="gameBodyCRAT" class="admin-game-options" type="number" name="AdminGamerating" placeholder="the game rating..." required min="1" max="10" maxlength="2">

            <label for="AdminGameimage">THE GAME IMAGE</label>
            <input id="gameBodyCI1" class="admin-game-options" type="text" name="AdminGameimage" placeholder="the game image..." required>
            <label for="AdminGamelogo">THE GAME LOGO</label>
            <input class="admin-game-options" type="text" name="AdminGamelogo" placeholder="the game logo..." required>
            <label for="AdminGamevideo">THE GAME VIDEO</label>
            <input class="admin-game-options" type="text" name="AdminGamevideo" placeholder="the game video..." required>

            <div class="admin-pegi">
                <label for="AdminGamepegi">PEGI 18</label>
                <input class="" type="radio" name="AdminGamepegi" placeholder="the game pegi..." required value="PEGI 18">
            </div>
            <div class="admin-pegi">
                <label for="AdminGamepegi">PEGI 16</label>
                <input class="" type="radio" name="AdminGamepegi" placeholder="the game pegi..." required value="PEGI 16">
            </div>
            <div class="admin-pegi">
                <label for="AdminGamepegi">PEGI 12</label>
                <input class="" type="radio" name="AdminGamepegi" placeholder="the game pegi..." required value="PEGI 12">
            </div>
            <div class="admin-pegi">
                <label for="AdminGamepegi">PEGI 3</label>
                <input class="" type="radio" name="AdminGamepegi" placeholder="the game pegi..." required value="PEGI 3">
            </div>

            <button type="submit" name="makeGameProduct" class="makeGameProduct">Make game</button>
            </form>
        </div>
        <div class="admin-game-body">
            <div class="admin-game-card">
                <img id="gameBodyCI" src="docs/adminnoimg.png">
                <h1 id="gameBodyCT">???</h1>
                <p id="gameBodyCB">???</p>
                <div class="checkpriceAdmin">
                <h1>&#128178;</h1>
                <h1 id="gameBodyCP"> ???</h1>
                </div>
            </div>
            <div class="admin-game-extras">
                <p>GENRES</p>
                <h1 id="gameBodyCGEN1">???</h1>
                <Hr id="adminextraline"></Hr>
                <p>STATE</p>
                <h1 id="gameBodyCSTA1">???</h1>
                <Hr id="adminextraline"></Hr>
                <p>DROP PRICE</p>
                <div class="checkpriceAdmin">
                <h1>&#128178;</h1>
                <h1 id="gameBodyCDRP1"> ???</h1>
                </div>
                <Hr id="adminextraline"></Hr>
                <p>DEVELOPER</p>
                <h1 id="gameBodyCDEV1">???</h1>
                <Hr id="adminextraline"></Hr>
                <p>RELEASE</p>
                <h1 id="gameBodyCREL1">???</h1>
                <Hr id="adminextraline"></Hr>
                <p>PLATFORM</p>
                <h1 id="gameBodyCPLA1">???</h1>
                <Hr id="adminextraline"></Hr>
                <p>RATING</p>
                <h1 id="gameBodyCRAT1">???</h1>
                <Hr id="adminextraline"></Hr>
                <p>PEGI</p>
                <h1 id="gameBodyCPEG1">???</h1>
                <Hr id="adminextraline"></Hr>
            </div>
        </div>
        </div>
    </div>
    <?php
    }
    elseif (isset($_GET['INKbot'])){?>
    
    <?php
    }
    elseif (isset($_GET['Reviews'])){?>
    
    <?php
    }
    elseif (isset($_GET['Orders'])){?>
    
    <?php
    }
    elseif (isset($_GET['Friends'])){?>
    
    <?php
    }
    elseif (isset($_GET['Chats'])){?>
    
    <?php
    }
    elseif (isset($_GET['Moderators'])){?>
    
    <?php
    }else{
        echo "
        <div class='welcometoadmin'>
        <h1>Welcome to The admin Tools</h1>
        </div>";
    }
    ?>


</section>

<script src="path/to/confetti.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

$(document).ready(function() {

$('#gameBodyCI1').on('input', function() {
        if ($(this).val().trim() === '') {
            $('#gameBodyCI').attr('src', 'docs/adminnoimg.png');
        } else {
            $('#gameBodyCI').attr('src', $(this).val());
        }
    });
});

$('input[type="radio"]').on('change', function() {
  var selectedValue = $('input[type="radio"]:checked').val();
  
  if(selectedValue === undefined) {
    // if none of the radio inputs are selected
    $('#gameBodyCPEG1').text('???');
  } else {
    $('#gameBodyCPEG1').text(selectedValue);
  }
});


function updateInputValue(input, element) {
  if (input.val().trim() === '') {
    element.text('???');
  } else {
    element.text(input.val());
  }
}

$('#gameBodyCT1').on('input', function() {
  updateInputValue($(this), $('#gameBodyCT'));
});

$('#gameBodyCB1').on('input', function() {
  updateInputValue($(this), $('#gameBodyCB'));
});

$('#gameBodyCP1').on('input', function() {
  updateInputValue($(this), $('#gameBodyCP'));
});

$('#gameBodyCGEN').on('input', function() {
  updateInputValue($(this), $('#gameBodyCGEN1'));
});

$('#gameBodyCSTA').on('input', function() {
  updateInputValue($(this), $('#gameBodyCSTA1'));
});

$('#gameBodyCDRP').on('input', function() {
  updateInputValue($(this), $('#gameBodyCDRP1'));
});

$('#gameBodyCDEV').on('input', function() {
  updateInputValue($(this), $('#gameBodyCDEV1'));
});

$('#gameBodyCREL').on('input', function() {
  updateInputValue($(this), $('#gameBodyCREL1'));
});

$('#gameBodyCPLA').on('input', function() {
  updateInputValue($(this), $('#gameBodyCPLA1'));
});

$('#gameBodyCRAT').on('input', function() {
  updateInputValue($(this), $('#gameBodyCRAT1'));
});

$(document).ready(function(){
    $("#searchadminElse").keyup(function(){
            var input = $(this).val();
            if(input != ""){
            $.ajax({
                    url:"includes/search.inc.php",
                    method:"post",
                    data:{searchAdmin1:input},
                    success:function(data){
                    $("#showedgebruikers").html(data);
                    $("#showedgebruikers").css("display", "flex");
                    }
            });
            }
    });
    $("#searchadminNaam").keyup(function(){
            var input = $(this).val();
            if(input != ""){
            $.ajax({
                    url:"includes/search.inc.php",
                    method:"post",
                    data:{searchAdmin2:input},
                    success:function(data){
                    $("#showedgebruikers").html(data);
                    $("#showedgebruikers").css("display", "flex");
                    }
            });
            }
    });
    $("#searchadminLand").keyup(function(){
            var input = $(this).val();
            if(input != ""){
            $.ajax({
                    url:"includes/search.inc.php",
                    method:"post",
                    data:{searchAdmin3:input},
                    success:function(data){
                    $("#showedgebruikers").html(data);
                    $("#showedgebruikers").css("display", "flex");
                    }
            });
            }
    });
});

$(document).ready(function() {
  var originalMarginLeft = parseFloat($('.admin-nav').css('margin-left'));
  var clickCount = 0;

  $('#right3').click(function() {
    if (clickCount < 2) {
      clickCount++;
      originalMarginLeft -= 70.25;
      $('.admin-nav').css('margin-left', originalMarginLeft + 'vw');
      $('#right3').css({ 'border': '0.1vh solid var(--RGB-255)' });
    }
    if (clickCount === 2) {
        $('#right3').css('border','none');
        $('#right3').prop('disabled', true);
    }
  });

  $('#left3').click(function() {
    if (clickCount > 0) {
      clickCount--;
      originalMarginLeft += 70.25;
      $('.admin-nav').css('margin-left', originalMarginLeft + 'vw');
      $('#left3').css({ 'border': '0.1vh solid var(--RGB-255)' });
    }
    if (clickCount === 0) {
        $('#left3').css('border','none');
        $('#right3').prop('disabled', false);
    }
  });
});
</script>


<?php
include_once('head-footer/footer.php');

if (isset($_GET['succesgame'])){
    echo "<script>alert('you succesful made the game')</script>";
}
?>