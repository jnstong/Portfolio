
//global variables
var playerId;
var gameId;
var update;
var alerts = 0;


function Game () {
	this.createGame = newGame;
    this.update = updateGame;
    this.send = sendGame;

}

// Creates a new game with given parameters.
function newGame(x,y){
	playerId = x;
	gameId = y;
	
	$.ajax({
		type: "POST",
		url: "process.php",
		data: {  
				 'function': 'create',
				 'gameId': gameId,
				 'player': playerId,
				 //'playerName': playerName
				 },
		//dataType: "json",
		success: function(data){
			//playerId = JSON.stringify(data);
		},
	 });
	update = setInterval(updateGame(), 1000);
}

//Updates the game
function updateGame(){
	     $.ajax({
			   type: "POST",
			   url: "process.php",
			   data: {  
						'function': 'update',
						'gameId': gameId,
						'player': playerId,

						},
			   dataType: 'JSON',
			   success: function(data){
				console.log(data);
				var cardArray = Array();
					cardArray =  data.cards;
				addCard(cardArray);
				//document.getId
				//cards are cards
				//deckSizes are deck sizes
				//userNames = names
				//document.getElementById("cards").innerHTML = JSON.stringify(data.deckSizes[0]);

			   },
			   error: function(jqXHR, textStatus, errorThrown) {
                alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

                $('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
                console.log('jqXHR:');
                console.log(jqXHR.responseText);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
				console.log(errorThrown);
            }

			});
}

//send the message
function sendGame(message)
{       
    updateGame();
     $.ajax({
		   type: "POST",
		   url: "process.php",
		   data: {  
		   			'function': 'send',
					'message': message,
					'gameId': gameId,
					'player': playerId,
				 },
		   dataType: "json",
		   success: function(data){
			   updateGame();
		   },
		});
}
