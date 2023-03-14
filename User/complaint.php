<?php
session_start();
$_SESSION['fileType'] = 2;
include_once('../head-footer/header.php');
include_once('../includes/functions.inc.php');
include_once('../includes/dbh.inc.php');
if(!isset($_SESSION['userid'])) {
    header("location: ../User/login.php?error=loginfirst");
}else{
    CheckIfBanned($conn, $uid, 1); SetBudget($conn, $uid); CheckLastTimeOnline($conn, $uid); CheckWhereLiving($conn, $uid);
}
?>
<title>Complain GameINK</title>
<section id="cart">
    <div class="complain-parent">
        <form action="../includes/reviews.inc.php" method="post">
        <label for="klacht">Write Your Complain</label>
        <input id="in" name="klacht" type="text" maxlength="75">
        <input id="in" type="hidden" name="userBanId" value="<?php echo $_SESSION['userid'];?>">
        <input id="in" type="hidden" name="userName" value="<?php echo $_SESSION['user'];?>">
        <input type="hidden" name="userTime" value="<?php echo date("H:i")?>">
        <button name="BannedFromComplain" id="complain" type="submit">Post Complain</button>
        <div>
            <input id="terms" type="checkbox" name="terms" onchange="activateButton(this)">
            <p>
                are you sure you want to post a bad exprirence?<br>
                i accept i will not have rights after posting this..
            </p>
        </div>
        </form>
    </div>
</section>

<script>
  document.getElementById("complain").disabled = true;

  function activateButton(element) {

      if(element.checked) {
        document.getElementById("complain").disabled = false;
       }
       else  {
        document.getElementById("complain").disabled = true;
      }

  }
</script>

<?php
include_once('../head-footer/footer.php');
?>