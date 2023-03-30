<?php
session_start();
$_SESSION['fileType'] = 2;
include_once('../head-footer/header.php');
include_once('../includes/dbh.inc.php');
include_once('../includes/functions.inc.php');
if(isset($_SESSION['userid'])) {
    CheckIfBanned($conn, $uid, 1); SetBudget($conn, $uid); CheckLastTimeOnline($conn, $uid); CheckWhereLiving($conn, $uid); CheckLevel($conn, $uid);
    include_once('../head-footer/chatbot.php');
}
?>
<title>Login at GameINK</title>
<section class="oneSign">
    <div class="sign">
    <h1 id="main">Log in at game<P id="i">INK</P></h1>
        <h1 id="second">Don't have an account?&nbsp;<a id="Loginn" href="../User/signup.php">Sign Up</a></h1>
        <form id="signin" action="../includes/login.inc.php" method="post">
            <input type="text" name="uid" placeholder="Username or email..." required="" maxlength="50"><br>
            <input type="password" name="pwd" placeholder="Password..." required="" maxlength="200"><br>
            <?php
if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
        echo "<p>Fill in all fields</p>";
    }
    elseif ($_GET["error"] == "userexist") {
        echo "<p>User don't exist!</p>";
    }
    elseif ($_GET["error"] == "passwordincorrect") {
        echo "<p>Incorrect password!</p>";
    }
    elseif ($_GET["error"] == "loginfirst") {
        echo "<p>you need to login first!</p>";
    }
}
?>
            <button type="submit" name="submit">Log in</button>
        </form>
    </div>
</section>

<?php
include_once('../head-footer/footer.php');
?>