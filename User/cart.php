<?php
session_start();
$_SESSION['fileType'] = 2;
include_once('../head-footer/header.php');
include_once('../includes/functions.inc.php');
include_once('../includes/dbh.inc.php');
if(!isset($_SESSION['userid'])) {
    header('location: ../User/login.php?error=loginfirst');
}else{
    CheckIfBanned($conn, $uid, 1); SetBudget($conn, $uid); CheckLastTimeOnline($conn, $uid); CheckWhereLiving($conn, $uid);
}
if(isset($_POST['remove'])){
    if ($_GET['action'] == 'remove'){
        foreach ($_SESSION['cart'] as $key => $value){
            if($value['productId'] == $_GET['Id']){
                unset($_SESSION['cart'][$key]);
                echo "<script>window.location = 'cart.php'</script>";
            }
        }
    }
}
?>
<title>Your Cart at GameINK</title>
<section id="cart">
        <nav id="cart"></nav>
        <h1 id="cartTitle">My Cart</h1>
        <div class="cartBody">
        <div class="cart">
            <?php
            $total = 0;
            if (isset($_SESSION['cart'])){
                $itemId = array_column($_SESSION['cart'], 'productId');
                $result = getData($conn, "SELECT * FROM games");
                while ($row = mysqli_fetch_assoc($result)){
                    foreach ($itemId as $id){
                        if($row['Id'] == $id){
                            $gname = $row['naam'];
                            $total = $total + (int)$row['prijs'];
                            GameCart($row['naam'],$row['prijs'],$row['image'],$row['Id'],$row['Company']);
                        }
                    }
                }
            }
            else
            {
                echo "<h1>Cart is Empty</h1>";
            }
            ?>
            </div>
            <!-- action="cart.php?doing=buying" -->
            <form method="post">
            <div class="cartSubtotal">
                <h1 id="cartSubtotal">Cart Games</h1>
                <h2 id="cartSubtotal"><?php if(isset($_SESSION['cart'])){
                    $count = count($_SESSION['cart']);
                    echo "Total Games: ".($count).""; }else{ echo "Price 0";}?>
                </h2>
                <?php
                $total = 0;
                if (isset($_SESSION['cart'])){
                    $itemId = array_column($_SESSION['cart'], 'productId');
                    $result = getData($conn, "SELECT * FROM games");
                    while ($row = mysqli_fetch_assoc($result)){
                        foreach ($itemId as $id){
                            if($row['Id'] == $id){
                                $gname = $row['naam'];
                                $gprice = $row['prijs'];
                                $total = $total + (int)$row['prijs'];?>
                                <h3 id="cartSubtotal"><?php echo $gname ." &#128178;".$gprice ?></h3>
                                <?php
                            }
                        }
                    }
                }
                ?>
                <hr id="cart">
                <h4 id="cartSubtotal">Subtotal: <?php echo " &#128178;". $total ?></h4>
                <button type="submit" name="buy2" id="cartSubtotal">Check out</button>
            </div>
            </form>
        </div>
</section>
<?php
if (isset($_POST['buy2'])){
    $itemId = array_column($_SESSION['cart'], 'productId');
    foreach ($itemId as $id){
        $cartgame = $id;
    }
    $ownedgame = mysqli_query($conn, "SELECT Id, bestelnaam, gebruikerId FROM orders WHERE gebruikerId = ".$uid." AND gameId = ".$cartgame.";");
    if (mysqli_num_rows($ownedgame)>0) {
        echo "<script> alert('you already own some games in your cart, remove them first')</script>";
    }else{
        echo "<script> window.location.href= 'cart.php?doing=buying'; </script>";
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
        $itemId = array_column($_SESSION['cart'], 'productId');
        $budget = $_SESSION['budget'];
        $btn = '<div class="bestelling-price"><p>when clicking "buy product" I accept that I am 18 years older and I know that no returns are possible.</p><button type="submit" name="buycartgames">Buy Product</button></div>';
        $cls = '<button type="submit" name="closeCart"><i class="fa fa-close"></i></button>';

        while ($row = mysqli_fetch_assoc($result)){
            foreach ($itemId as $id){
                if($row['Id'] == $id){
                    $buyprice = $total + $tax;
                    buyGameScreen($conn, $username, $budget, $buyprice, 1, $btn, $cls, $uid, "", $codetext);
                }
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
        $btn = '<div class="bestelling-price"><p>when clicking "buy product" I accept that I am 18 years older and I know that no returns are possible.</p><button type="submit" name="buycartgames">Buy Product</button></div>';
        $cls = '<button type="submit" name="closeGame"><i class="fa fa-close"></i></button>';
        $total = 0;

        while ($row = mysqli_fetch_assoc($result)){
            if($row['Id'] == $gameId){
                $total = $total + (int)$row['prijs'];
                $total = $total / 100 * 130;
                buyGameScreen($conn, $username, $budget, $total, 1, $btn, $cls, $uid, "you don't have enough money to buy the game", $codetext);
            }
        }
    }
}
include_once('../head-footer/footer.php');
?>