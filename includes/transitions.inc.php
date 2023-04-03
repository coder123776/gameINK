<?php

require_once('dbh.inc.php');
include_once('functions.inc.php');
//bUY GAME FROM CART OR GAMEPAGE
if (!isset($_SESSION)){
    session_start();
}

function ChangeBudget($conn, $number, $uid){
    mysqli_query($conn, "UPDATE gebruiker SET budget = budget - $number  WHERE gebruiker.Id = $uid;");
}
function ChangeLevel($conn, $level, $uid){
    mysqli_query($conn, "UPDATE gebruiker SET level = level + $level  WHERE gebruiker.Id = $uid;");
}

function MakeOrder($conn, $bestelnaam, $bestelemail, $bestelproduct, $bestelprodinf, $bestelprijs, $bestelimage, $uid, $gameid, $datum){
    $sql = "INSERT INTO orders (bestelnaam, bestelemail, bestelproduct, bestelprodInf, bestelprijs, bestelimage, gebruikerId, gameId, besteldatum) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../User/error.php?error=stmtfailed');
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssssss", $bestelnaam, $bestelemail, $bestelproduct, $bestelprodinf, $bestelprijs, $bestelimage, $uid, $gameid, $datum);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
if(isset($_POST['closeCart'])){
    header("location: ../User/cart.php");
}
if(isset($_POST['closeGame'])){
    header("location: ../User/game.php");
}
if (isset($_POST['buycartgames'])){
    $totalPrice = $_POST['Tprice'];
    $budget = $_SESSION['budget'];
    $nomoneyloc = $_POST['buyHeader'];
    $minusorplus = "-";
    $uid = $_SESSION['userid'];
    $checkUser = $_SESSION['user'];
    $checkEmail = $_SESSION['email'];
    $datum = date('jS F Y H:i');

    $elkeProduct = array_map(function ($id, $name, $image, $price, $info) {
        return [
            'id' => $id,
            'name' => $name,
            'image' => $image,
            'price' => $price,
            'info' => $info,
        ];
    }, $_SESSION['AllIds'], $_SESSION['AllNames'], $_SESSION['AllImages'], $_SESSION['AllPrices'], $_SESSION['AllInfos']);
    
    ChangeLevel($conn, $totalPrice, $uid);
    ChangeBudget($conn, $totalPrice, $uid);
    foreach ($elkeProduct as $product) {
        if($totalPrice > $budget){
            header("location: ".$nomoneyloc."");
        }elseif ($totalPrice < $budget){
            MakeOrder($conn, $checkUser, $checkEmail, $product['name'], $product['info'], $product['price'], $product['image'], $uid, $product['id'], $datum);
        }
    }
    unset($_SESSION['AllIds']);
    unset($_SESSION['AllNames']);
    unset($_SESSION['AllImages']);
    unset($_SESSION['AllPrices']);
    unset($_SESSION['AllInfos']);
    unset($_SESSION['cart']);
    header('location: ../User/profile.php?setting=orders');
    exit();
}
if (isset($_POST['buyGameGame'])){
    $totalPrice = $_POST['Tprice'];
    $budget = $_SESSION['budget'];
    $nomoneyloc = $_POST['buyHeader'];
    $minusorplus = "-";
    $uid = $_SESSION['userid'];
    $datum = date('jS F Y H:i');

    $checkId = $_POST['buyId'];
    $checkName = $_POST['checkName'];
    $checkImage = $_POST['checkImg'];
    $checkPrijs = $_POST['checkPrice'];
    $checkInfo = $_POST['checkInf'];
    $checkUser = $_POST['checkUsername'];
    $checkEmail = $_POST['checkEmail'];

    if($totalPrice > $budget){
        header("location: ".$nomoneyloc."");
    }elseif ($totalPrice < $budget){
        ChangeBudget($conn, $totalPrice, $uid);
        ChangeLevel($conn, $totalPrice, $uid);
        MakeOrder($conn, $checkUser, $checkEmail, $checkName, $checkInfo, $checkPrijs, $checkImage, $uid, $checkId, $datum);
        header('location: ../User/profile.php?setting=orders');
    }
}
if (isset($_POST['submitCode'])){
    $codeSent = $_POST['codesent'];
    $uid = $_SESSION['userid'];
    if ($codeSent == $reedemcode1 || $codeSent == $reedemcode2 || $codeSent == $reedemcode3){
        mysqli_query($conn, "UPDATE gebruiker SET budget = budget + 100  WHERE gebruiker.Id = $uid;");
        header("location: ../User/game.php?doing=buying&codefound");
    }elseif ($codeSent == $reedemcode4){
        mysqli_query($conn, "UPDATE gebruiker SET budget = budget + 1000  WHERE gebruiker.Id = $uid;");
        header("location: ../User/game.php?doing=buying&codefound");
    }else{
        header("location: ../User/game.php?doing=buying&codenotfound");
    }
}
if(!isset($_POST)){
    header("location: ../User/game.php?doing=buying");
}
?>