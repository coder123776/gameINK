<?php
include_once('../head-footer/EXheader.php');
include_once('../includes/functions.inc.php');
include_once('../includes/dbh.inc.php');
$_SESSION['fileType'] = 2;
$_SESSION['firstTime'] = true;

if(!isset($_SESSION['userid'])) {
    header("location: ../User/login.php?error=loginfirst");
}else{
        CheckIfBanned($conn, $uid, 2);
        SetBudget($conn, $uid);
        include_once('../head-footer/chatbot.php');
    if (isset($_SESSION['cart'][0])) {
        if ($_SESSION['firstTime'] == true){
            $_SESSION['firstTime'] = false;
        }
    }
        $item_ary_id = array_column($_SESSION['cart'], 'productId');

    if (isset($_POST['set'])){
        if(in_array($_POST['productId'], $item_ary_id)){
            echo "<script>alert('product already in cart');</script>";
        }else{
            $count = count($_SESSION['cart']);
            $item_ary = array('productId' => $_POST['productId']);
            $_SESSION['cart'][$count] = $item_ary;
            header("location: ../User/cart.php");
        }
    }
    if (isset($_POST['buy'])){
        $gameId = $_SESSION['CurrentGame'];
        $ownedgame = mysqli_query($conn, "SELECT Id, bestelnaam, gebruikerId FROM orders WHERE gebruikerId = ".$uid." AND gameId = ".$gameId.";");
        if (mysqli_num_rows($ownedgame)>0) {
            echo "<script> alert('you already own this game')</script>";
            }
        elseif(in_array($_POST['productId'], $item_ary_id)){
            header("location: ../User/game.php?doing=buying");
        }else{
            header("location: ../User/game.php?doing=buying");
        }
    }
    
}

if (isset($_GET['doing'])){
    if($_GET['doing'] == 'buying'){
        if(isset($_GET['codefound'])){
            $codetext = "you submittet the right code";
        }elseif(isset($_GET['codenotfound'])){
            $codetext = "your code was wrong";
        }else{
            $codetext = "";
        }
        $result = getData($conn, "SELECT * FROM games");
        $gameId = $_SESSION['CurrentGame'];
        $budget = $_SESSION['budget'];
        $btn = '<div class="bestelling-price"><p>when clicking "buy product" I accept that I am 18 years older and I know that no returns are possible.</p><button type="submit" name="buyGameGame">Buy Product</button></div>';
        $cls = '<button type="submit" name="closeGame"><i class="fa fa-close"></i></button>';
        $total = 0;

        while ($row = mysqli_fetch_assoc($result)){
            if($row['Id'] == $gameId){
                $total = $total + (int)$row['prijs'];
                $total = $total / 100 * 130;
                buyGameScreen($conn, $username, $budget, $total, 2, $btn, $cls, $uid, "", $codetext);
            }
        }
    }
    if($_GET['doing'] == 'nomony'){
        if(isset($_GET['codefound'])){
            $codetext = "you submittet the right code";
        }elseif(isset($_GET['codenotfound'])){
            $codetext = "your code was wrong";
        }else{
            $codetext = "";
        }
        $result = getData($conn, "SELECT * FROM games");
        $gameId = $_SESSION['CurrentGame'];
        $budget = $_SESSION['budget'];
        $btn = '<div class="bestelling-price"><p>when clicking "buy product" I accept that I am 18 years older and I know that no returns are possible.</p><button type="submit" name="buyGameGame">Buy Product</button></div>';
        $cls = '<button type="submit" name="closeGame"><i class="fa fa-close"></i></button>';
        $total = 0;

        while ($row = mysqli_fetch_assoc($result)){
            if($row['Id'] == $gameId){
                $total = $total + (int)$row['prijs'];
                $total = $total / 100 * 130;
                buyGameScreen($conn, $username, $budget, $total, 2, $btn, $cls, $uid, "you don't have enough money to buy the game", $codetext);
            }
        }
    }
}
?>
<title>Buy a game at GameINK</title>
<section id="cart">
        <nav id="cart"></nav>
        <?php
            $result = getData($conn, "SELECT * FROM games WHERE naam = 'Grand Blox Auto';");

            if (isset($_SESSION['cart'])){
                $gameId = $_SESSION['CurrentGame'];
                $result = getData($conn, "SELECT * FROM games");

                while ($row = mysqli_fetch_assoc($result)){
                        if($row['Id'] == $gameId){
                            CreateGamePage($row['naam'],$row['video'],$row['info'],$row['genre'],$row['rating'],
                            $row['image2'],$row['pegImg'],$row['pegName'],$row['prijs'],$row['Company'],$row['release'],$row['platform'],$row['Id']);
                        }
                }
            }
        ?>
</section>

<?php
include_once('../head-footer/EXfooter.php');
?>