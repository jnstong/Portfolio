<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <link rel="stylesheet" type="text/css" href="egyptian.css?Version=1.6">
        <title>WSU CS3750 Assignment #2</title>
    </head>
    <body>
        <nav id="navigation">
            <ul>
               <li><a href="/home.html">Home</a></li>
               <li><a href="/game.html">Play Now</a></li>
               <li><a href="/aboutus.php">About Us</a></li>
            </ul>
         </nav>
        <section id="SetupSection">
          <h1>GAME SETUP</h1>
          <img src="images/tut.png" id="tutImg"/>
          <hr/>
          <br/>
          <form id="gameSetupForm" name="gamesetup" action="slap.php" method="POST">
            Username:<input type="text" id="userName" name="username" maxlength="10"/><br/>
            <br/>
            Lobby Password:<input type="text" id="gameId" name="gameId"/><br/>
            <br/>
            PlayerID: <input type="text" id = "playerId" name="playerId" /><br/>

            <input type="submit" value="CREATE GAME" id="submitBtn" class="submitBtn"/>
          </form>

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
</html>
