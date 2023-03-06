<html>
    <title>friends</title>
</html>

<?php
include_once('../head-footer/EXheader.php');
include_once('../includes/functions.inc.php');
if(isset($_SESSION['userid'])) {
    CheckIfBanned($conn, $uid, 2);
}

echo "<h1>you have no friends</h1>";

include_once '../head-footer/EXfooter.php';

?>

<style>
    h1 {
        font-size: 40px;
        text-align: center;
    }
</style>