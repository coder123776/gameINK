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

function showOptions($option, $post){
    echo '
    <form action="?'.$option.'" method="post">
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
    
}
?>
<title>Welcome GameINK Admin</title>

<section class="admin-head">
    <div class="admin-nav-head">
        <div class="pijltjes"><i id="left3" class='fas fa-angle-left' style='font-size:24px'></i><i id="right3" class='fas fa-angle-right' style='font-size:24px'></i></div>
        <div class="admin-nav-body"><div class="admin-nav"><?php showOptions("Gebruikers", "GebruikersAdmin"); showOptions("Games", "GamesAdmin"); showOptions("INKbot", "BotAdmin"); showOptions("Reviews", "ReviewAdmin"); showOptions("Orders", "OrdersAdmin"); showOptions("Friends", "FriendAdmin"); showOptions("Chats", "ChatAdmin"); showOptions("Moderators", "ModeratorAdmin"); ?></div></div>
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

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
?>