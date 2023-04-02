<footer>
    <div class="footer-nav"><h1>MADE BY: Amerencio, justin, milan, brandon</h1></div>
    <hr id="sugg">
    <div class="footer-inf">
        <div class="footer-inf-txt"><p>complaints or a bad expirence? write your complaint..</p><a href="<?php if($_SESSION['fileType'] == 1){echo "User/complaint.php";}elseif($_SESSION['fileType'] == 2){echo "../User/complaint.php";}?>">Add complaint</a></div>
        <h1>Reviews</h1>
        <div class="review-parent">
        <?php 
        // WHERE status = 'MESSAGE'
        $reviews = "SELECT * FROM review WHERE status = 'MESSAGE' OR status = 'BANNED';";
        $result = mysqli_query($conn, $reviews);
        while ($row = mysqli_fetch_assoc($result)){
            $name = $row['Username'];
            $review = $row['review'];
            $img = $row['userimg'];
            $date = $row['time'];
            ?>
            <div class="review-child">
                <img class="review-img" src="<?php if($img == ""){ if($_SESSION['fileType'] == 1){echo "docs/emptyInput.png";}elseif($_SESSION['fileType'] == 2){echo "../docs/emptyInput.png";};}else{ if($_SESSION['fileType'] == 1){echo "User/".$img;}elseif($_SESSION['fileType'] == 2){echo "../User/".$img;}} ?>">
                <div class="review-c-child">
                <h1><?php echo $name ?></h1>
                <p><?php echo $date ?></p>
                <p><?php echo $review ?></p>
                </div>
            </div>
            <hr>
            <div class="extra-space"></div>
        <?php
        }
        ?>
        </div>
    </div>
    <div class="footer-end"><h1 id="txt-1">Game</h1><h1 id="txt-2">INK</h1></div>
</footer>
</body>
</html>