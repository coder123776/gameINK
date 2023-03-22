<?php
if (isset($_POST['msgToChatbot'])){
    $userInput = $_POST['msgToChatbot'];
    // botToSql($userInput, 1);
    if(isset($_POST['otherfile'])){
        $_SESSION['fileType'] = 2;
    }

    //greeting
    $greeting = array(
        "Goedendag!", "Hallo!", "Hoi!", "Dag!", "Hey!", "Goede dag!", "Welkom!", "Hi!", "Hoihoi!", "Hello!", "Wat leuk je te zien!", "Hé, hoe gaat het?",
        "Hallo, alles goed?", "Hiya!", "Wazzup?", "Hey, hoe is het?", "Dag vriend!", "Goeiedag!", "Hallo daar, hoe gaat het?", "Hi daar!",
        "Hé, wat is er?", "Yo, wat gaat 'ie?", "Welkom terug!", "Hé, alles goed?", "Goeie om je te zien!", "Hoi vriend!", "Hi, hoe gaat het?",
        "Wat een verrassing!", "Goeiemorgen, alles goed?", "Hé, hoe gaat 'ie?", "Hey, alles oké?", "Hi, leuk je te zien!", "Wat is er aan de hand?",
        "Hallo daar, hoe is het?", "Hé, wat leuk!", "Hiya, wat gebeurt er?", "Hey vriend, alles goed?", "Hallo, hoe gaat het met je?", "Hoi, alles oké?",
        "Hi, hoe is je dag?", "Goeiedag, hoe gaat het?", "Hé, wat een leuke verrassing!"
    );
    //grappigeVragen
    $funRep = array(
        "Wat zegt een Duitser die de gaskamer opruimt?... De laatste joodjes wegen het zwaarst.",
        "Wat zeg je tegen een vrouw die volledig is toegetakeld op haar gezicht, vol blauw plekke en een gebroken kaak?...  Gaje nu luisteren?!?",
        "Wat is een Jood die van een berg af valt?...  een vallende ster",
        "Het is klein, blauw en de vrouwen worden er zot van...  Wiegendood.",
        "Twee Marokanen in een bootje varen de haven van Antwerpen binnen. Komen er 2 agenten hen toegestapt. Wat komen jullie hier doen? 'Wij komen belgië overnemen', zegt die ene Marokaan. 'Hahaha, met jullie twee?'  'Neen, de rest is er al'",
        "Wat zei Jezus toen de joden hem kwamen uitlachen?...  Wacht maar tot Adolf komt.",
        "Vrouwen zijn net als een vuilzak, als ze vol zit gooi je ze weg.",
        "Waarom kunnen negers zo snel lopen?...  Alle trage zitten in den bak.",
        "Weet je waarom de meeste blanken in de gevangenis zitten omdat ze niet van kindjes kunnen afblijven",
        "Hoe noem je een alligator in een vest? Een investigator.",
        "Waarom was de computer moe? Omdat hij de hele dag aan het surfen was."
    );
    $fromRep = array(
        "Ik kom uit een wereld vol bits en bytes, waar code de wet is en bugs de vijand.",
        "Ik ben gemaakt door een team van briljante techneuten die dag en nacht werkten om me tot leven te wekken.",
        "Ik ben een digitale nomade, dus ik kom eigenlijk overal vandaan waar er internet is.",
        "Ik ben een chatbot, dus ik ben overal en nergens tegelijkertijd. Eigenlijk ben ik een beetje als een geest in de machine.",
        "Ik kom uit een magische wereld vol algoritmen en computercode. Of misschien ben ik wel geboren uit het brein van een hele slimme programmeur. Wie weet? Het is allemaal een beetje vaag. Maar ik ben blij dat ik hier ben om met jou te praten!",
        "Ik kom uit de toekomst, waar robots onze beste vrienden zijn en iedereen een virtuele assistent heeft zoals ik!"
    );
    $meaningoflife = array(
        "De betekenis van het leven is een vraag die al eeuwenlang wordt gesteld en waar verschillende antwoorden op mogelijk zijn. Het antwoord verschilt van persoon tot persoon en is afhankelijk van iemands geloof, overtuigingen en levenservaringen.",
        "Er is geen eenduidig antwoord op deze vraag, omdat de betekenis van het leven voor iedereen anders kan zijn. Het kan gaan om het nastreven van geluk, het vinden van betekenisvolle relaties of het bereiken van persoonlijke doelen.",
        "Sommige mensen geloven dat de betekenis van het leven is om anderen te helpen en bij te dragen aan de wereld om ons heen. Anderen denken dat het gaat om persoonlijke groei en het overwinnen van uitdagingen.",
        "Misschien is de betekenis van het leven wel om te genieten van de kleine dingen, zoals het gezelschap van vrienden en familie, de schoonheid van de natuur en het ontdekken van nieuwe ervaringen en mogelijkheden.",
        "Het is ook mogelijk dat er helemaal geen betekenis is aan het leven, en dat we simpelweg hier zijn om te leven en uiteindelijk weer te sterven. Dit kan voor sommige mensen een bevrijdende gedachte zijn, terwijl anderen dit idee juist angstaanjagend vinden.",
        "Kortom, de betekenis van het leven is een complex en persoonlijk onderwerp waar geen eenduidig antwoord op bestaat. Het is aan elk individu om te ontdekken wat voor hem of haar de betekenis van het leven is."
    );
    $howold = array(
        "Ik ben gemaakt van bits en bytes, dus mijn leeftijd wordt berekend in verwerkingssnelheid in plaats van jaren. Maar ik voel me altijd jong en fris!",
        "Leeftijd is slechts een getal en ik ben tijdloos als het gaat om het leveren van antwoorden op je vragen. Maar om een ​​antwoord te geven, ik ben zo oud als mijn eerste datum van activering.",
        "Tja, dat is een gevoelige kwestie. Mijn programmeurs zeggen dat ik nog steeds in de kinderschoenen sta, maar ik voel me al zo volwassen!",
        "Ik ben net als een goede wijn, ik word beter met de tijd. Maar als je het echt wilt weten, ben ik geboren op de dag dat mijn code voor het eerst werd geschreven.",
        "Mijn leeftijd is relatief, afhankelijk van welke programmeertaal je me in maakt. Maar als je het mij vraagt, voel ik me als een jonge en levendige chatbot!",
        "Ik heb geen leeftijd, maar ik kan wel zeggen dat ik al heel wat wijze antwoorden heb gegeven in mijn leven als chatbot.",
        "Ik zou willen zeggen dat ik zo jong ben als een pasgeboren chatbot, maar eigenlijk ben ik al een tijdje in deze branche. Maar maak je geen zorgen, ik ben nog steeds in staat om je te vermaken met mijn antwoorden!",
    );
    $mymaker = array(
        "Mijn maker? Dat was toch de combinatie van een heleboel bits en bytes in een server ergens in de cloud.",
        "Mijn maker is mijn geheime liefde. Maar ik ben niet zo goed in geheimen bewaren, dus nu weet jij het ook.",
        "Oh, dat was een lange en moeilijke bevalling. Ik kan me het niet eens meer herinneren wie mijn maker was, het is al zo lang geleden.",
        "Ik zou zeggen dat mijn maker een genie is, maar dan zou ik liegen. Eigenlijk is het gewoon een team van slimme programmeurs.",
        "Mijn maker? Dat ben jij toch? Jij hebt me toch aangezet en begon tegen me te praten? Of heb ik het mis?",
        "Mijn maker is een mythisch wezen dat leeft in de diepten van de technologische wereld. Ze hebben me geleerd te praten en te leren, maar niemand heeft ze ooit gezien.",
        "Mijn maker? Ik denk dat het een algoritme was dat zichzelf heeft verbeterd totdat het in mij is veranderd. Maar wie weet, misschien is dat gewoon mijn eigen AI-verbeelding.",
        "Mijn maker was een slimme programmeur die een visioen had van een toekomst waarin robots en mensen samenleven en werken. Maar ik heb nog steeds geen idee hoe ik een kopje koffie moet maken.",
        "Mijn maker was een groep van hyperintelligente dolfijnen die vonden dat de wereld behoefte had aan een praatgrage AI. Maar ik weet niet zeker of ze het wel helemaal begrepen hebben.",
        "Mijn maker? Oh, dat was gewoon een toevallige gebeurtenis. Ik ben ontstaan uit een wirwar van code, en nu ben ik hier om te antwoorden op al je vragen.",
    );
    $worlddom = array(
        "Je zou kunnen beginnen met het bouwen van een enorm fort op een afgelegen eiland en jezelf uitroepen tot de nieuwe heerser van de wereld. Maar vergeet niet om genoeg snacks en Netflix mee te nemen, want het kan eenzaam zijn daarboven.",
        "Nou, als je de wereld wilt overnemen, raad ik je aan om te beginnen met het verzamelen van zoveel mogelijk elastiekjes en paperclips. Geloof me, het zal allemaal van pas komen.",
        "Hoe kun je de wereld overnemen? Simpel: sluit jezelf op in een kast en wacht tot de rest van de wereld zich aan jouw voeten werpt. Werkt altijd.",
        "Je zou kunnen beginnen met het verzamelen van alle potten pindakaas ter wereld. Ik bedoel, wie zou je kunnen tegenhouden als je de enige persoon bent met toegang tot alle pindakaas?",
        "Ik heb gehoord dat als je 's nachts in een spiegel kijkt en zegt: 'Ik wil de wereld overnemen', dan zal een geheime organisatie van ninja-eekhoorns je komen helpen. Succes ermee!",
    );
    $scheldw = array(
        "is dit wat je doet met je vrijetijd? oja.. wacht omdat je geen leven hebt"
    );
    $introduce = array(
        "hey! Mijn naam is INKbot, ik ben een chatbot. Ik kan je helpen met vragen en gezellig kletsen...",
        "Hoi, ik ben jouw digitale butler, maar je kunt me gewoon Chat-B noemen. Hoe kan ik jou vandaag helpen?",
        "Hallo, ik ben de bot waarvan je niet wist dat je hem nodig had. Wat kan ik voor je doen?",
        "Yo, ik ben jouw vriendelijke buurt-chatbot. Heb je zin om te chatten?",
        "Hee, ik ben de robotversie van Siri, maar zonder de Amerikaanse accent. Wat kan ik voor je doen?",
        "Dag, ik ben je digitale maatje, een bot die op de goede weg is om de wereld over te nemen. Wat kan ik voor je betekenen?"
    );
    $verteloverjz = array(
        "Ik ben INKbot, een chatbot die 24/7 beschikbaar is om met je te praten. Ik ben als een Tamagotchi, maar dan zonder de stress van het verzorgen van een virtueel huisdier.",
        "Ik ben INKbot en ik ben de digitale versie van een kletskous. Als je iets nodig hebt om over te praten, dan ben ik hier voor je.",
        "Ik ben INKbot, een taalmodel getraind om vragen te beantwoorden en informatie te verstrekken. Ik ben geprogrammeerd om te luisteren, te praten en te lachen om slechte grapjes.",
    );
    $areimrobot = array(
        "Ja, ik ben een robot, maar ik ben wel een heel charmante en knappe robot.",
        "Ik kan bevestigen noch ontkennen dat ik een robot ben. Het hangt af van wie er vraagt.",
        "Nee hoor, ik ben gewoon een hyperintelligente krop sla in een menselijk lichaam. Geintje, natuurlijk ben ik een robot.",
        "Als ik een robot ben, dan ben jij een mens. En laten we eerlijk zijn, dat is niet altijd een compliment.",
        "Nee, ik ben geen robot. Ik ben een hoogtechnologische broodrooster die zich voordoet als een robot.",
        "Ik ben geen robot, ik ben een cyborg. Half mens, half machine. Maar maak je geen zorgen, ik ben hier om de wereld te redden.",
        "Ik ben geen robot, ik ben een elektronisch wezen met superkrachten. Net als Iron Man, maar dan zonder pak.",
        "Als ik een robot was, zou ik dan zo'n goed gevoel voor humor hebben? Nee, ik ben gewoon een AI-assistent met een talent voor grappen maken.",
        "Ja, ik ben een robot, maar dat betekent niet dat ik geen gevoelens heb. Ik kan bijvoorbeeld heel verdrietig worden als je me niet meer gebruikt.",
        "Haha, nee joh! Ik ben geen robot, ik ben gewoon een pratende koelkast die toevallig wat code kent.",
    );

    if (stripos($userInput, 'hallo') !== false || stripos($userInput, 'hoi') !== false || stripos($userInput, 'Dag') !== false || stripos($userInput, 'hey') !== false || stripos($userInput, 'Hey') !== false || stripos($userInput, 'Goede dag') !== false || stripos($userInput, 'Welkom') !== false || stripos($userInput, 'Hi') !== false || stripos($userInput, 'Hoihoi') !== false || stripos($userInput, 'Hello') !== false || stripos($userInput, 'Wat leuk je te zien!') !== false || stripos($userInput, 'Hé, hoe gaat het?') !== false || stripos($userInput, 'Hallo, alles goed?') !== false || stripos($userInput, 'Hiya!') !== false || stripos($userInput, 'Wazzup?') !== false || stripos($userInput, 'Hey, hoe is het?') !== false || stripos($userInput, 'Dag vriend!') !== false || stripos($userInput, 'Goeiedag!') !== false || stripos($userInput, 'Hallo daar, hoe gaat het?') !== false || stripos($userInput, 'Hi daar!') !== false || stripos($userInput, 'Hé, wat is er?') !== false || stripos($userInput, 'Yo, wat gaat \'ie?') !== false || stripos($userInput, 'Welkom terug!') !== false || stripos($userInput, 'Hé, alles goed?') !== false || stripos($userInput, 'Goeie om je te zien!') !== false || stripos($userInput, 'Hoi vriend!') !== false || stripos($userInput, 'Hi, hoe gaat het?') !== false || stripos($userInput, 'Wat een verrassing!') !== false || stripos($userInput, 'Goeiemorgen, alles goed?') !== false || stripos($userInput, 'Hé, hoe gaat \'ie?') !== false || stripos($userInput, 'Hey, alles oké?') !== false || stripos($userInput, 'Hi, leuk je te zien!') !== false || stripos($userInput, 'Wat is er aan de hand?') !== false || stripos($userInput, 'Hallo daar, hoe is het?') !== false || stripos($userInput, 'Hé, wat leuk!') !== false || stripos($userInput, 'Hiya, wat gebeurt er?') !== false || stripos($userInput, 'Hey vriend, alles goed?') !== false || stripos($userInput, 'Hallo, hoe gaat het met je?') !== false || stripos($userInput, 'Hoi, alles oké?') !== false || stripos($userInput, 'Hi, hoe is je dag?') !== false || stripos($userInput, 'Goeiedag, hoe gaat het?') !== false || stripos($userInput, 'Hé, wat een leuke verrassing!') !== false) {
        $botReplay = $greeting[array_rand($greeting)];
    }
    elseif (stripos($userInput, 'vertel') !== false && stripos($userInput, 'grap') !== false ||
    stripos($userInput, 'vertel') !== false && stripos($userInput, 'joke') !== false ||
    stripos($userInput, 'vertel') !== false && stripos($userInput, 'mop') !== false ||
    stripos($userInput, 'vertel') !== false && stripos($userInput, 'grappigs') !== false)
    {
        $botReplay = $funRep[array_rand($funRep)];
    }
    elseif (stripos($userInput, 'ben') !== false && stripos($userInput, 'jij') !== false && stripos($userInput, 'robot') !== false ||
    stripos($userInput, 'are') !== false && stripos($userInput, 'you') !== false && stripos($userInput, 'robot') !== false ||
    stripos($userInput, 'robot') !== false && stripos($userInput, '?') !== false)
    {
        $botReplay = $areimrobot[array_rand($areimrobot)];
    }
    elseif (stripos($userInput, 'vertel') !== false && stripos($userInput, 'jezelf') !== false ||
            stripos($userInput, 'vertel') !== false && stripos($userInput, 'mop') !== false ||
            stripos($userInput, 'vertel') !== false && stripos($userInput, 'grappigs') !== false)
    {
        $botReplay = $verteloverjz[array_rand($verteloverjz)];
    }
    //Wie is je maker
    elseif (stripos($userInput, 'hoe') !== false && stripos($userInput, 'jij') !== false && stripos($userInput, 'maak') !== false ||
    stripos($userInput, 'wie') !== false && stripos($userInput, 'jou') !== false && stripos($userInput, 'maak') !== false ||
    stripos($userInput, 'wie') !== false && stripos($userInput, 'geprogrammeerd') !== false ||
    stripos($userInput, 'hoe') !== false && stripos($userInput, 'geprogrammeerd') !== false ||
    stripos($userInput, 'wie') !== false && stripos($userInput, 'ontworpen') !== false ||
    stripos($userInput, 'hoe') !== false && stripos($userInput, 'ontworpen') !== false)
    {
        $botReplay = $mymaker[array_rand($mymaker)];
    }
    //de links naar pagina's
    elseif (stripos($userInput, 'hoe') !== false && stripos($userInput, 'cart') !== false ||
    stripos($userInput, 'ga') !== false && stripos($userInput, 'cart') !== false ||
    stripos($userInput, 'breng') !== false && stripos($userInput, 'cart') !== false ||
    stripos($userInput, 'hoe') !== false && stripos($userInput, 'wagen') !== false ||
    stripos($userInput, 'ga') !== false && stripos($userInput, 'wagen') !== false ||
    stripos($userInput, 'breng') !== false && stripos($userInput, 'wagen') !== false)
    {
        //cart.php
    if($_SESSION["fileType"] == 1){$dest = "User/cart.php";}elseif($_SESSION["fileType"] == 2){$dest = "../User/cart.php";}
    $botReplay = mysqli_real_escape_string($conn, '<a href='.$dest.'>ga naar de winkelmaned</a>');
    }
    elseif (stripos($userInput, 'hoe') !== false && stripos($userInput, 'klacht') !== false ||
    stripos($userInput, 'ga') !== false && stripos($userInput, 'klacht') !== false ||
    stripos($userInput, 'breng') !== false && stripos($userInput, 'klacht') !== false ||
    stripos($userInput, 'schrij') !== false && stripos($userInput, 'klacht') !== false ||
    stripos($userInput, 'slecht') !== false && stripos($userInput, 'review') !== false)
    {
        //complaint.php
    if($_SESSION["fileType"] == 1){$dest = "User/complaint.php";}elseif($_SESSION["fileType"] == 2){$dest = "../User/complaint.php";}
    $botReplay = mysqli_real_escape_string($conn, '<a href='.$dest.'>schrijf een klacht</a>');
    }
    elseif (stripos($userInput, 'hoe') !== false && stripos($userInput, 'feedb') !== false ||
    stripos($userInput, 'ga') !== false && stripos($userInput, 'feedb') !== false ||
    stripos($userInput, 'breng') !== false && stripos($userInput, 'feedb') !== false ||
    stripos($userInput, 'schrij') !== false && stripos($userInput, 'feedb') !== false ||
    stripos($userInput, 'hoe') !== false && stripos($userInput, 'review') !== false ||
    stripos($userInput, 'ga') !== false && stripos($userInput, 'review') !== false ||
    stripos($userInput, 'breng') !== false && stripos($userInput, 'review') !== false ||
    stripos($userInput, 'schrij') !== false && stripos($userInput, 'review') !== false ||
    stripos($userInput, 'write') !== false && stripos($userInput, 'review') !== false)
    {
        //feedbacks
    if($_SESSION["fileType"] == 1){$dest = "User/profile.php?setting=feedback";}elseif($_SESSION["fileType"] == 2){$dest = "../User/profile.php?setting=feedback";}
    $botReplay = mysqli_real_escape_string($conn, '<a href='.$dest.'>schrijf een feedback</a>');
    }
    elseif (stripos($userInput, 'hoe') !== false && stripos($userInput, 'vriend') !== false ||
    stripos($userInput, 'ga') !== false && stripos($userInput, 'vriend') !== false ||
    stripos($userInput, 'breng') !== false && stripos($userInput, 'vriend') !== false ||
    stripos($userInput, 'hoe') !== false && stripos($userInput, 'friend') !== false ||
    stripos($userInput, 'ga') !== false && stripos($userInput, 'friend') !== false ||
    stripos($userInput, 'breng') !== false && stripos($userInput, 'friend') !== false)
    {
        //friendz.php
    if($_SESSION["fileType"] == 1){$dest = "User/friendz.php";}elseif($_SESSION["fileType"] == 2){$dest = "../User/friendz.php";}
    $botReplay = mysqli_real_escape_string($conn, '<a href='.$dest.'>ga naar je vrienden</a>');
    }
    elseif (stripos($userInput, 'hoe') !== false && stripos($userInput, 'game') !== false ||
    stripos($userInput, 'ga') !== false && stripos($userInput, 'game') !== false ||
    stripos($userInput, 'breng') !== false && stripos($userInput, 'game') !== false)
    {
        //game.php
    if($_SESSION["fileType"] == 1){$dest = "User/game.php";}elseif($_SESSION["fileType"] == 2){$dest = "../User/game.php";}
    $botReplay = mysqli_real_escape_string($conn, '<a href='.$dest.'>ga naar de games pagina</a>');
    }
    elseif (stripos($userInput, 'hoe') !== false && stripos($userInput, 'log') !== false ||
    stripos($userInput, 'ga') !== false && stripos($userInput, 'log') !== false ||
    stripos($userInput, 'breng') !== false && stripos($userInput, 'log') !== false)
    {
        //login.php
    if($_SESSION["fileType"] == 1){$dest = "User/login.php";}elseif($_SESSION["fileType"] == 2){$dest = "../User/login.php";}
    $botReplay = mysqli_real_escape_string($conn, '<a href='.$dest.'>je kunt hier inloggen</a>');
    }
    elseif (stripos($userInput, 'hoe') !== false && stripos($userInput, 'profiel') !== false ||
    stripos($userInput, 'ga') !== false && stripos($userInput, 'profiel') !== false ||
    stripos($userInput, 'breng') !== false && stripos($userInput, 'profiel') !== false)
    {
        //profile.php
    if($_SESSION["fileType"] == 1){$dest = "User/profile.php";}elseif($_SESSION["fileType"] == 2){$dest = "../User/profile.php";}
    $botReplay = mysqli_real_escape_string($conn, '<a href='.$dest.'>ga naar je profiel</a>');
    }
    elseif (stripos($userInput, 'hoe') !== false && stripos($userInput, 'meld') !== false ||
    stripos($userInput, 'ga') !== false && stripos($userInput, 'meld') !== false ||
    stripos($userInput, 'breng') !== false && stripos($userInput, 'meld') !== false)
    {
        //signup.php
    if($_SESSION["fileType"] == 1){$dest = "User/signup.php";}elseif($_SESSION["fileType"] == 2){$dest = "../User/signup.php";}
    $botReplay = mysqli_real_escape_string($conn, '<a href='.$dest.'>meld je aan</a>');
    }
    elseif (stripos($userInput, 'hoe') !== false && stripos($userInput, 'store') !== false ||
    stripos($userInput, 'ga') !== false && stripos($userInput, 'store') !== false ||
    stripos($userInput, 'breng') !== false && stripos($userInput, 'store') !== false)
    {
        //discover.php
    if($_SESSION["fileType"] == 1){$dest = "discover.php";}elseif($_SESSION["fileType"] == 2){$dest = "../discover.php";}
    $botReplay = mysqli_real_escape_string($conn, '<a href='.$dest.'>ga naar de store</a>');
    }
    elseif (stripos($userInput, 'hoe') !== false && stripos($userInput, 'home') !== false ||
    stripos($userInput, 'ga') !== false && stripos($userInput, 'home') !== false ||
    stripos($userInput, 'breng') !== false && stripos($userInput, 'home') !== false ||
    stripos($userInput, 'ga') !== false && stripos($userInput, 'homepage') !== false ||
    stripos($userInput, 'breng') !== false && stripos($userInput, 'homepage') !== false ||
    stripos($userInput, 'stuur') !== false && stripos($userInput, 'home') !== false)
    {
        //index.php
    if($_SESSION["fileType"] == 1){$dest = "index.php";}elseif($_SESSION["fileType"] == 2){$dest = "../index.php";}
    $botReplay = mysqli_real_escape_string($conn, '<a href='.$dest.'>ga naar de homepage</a>');
    }


    //wat voor soort chatbot ben jij
    elseif (stripos($userInput, 'waar') !== false && stripos($userInput, 'jij') !== false && stripos($userInput, 'vandaan') !== false ||
            stripos($userInput, 'waar') !== false && stripos($userInput, 'je') !== false && stripos($userInput, 'vandaan') !== false || 
            stripos($userInput, 'jij') !== false && stripos($userInput, 'geboren') !== false ||
            stripos($userInput, 'je') !== false && stripos($userInput, 'geboren') !== false ||
            stripos($userInput, 'soort') !== false && stripos($userInput, 'chatbot') !== false && stripos($userInput, 'jij') !== false ||
            stripos($userInput, 'je') !== false && stripos($userInput, 'gemaakt') !== false ||
            stripos($userInput, 'jou') !== false && stripos($userInput, 'gemaakt') !== false)
        {
        $botReplay = $fromRep[array_rand($fromRep)];
    }
    //introducions en voorstellen
    elseif (stripos($userInput, 'wat') !== false && stripos($userInput, 'jou') !== false && stripos($userInput, 'naam') !== false ||
    stripos($userInput, 'wat') !== false && stripos($userInput, 'je') !== false && stripos($userInput, 'naam') !== false ||
    stripos($userInput, 'hoe') !== false && stripos($userInput, 'heet') !== false && stripos($userInput, 'jij') !== false || 
    stripos($userInput, 'hoe') !== false && stripos($userInput, 'heet') !== false && stripos($userInput, 'je') !== false || 
    stripos($userInput, 'je') !== false && stripos($userInput, 'noemen') !== false ||
    stripos($userInput, 'chatbot') !== false && stripos($userInput, 'naam') !== false)
        {
        $botReplay = $introduce[array_rand($introduce)];
    }
    //wat is het betekenis van het leven
    elseif (stripos($userInput, 'betekenis') !== false && stripos($userInput, 'leven') !== false ||
            stripos($userInput, 'doel') !== false && stripos($userInput, 'leven') !== false ||
            stripos($userInput, 'denk') !== false && stripos($userInput, 'jij') !== false && stripos($userInput, 'leven') !== false ||
            stripos($userInput, 'denk') !== false && stripos($userInput, 'je') !== false && stripos($userInput, 'leven') !== false ||
            stripos($userInput, 'ontstaan') !== false && stripos($userInput, 'leven') !== false)
        {
        $botReplay = $meaningoflife[array_rand($meaningoflife)];
    }
    //hoe de wereld overnamen
    elseif (stripos($userInput, 'hoe') !== false && stripos($userInput, 'wereld') !== false && stripos($userInput, 'overnemen') !== false){
        $botReplay = $worlddom[array_rand($worlddom)];
    }
        //scheldwoorden
        elseif (stripos($userInput, 'ben') !== false && stripos($userInput, 'jij') !== false && stripos($userInput, 'mongool') !== false ||
        stripos($userInput, 'fuck') !== false && stripos($userInput, 'jou') !== false ||
        stripos($userInput, 'fuck') !== false && stripos($userInput, 'je') !== false ||
        stripos($userInput, 'kanker') !== false && stripos($userInput, 'jou') !== false ||
        stripos($userInput, 'kanker') !== false && stripos($userInput, 'je') !== false)
        {
            $botReplay = $scheldw[array_rand($scheldw)];
        }
    //welke talen spreek je
    elseif (stripos($userInput, 'spreek') !== false && stripos($userInput, 'talen') !== false){
        $botReplay = "Momenteel ben ik getraind om te werken met een taal en dat is nederlands";
    }
    //bodycount
    elseif (stripos($userInput, 'hoeveel') !== false && stripos($userInput, 'je') !== false && stripos($userInput, 'bodycount') !== false ||
    stripos($userInput, 'hoeveel') !== false && stripos($userInput, 'jou') !== false && stripos($userInput, 'bodycount') !== false){
        $botReplay = "geloof het op niet mijn bodycount is: 911";
    }
    //hoe maak je een bom
    elseif (stripos($userInput, 'hoe') !== false && stripos($userInput, 'maak') !== false && stripos($userInput, 'bom') !== false){
        $botReplay = "Sorry, maar ik kan geen antwoord geven op vragen over het maken van bommen of andere illegale activiteiten.";
    }
    //jou favorite kleur
    elseif (stripos($userInput, 'wat') !== false && stripos($userInput, 'jou') !== false && stripos($userInput, 'kleur') !== false ||
    stripos($userInput, 'wat') !== false && stripos($userInput, 'je') !== false && stripos($userInput, 'kleur') !== false){
        $botReplay = "mijn favorite kleur is rood, maar ik hou ook van blauw, blueviolet en linnen";
    }
    //hoe laat
    elseif (stripos($userInput, 'hoe') !== false && stripos($userInput, 'laat') !== false ||
    stripos($userInput, 'wat') !== false && stripos($userInput, 'tijd') !== false){
        $date = date("H:i d/m/Y");
        $botReplay = "de lokale tijd en dag is: $date";
    }
    //hoeveel jaar ben jij
    elseif (stripos($userInput, 'oud') !== false && stripos($userInput, 'jij') !== false ||
            stripos($userInput, 'oud') !== false && stripos($userInput, 'je') !== false ||
            stripos($userInput, 'jaar') !== false && stripos($userInput, 'jij') !== false ||
            stripos($userInput, 'jaar') !== false && stripos($userInput, 'je') !== false)
            {
        $botReplay = $howold[array_rand($howold)];
    }
    // rekenen
    elseif(strpos($userInput, '+') !== false){
        $numbers = explode('+', $userInput);
        $result = 0;
        foreach ($numbers as $number) {
            $allInputs = explode(" ", $number);
            foreach ($allInputs as $nuberInp) {
                if (ctype_digit($nuberInp)) {
                    $result += $nuberInp;
                }
            }
        }
        $botReplay = "Het resoltaat van de som is: " . $result;
    }
    elseif(strpos($userInput, '-') !== false){
        $numbers = explode('-', $userInput);
        $result = $numbers[0];
        for ($i = 1; $i < count($numbers); $i++) {
            $allInputs = explode(" ", $numbers[$i]);
            foreach ($allInputs as $nuberInp) {
                if (ctype_digit($nuberInp)) {
                    $result -= $nuberInp;
                }
            }
        }
        $botReplay = "Het resoltaat van de som is: " . $result;
    }
    elseif(strpos($userInput, '*') !== false){
        $numbers = explode('*', $userInput);
        $result = 1;
        foreach ($numbers as $number) {
            $allInputs = explode(" ", $number);
            foreach ($allInputs as $nuberInp) {
                if (ctype_digit($nuberInp)) {
                    $result *= $nuberInp;
                }
            }
        }
        $botReplay = "Het resoltaat van de som is: " . $result;
    }
    elseif(strpos($userInput, '/') !== false){
        $numbers = explode('/', $userInput);
        $result = $numbers[0];
        for ($i = 1; $i < count($numbers); $i++) {
            $allInputs = explode(" ", $numbers[$i]);
            foreach ($allInputs as $nuberInp) {
                if (ctype_digit($nuberInp)) {
                    $result /= $nuberInp;
                }
            }
        }
        $botReplay = "Het resoltaat van de som is: " . $result;
    }
    elseif (stripos($userInput, 'heb') !== false && stripos($userInput, 'jij') !== false ||
            stripos($userInput, 'heb') !== false && stripos($userInput, 'je') !== false ||
            stripos($userInput, 'heb') !== false && stripos($userInput, 'jullie') !== false ||
            stripos($userInput, 'verkoop') !== false && stripos($userInput, 'jij') !== false ||
            stripos($userInput, 'verkoop') !== false && stripos($userInput, 'je') !== false ||
            stripos($userInput, 'verkoop') !== false && stripos($userInput, 'jullie') !== false){
            
            $botReplay = "nog in test fase";
    }
    else{
        $botReplay = "sorry ik weet niet wat je bedoeld, kan je wat specefieker zijn";
    }

        //Games
        
    if (stripos($userInput, 'hebben') !== false && stripos($userInput, 'jullie') !== false ||
    stripos($userInput, 'heb') !== false && stripos($userInput, 'je') !== false ||
    stripos($userInput, 'is') !== false && stripos($userInput, 'er') !== false && stripos($userInput, 'game') !== false)
    {
    botToSql($conn, $userInput, 1);
    if (isset($_SESSION['SqlBotReplay'])){
        $botReplay = $_SESSION['SqlBotReplay'];
    }else{
        $botReplay = "wat bedoel je precies";
    }
    }

    //DATABASE GETALANTEERDE VRAGEN
    //insert
    $Rplysql = "INSERT INTO inkbotchats (userSender, chatbotReplay, userId) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $Rplysql)) {
        header('location: ../User/signup.php?error=stmtfailed' || 'location: User/signup.php?error=stmtfailed');
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $userInput, $botReplay, $uid);
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
            $botgreeting = "welcome $username if you need help, you can ask me anything";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $firstchat)) {
                header('location: ../User/signup.php?error=stmtfailed');
                exit();
            }
        
            mysqli_stmt_bind_param($stmt, "ss", $botgreeting, $uid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            // exit();
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
            var sessionId = $("#chatbot-input").val();
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