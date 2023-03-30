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
<title>Signup at GameINK</title>
<section class="oneSign">
    <div class="sign">
        <h1 id="main">Sign in at game<P id="i">INK</P></h1>
        <h1 id="second">Already have an account?&nbsp;<a id="Loginn" href="../User/login.php">LOG IN</a></h1>
    <form id="signin" action="../includes/signup.inc.php" method="post">
    <h1>sign in</h1>
    <input type="text" name="name" placeholder="Full name..." required="" maxlength="50">
    <input type="text" name="user" placeholder="Username..." required="" maxlength="12">
    <input type="text" name="email" placeholder="Email..." required="" maxlength="50">
    <input type="password" name="pwd" placeholder="Password..." required="" maxlength="200">
    <input type="password" name="pwdrepeat" placeholder="Repeat Password..." required="" maxlength="200">
    <?php
    if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
        echo "<p>Fill in all fields</p>";
    }
    elseif ($_GET["error"] == "invaliduid") {
        echo "<p>no characters like (!_<:$-), only characters like a-z A-Z 0-9</p>";
    }
    elseif ($_GET["error"] == "invalidemail") {
        echo "<p>choose a valid email</p>";
    }
    elseif ($_GET["error"] == "passwordsdontmatch") {
        echo "<p>password doesn't match</p>";
    }
    elseif ($_GET["error"] == "stmtfailed") {
        echo "<p>something went wrong</p>";
    }
    elseif ($_GET["error"] == "usernametaken") {
        echo "<p>username already taken</p>";
    }
    elseif ($_GET["error"] == "none") {
        echo "<p>you have signd up</p>";
    }
}
?>
    <button type="submit" name="submit">SIGN UP</button>
    </form>
    </div>
</section>

<?php
include_once('../head-footer/footer.php');
?>