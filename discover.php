<?php
include_once('head-footer/header.php');
include_once('includes/functions.inc.php');
include_once('includes/dbh.inc.php');
$_SESSION['fileType'] = 1;

if(isset($_GET['filter'])){

        if ($_GET["filter"] == "Tgames") {
                $result = getData($conn, "SELECT * FROM games WHERE State LIKE '%TRENDING%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Pgames") {
                $result = getData($conn, "SELECT * FROM games WHERE State LIKE '%POPULAR%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Ngames") {
                $result = getData($conn, "SELECT * FROM games WHERE State LIKE '%NEW%' ORDER BY naam;");
        }

        if ($_GET["filter"] == "FreeGames") {
                $result = getData($conn, "SELECT * FROM games WHERE prijs < 1 ORDER BY prijs;");
        }
        if ($_GET["filter"] == "Und10") {
                $result = getData($conn, "SELECT * FROM games WHERE prijs < 10 ORDER BY prijs;");
        }
        if ($_GET["filter"] == "Und20") {
                $result = getData($conn, "SELECT * FROM games WHERE prijs < 20 ORDER BY prijs;");
        }
        if ($_GET["filter"] == "Und30") {
                $result = getData($conn, "SELECT * FROM games WHERE prijs < 30 ORDER BY prijs;");
        }
        if ($_GET["filter"] == "Bov50") {
                $result = getData($conn, "SELECT * FROM games WHERE prijs > 49 ORDER BY prijs;");
        }

        if ($_GET["filter"] == "Action") {
                $result = getData($conn, "SELECT * FROM games WHERE genre LIKE '%action%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Adventure") {
                $result = getData($conn, "SELECT * FROM games WHERE genre LIKE '%adventure%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Casual") {
                $result = getData($conn, "SELECT * FROM games WHERE genre LIKE '%casual%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "City") {
                $result = getData($conn, "SELECT * FROM games WHERE genre LIKE '%city%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Comedy") {
                $result = getData($conn, "SELECT * FROM games WHERE genre LIKE '%comedy%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Fightning") {
                $result = getData($conn, "SELECT * FROM games WHERE genre LIKE '%fight%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Horror") {
                $result = getData($conn, "SELECT * FROM games WHERE genre LIKE '%horror%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "MOBA") {
                $result = getData($conn, "SELECT * FROM games WHERE genre LIKE '%moba%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Music") {
                $result = getData($conn, "SELECT * FROM games WHERE genre LIKE '%music%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Racing") {
                $result = getData($conn, "SELECT * FROM games WHERE genre LIKE '%racing%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Shooter") {
                $result = getData($conn, "SELECT * FROM games WHERE genre LIKE '%shooter%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Simulation") {
                $result = getData($conn, "SELECT * FROM games WHERE genre LIKE '%simulation%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Sports") {
                $result = getData($conn, "SELECT * FROM games WHERE genre LIKE '%sports%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Strategy") {
                $result = getData($conn, "SELECT * FROM games WHERE genre LIKE '%strategy%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Survival") {
                $result = getData($conn, "SELECT * FROM games WHERE genre LIKE '%survival%' ORDER BY naam;");
        }

        if ($_GET["filter"] == "Coop") {
                $result = getData($conn, "SELECT * FROM games WHERE State LIKE '%coop%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "MMO") {
                $result = getData($conn, "SELECT * FROM games WHERE State LIKE '%mmo%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Multiplayer") {
                $result = getData($conn, "SELECT * FROM games WHERE State LIKE '%multiplayer%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Singleplayer") {
                $result = getData($conn, "SELECT * FROM games WHERE State LIKE '%singleplayer%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "VR") {
                $result = getData($conn, "SELECT * FROM games WHERE State LIKE '%vr%' ORDER BY naam;");
        }

        if ($_GET["filter"] == "Windows") {
                $result = getData($conn, "SELECT * FROM games WHERE platform LIKE '%Windows%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Playstation") {
                $result = getData($conn, "SELECT * FROM games WHERE platform LIKE '%Playstation%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Mac") {
                $result = getData($conn, "SELECT * FROM games WHERE platform LIKE '%Mac%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Nitendo") {
                $result = getData($conn, "SELECT * FROM games WHERE platform LIKE '%Nitendo%' ORDER BY naam;");
        }
        if ($_GET["filter"] == "Mobile") {
                $result = getData($conn, "SELECT * FROM games WHERE platform LIKE '%Mobile%' ORDER BY naam;");
        }
}else{
        $result = getData($conn, "SELECT * FROM games ORDER BY naam;");
}

if(isset($_SESSION['userid'])) {
        CheckIfBanned($conn, $uid, 1);
        SetBudget($conn, $uid);
        include_once('head-footer/chatbot.php');
}
if (isset($_POST['add'])){
        if(!isset($_SESSION['userid'])) {
            header("location: User/login.php");
        }else{
        if (isset($_SESSION['cart'])){
            $_SESSION['CurrentGame'] = $_POST['productId'];
            header("location: User/game.php");
        }else{
            $item_ary = array('productId' => $_POST['productId']);
            $_SESSION['cart'][0] = $item_ary;
            $_SESSION['CurrentGame'] = $_POST['productId'];
            header("location: User/game.php");
        }
    }
}
?>
<title>Discover at GameINK</title>
<section id="cart">
        <nav id="discover"></nav>


        <div class="genres-parent">
                <div class="genres-nav"><h1>Popular Genres</h1></div>
                <div class="genres-row">
                        <?php
                        EXgenre("Action Games", "Action", "docs/Discover1.png");
                        EXgenre("Adventure Games", "Adventure", "docs/Discover2.png");
                        EXgenre("Casual Games", "Casual", "docs/Discover3.png");
                        EXgenre("City Building Games", "City", "docs/Discover4.png");
                        ?>
                </div>
        </div>

        <div class="suggestion-parent">
                <div id="suggestions" class="suggestion-row">
                <?php
                while($row = mysqli_fetch_assoc($result)){
                        if (mysqli_num_rows($result)>0){
                                        filterRows($row['image'],$row['naam'],$row['prijs'],$row['Id']);
                        }}
                ?>
                </div>


                <div class="suggestion-nav">
                        <div class="suggestion-title">Filter Games <a href="discover.php">Reset</a></div>
                                <input id="filterS" type="text" name="search_text" placeholder="Search games...">
                                <hr id="sugg">

                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
                                <script type="text/javascript">
                                        $(document).ready(function(){
                                        $("#filterS").keyup(function(){
                                                var input = $(this).val();
                                                if(input != ""){
                                                $.ajax({
                                                        url:"includes/search.inc.php",
                                                        method:"post",
                                                        data:{searchgames:input},

                                                        success:function(data){
                                                        $("#suggestions").html(data);
                                                        $("#suggestions").css("display", "flex");
                                                        }
                                                });
                                                }
                                        });
                                        });
                                </script>
                        <!-- <hr id="sugg"> -->
                        <div class="dropdown">
                        <button onclick="SeeEvent()" class="dropbtn"><h1>Events</h1><i id="up5" class="arrowUp"></i></button>
                        <hr id="sugg">
                        <div id="event" class="dropdown-content">
                                        <?php
                                        MakeFilter("Trending Games", "Tgames");
                                        MakeFilter("Popular Games", "Pgames");
                                        MakeFilter("New Games", "Ngames");
                                        ?>
                                </div>

                        <button onclick="SeePrice()" class="dropbtn"><h1>Price</h1><i id="up1" class="arrowUp"></i></button>
                        <hr id="sugg">
                        <div id="price" class="dropdown-content">
                                        <?php
                                        //mqsl prijs
                                        MakeFilter("Free Games", "FreeGames");
                                        MakeFilter("Under $10.00", "Und10");
                                        MakeFilter("Under $20.00", "Und20");
                                        MakeFilter("Under $30.00", "Und30");
                                        MakeFilter("$49.99 and above", "Bov50");
                                        ?>
                                </div>
                        <button onclick="SeeGenre()" class="dropbtn"><h1>Genre</h1><i id="up2" class="arrowUp"></i></button>
                        <hr id="sugg">
                        <div id="genre" class="dropdown-content">
                                        <?php
                                        //mqsl genre
                                        MakeFilter("Action", "Action");
                                        MakeFilter("Adventure", "Adventure");
                                        MakeFilter("Casual", "Casual");
                                        MakeFilter("City", "City");
                                        MakeFilter("Comedy", "Comedy");
                                        MakeFilter("Fightning", "Fightning");
                                        MakeFilter("Horror", "Horror");
                                        MakeFilter("MOBA", "MOBA");
                                        MakeFilter("Music", "Music");
                                        MakeFilter("Racing", "Racing");
                                        MakeFilter("Shooter", "Shooter");
                                        MakeFilter("Simulation", "Simulation");
                                        MakeFilter("Sports", "Sports");
                                        MakeFilter("Strategy", "Strategy");
                                        MakeFilter("Survival", "Survival");
                                        ?>
                                </div>
                        <button onclick="SeeFea()" class="dropbtn"><h1>Features</h1><i id="up3" class="arrowUp"></i></button>
                        <hr id="sugg">
                        <div id="feature" class="dropdown-content">
                                        <?php
                                        //mqsl state
                                        //Also things like trending and poplular
                                        MakeFilter("Co-op", "Coop");
                                        MakeFilter("MMO", "MMO");
                                        MakeFilter("Multiplayer", "Multiplayer");
                                        MakeFilter("Singleplayer", "Singleplayer");
                                        MakeFilter("VR", "VR");
                                        ?>
                                </div>
                        <button onclick="SeePlat()" class="dropbtn"><h1>Platform</h1><i id="up4" class="arrowUp"></i></button>
                        <hr id="sugg">
                        <div id="platform" class="dropdown-content">
                                        <?php
                                        //mqsl platform
                                        MakeFilter("Windows", "Windows");
                                        MakeFilter("Playstation", "Playstation");
                                        MakeFilter("Mac", "Mac");
                                        MakeFilter("Nitendo", "Nitendo");
                                        MakeFilter("Mobile", "Mobile");
                                        ?>
                                </div>
                        </div>

<script>
function SeeEvent() {
        document.getElementById("event").classList.toggle("show");
        document.getElementById("up5").classList.toggle("arrowDown");
}
function SeePrice() {
        document.getElementById("price").classList.toggle("show");
        document.getElementById("up1").classList.toggle("arrowDown");
}
function SeeGenre() {
        document.getElementById("genre").classList.toggle("show");
        document.getElementById("up2").classList.toggle("arrowDown");
}
function SeeFea() {
        document.getElementById("feature").classList.toggle("show");
        document.getElementById("up3").classList.toggle("arrowDown");
}
function SeePlat() {
        document.getElementById("platform").classList.toggle("show");
        document.getElementById("up4").classList.toggle("arrowDown");
}
</script>
<!--askdjnaks----------------------------------------------------->
                </div></div>
</section>

<?php
include_once('head-footer/footer.php');
?>