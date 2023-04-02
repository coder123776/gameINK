<?php
include_once('includes/functions.inc.php');
include_once('includes/dbh.inc.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" type="image/x-icon" href="docs/logoWeb.png">
    <title>oops GameINK has some troubles</title>
</head>
<body>
    <div class="error">
    <h1>
        <?php
        if(isset($_GET['type'])){
            if ($_GET["type"] == "banned") {
                echo "<p>You have been banned for eternity</p>";
                echo "<p>and you have no rights to get an unban</p>";
            }

            if ($_GET["type"] == "bannedFromKlacht") {
                echo "You have been banned for telling lies";
                echo "<p>your ban is for eternity</p>";
            }
        }
        ?>
        </h1>
    </div>
</body>
</html>