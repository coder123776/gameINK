<?php
include_once('../head-footer/EXheader.php');
include_once('../includes/functions.inc.php');
include_once('../includes/dbh.inc.php');
if(!isset($_SESSION['userid'])) {
    header("location: ../User/login.php");
}else{
    CheckIfBanned($conn, $uid, 2);
    SetBudget($conn, $uid);
}
?>
<title>Complain GameINK</title>
<section id="cart">
    <div class="complain-parent">
        <form action="../includes/banning.php" method="post">
        <label for="klacht">Write Your Complain</label>
        <input id="in" name="klacht" type="text" maxlength="75">
        <input id="in" type="hidden" name="userBanId" value="<?php echo $_SESSION['userid'];?>">
        <input id="in" type="hidden" name="userName" value="<?php echo $_SESSION['user'];?>">
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
include_once '../head-footer/EXfooter.php';
?>