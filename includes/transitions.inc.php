<?php

require_once('dbh.inc.php');
include_once('functions.inc.php');
if (!$_SESSION){
    session_start();
}
//bUY GAME FROM CART OR GAMEPAGE
function ChangeBudget($conn, $number, $uid){
    mysqli_query($conn, "UPDATE gebruiker SET budget = budget - $number  WHERE gebruiker.Id = $uid;");
}

function MakeOrder($conn, $bestelnaam, $bestelemail, $bestelproduct, $bestelprodinf, $bestelprijs, $bestelimage, $uid, $gameid){
    $sql = "INSERT INTO orders (bestelnaam, bestelemail, bestelproduct, bestelprodInf, bestelprijs, bestelimage, gebruikerId, gameId) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../User/error.php?error=stmtfailed');
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssssss", $bestelnaam, $bestelemail, $bestelproduct, $bestelprodinf, $bestelprijs, $bestelimage, $uid, $gameid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header('location: ../User/profile.php?setting=orders');
    exit();
}
if(isset($_POST['closeCart'])){
    header("location: ../User/cart.php");
}
if(isset($_POST['closeGame'])){
    header("location: ../User/game.php");
}
if (isset($_POST['buyGameGame'])){
    $totalPrice = $_POST['Tprice'];
    $budget = $_SESSION['budget'];
    $nomoneyloc = $_POST['buyHeader'];
    $minusorplus = "-";
    $uid = $_SESSION['userid'];

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
        MakeOrder($conn, $checkUser, $checkEmail, $checkName, $checkInfo, $checkPrijs, $checkImage, $uid, $checkId);
    }
}
if (isset($_POST['submitCode'])){
    $codeSent = $_POST['codesent'];
    $uid = $_SESSION['userid'];
    if ($codeSent == $reedemcode1 || $codeSent == $reedemcode2 || $codeSent == $reedemcode3){
        mysqli_query($conn, "UPDATE gebruiker SET budget = budget + 100  WHERE gebruiker.Id = $uid;");
        header("location: ../User/game.php?doing=buying&codefound");
    }else{
        header("location: ../User/game.php?doing=buying&codenotfound");
    }
}

function DisplayOrder($conn, $uid){
    $result = getData($conn, "SELECT * FROM orders WHERE gebruikerId = $uid;");
    if ($result){
        while ($row = mysqli_fetch_assoc($result)){
            $element = '
            <tr>
            <td>'.$row['Id'].'</td>
            <td>'.$row['bestelnaam'].'</td>
            <td>'.$row['bestelemail'].'</td>
            <td>'.$row['bestelproduct'].'</td>
            <td>&nbsp; &#128178;'.$row['bestelprijs'].'</td>
            <td><img src="'.$row['bestelimage'].'"></img></td>
            </tr>
            ';
            echo $element;
            }
    }else{
        echo "no orders Yet";
    }
}
if(!isset($_POST)){
    header("location: ../User/game.php?doing=buying");
}
?>