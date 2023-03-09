<?php
if (isset($_POST['msgToChatbot'])){
    $messg = $_POST['msgToChatbot'];
    $searchRespo = "SELECT * FROM inkbot WHERE vraag LIKE '%{$messg}%' LIMIT 1;";
    $searchReslut = mysqli_query($conn, $searchRespo);
    if(mysqli_num_rows($searchReslut) > 0){
    while ($row = mysqli_fetch_assoc($searchReslut)){
        $replay = $row['replay'];
    }
    $botReplay = $replay;
    }else{
        $botReplay = "sorry i don't understand what you mean";
    }

    $Rplysql = "INSERT INTO inkbotchats (userSender, chatbotReplay, userId) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $Rplysql)) {
        header('location: ../User/signup.php?error=stmtfailed' || 'location: User/signup.php?error=stmtfailed');
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $messg, $botReplay, $uid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

?>

<div class="chatbot-parent"><i onclick="showBotchat()" id="botIcon" class='far fa-comment-alt'></i>
<div id="chatbotChild" class="chatbot-child">
<nav class="chatbot-nav"><img src="<?php if($_SESSION['fileType'] == 1){echo "profilePics/6404b87c90d4ctester.png";}elseif($_SESSION['fileType'] == 2){echo "../profilePics/6404b87c90d4ctester.png";}?>"><h1>INKbot</h1></nav>
<div id="chatbot-body" class="chatbot-body">
    <script>
        function data(){
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function(){
                document.getElementById("chatbot-body").innerHTML = this.responseText;
            }
            xhttp.open("POST", "<?php if($_SESSION['fileType'] == 1){echo "head-footer/chatbotchats.php";}elseif($_SESSION['fileType'] == 2){echo "../head-footer/chatbotchats.php";}?>");
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("getchats");
        }
    </script>
    <?php
        $uid = $_SESSION['userid'];
        $username = $_SESSION['user'];
        $searchRespo = "SELECT * FROM inkbotchats WHERE userId = $uid;";
        $searchReslut = mysqli_query($conn, $searchRespo);
        if(!mysqli_num_rows($searchReslut) == 0){
        while ($row = mysqli_fetch_assoc($searchReslut)){
            $userSend = $row['userSender'];
            $Replay = $row['chatbotReplay'];
            $userid = $row['userId'];
            if ($uid == $userid){
                INKbotMsg($userSend, $Replay);
            }
        }
        }else{
            $firstchat = "INSERT INTO inkbotchats (chatbotReplay, userId) VALUES (?, ?);";
            $botgreeting = "welcome $username if you need help you can ask me anything";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $firstchat)) {
                header('location: ../User/signup.php?error=stmtfailed');
                exit();
            }
        
            mysqli_stmt_bind_param($stmt, "ss", $botgreeting, $uid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            exit();
        }
    ?>
</div>
<nav class="chatbot-input"><input id="chatbot-input" name="msgToChatbot" type="text" placeholder="ask me a question..." value="" minlength="1"></nav>
<button id="JSclick" type="submit"></button>
</div></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
    function scrolldownChatbot(){
        document.getElementById("chatbot-body").scrollTo(0, 999999999999);
    }

    $(document).ready(function() {
        $("#chatbot-input").keyup(function(event) {
        if (event.keyCode === 13) {
            $("#JSclick").click();
        }});
            $("#JSclick").click(function() {
            var msgtoBot = $("#chatbot-input").val();
            $(document).load("", {
                msgToChatbot: msgtoBot
            });
            data();
            setTimeout( function () {
            scrolldownChatbot();
            } , 300 );
        });
    });

function showBotchat() {
    document.getElementById("chatbotChild").classList.toggle("chatbot-show");
    scrolldownChatbot();
}
</script>