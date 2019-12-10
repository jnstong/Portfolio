<!DOCTYPE html>
<head>
    <title>FlipOrSlap</title>
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="ajax.js"></script>
    <script type="text/javascript">

    


        // gets name from post
        var name = <?php echo "'".$_POST['playerName']."'";?>;
        //var gameId = promt("Enter your gameId: ");
        
        // default name is 'Player'
    	if (!name || name === ' ') {
    	   name = "Player";	
        }
        
        // var playerId = ?php echo $_POST['playerId'];?>;
        // var gameId = ?php echo $_POST['gameId']; ?>;

    	
        // kick off chat
        var chat =  new Chat();
    	$(function() {
    		 chat.getState(gameId, playerId);             
        })
        

    </script>

</head>

<body onload="load()">
<script>
function load(){
    // this gets the inputed information and sends it to the javascript
    var playerId = <?php echo $_POST['playerId'];?>;
    var gameId = <?php echo $_POST['gameId']; ?>;
    chat.setVariables(playerId, gameId);
	//var gameId = ?php echo $_POST['gameId']; ?>;
	setInterval(chat.update, 1000);
}

</script>

    <div id="page-wrap">
    
        <h2>FlipOrSlap</h2>
        
        <p id="name-area"></p>
        
        <div id="chat-wrap"><div id="cards"></div></div>
        
        <form id="send-message-area">
            <input type = "button" id = "flip" value = "flip" onclick = "flipDeck()">
            <input type = "button" id = "slap" value = "slap" onclick = "slapDeck()">
        </form>
    
    </div>

    <script>
    function slapDeck(){
        // send           
        chat.send("S", name);	
    }
    function flipDeck(){
        chat.send("F", name);	
    }
    </script>

</body>

</html>