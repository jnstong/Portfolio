<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/> 
        <link rel="stylesheet" type="text/css" href="egyptian.css?Version=1.6"/>
        <title>WSU CS3750 Assignment #2</title>
        
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script type="text/javascript" src="ajax.js"></script>
        <script type="text/javascript" src="deck.js"></script>
        <script type="text/javascript">


// kick off game
        var game = new Game();
    	$(function() {            
        })
        
        </script>

</head>

<body onload="load()">
    <script>
        function load(){
        // this gets the inputed information and sends it to the javascript
        var playerId = <?php echo $_POST['playerId'];?>;
        var gameId = <?php echo $_POST['gameId']; ?>;
        game.createGame(playerId, gameId);
	    setInterval(game.update, 1000);
    }
    </script>
       <nav id="navigation">
            <ul>
               <li><a href="/home.html">Home</a></li>
               <li><a href="/game.html">Play Now</a></li>
               <li><a href="/aboutus.php">About Us</a></li>
            </ul>
         </nav>
        <section id="GameSection">
          <div class="wrapper">
              <div id="topLeftDiv">
                    <h1 id="opponentName">OPPONENT</h1><br/>
                    <p class="cardCountText" id="opponentCardCountText">26</p>
              </div>
              <div id="topMiddleDiv">
                <img src="images/DeckPNG/red_back.png" id="opponentsDeckImg">

                <!-- Need to have Deck Cards Count: not currently implemented.-->
              </div>
              <div id="topRightDiv">
                    <audio id="myAudio">
                            <source src="sounds/egyptian.mp3" type="audio/mpeg">
                                Your browser does not support the audio element.
                        </audio>
                        <button onclick="toggleAudio()" class="btn" id="speakerBtn"><img src="images/speaker.png"></i> </button>
                        <script src="/music.js"></script>
              </div>
                <div id="middleDiv" class = "innerWrapper">
                </div>
                <div id="bottomLeftDiv">
                        <h1 id="playerName">PLAYER</h1><br/>
                        <p class="cardCountText" id="playerCardCountText">26</p>
                    </div>
                    <div id="bottomMiddleDiv">

                      <img src="images/DeckPNG/red_back.png" id="playersDeckImg">
                      <!-- Need to have Deck Cards Count: not currently implemented.-->
                    </div>
                    <div id="bottomRightDiv">TEST'S TURN</div> <!-- This will be determined by The Server, just a placeholder for now. -->
          </div>
          <script src="/misc.js"></script>
        </section>
    </body>       
    <footer id="footer">
            <a href="https://www.youtube.com" target="_blank">
                <img alt="Youtube logo" src="/images/youtube2.png" class = "icon" id="ytIcon">
                </a>
                <a href="https://www.facebook.com" target="_blank">
                <img alt="Facebook logo" src="/images/facebook2.png"  class = "icon" id="fbIcon">
                </a>
                <a href="https://www.twitter.com" target="_blank">
                <img alt="Twitter logo" src="/images/twitter2.png"  class = "icon" id="twIcon"></a>
    </footer> 
            <script type="text/javascript" src="/updateCards.js"></script>
            </html>