
//var instanse = false;
//var state;
//var mes;
//var file;


//global variables
var playerId;
var gameId;
var update;
var alerts = 0;

function Chat () {
	this.createGame = createGame;
    this.update = updateChat;
    this.send = sendChat;
	this.getState = getStateOfChat;
	this.setVariables = setVariables;
}

// sets the interval to update every second
function createGame(x, y){

	//var gameId = <?php echo $_POST['gameId']; ?>;
	update = setInterval(updateChat(), 1000);
}

//sets the global variables
function setVariables(x, y){
	playerId = x;
	gameId = y;
}


//gets the state of the chat
function getStateOfChat(){
	// if(!instanse){
	// 	 instanse = true;
		 $.ajax({
			   type: "POST",
			   url: "process.php",
			   data: {  
						'function': 'getState',
						'gameId': gameId,
						'playerId': playerId,
						//'file': file
						},
			   dataType: "json",
			
			   success: function(data){
				   state = data.state;
				   instanse = false;
			   },
			});
	//}	 
}

//Updates the chat
function updateChat(){

	if(alerts <= 2){
		alert("GameId: " + gameId + "PlayerId: " + playerId); //works only twice just to avoid it getting spamed
		alerts ++; 
	}

	     $.ajax({
			   type: "POST",
			   url: "process.php",
			   data: {  
						'function': 'update',
						'gameId': 1,
						'playerId': 1,

						},
			   dataType: "json",
			   success: function(data){
				//    if(data.text){
				// 		for (var i = 0; i < data.text.length; i++) {
                //             $('#chat-area').append($("<p>"+ data.text[i] +"</p>"));
                //         }								  
				//    }
				//    success: function(response){
					//Use response
					//alert("Server echo: "+response);
				   alert(data);
				   $("#output_element").html(data);
				   //document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
				   //instanse = false;
				   //state = data.state;
			   },
			   error: function(msg){
				//   this will always get called so commented it out.
               		 alert("Error: "+msg);
               }
			});
	 //}
	 //else {
		// setTimeout(updateChat, 1500);
	 //}
}

//send the message
function sendChat(message, playerName)
{       
    updateChat();
     $.ajax({
		   type: "POST",
		   url: "process.php",
		   data: {  
		   			'function': 'send',
					'message': message,
					'gameId': gameId,
					'playerId': playerId,
					'playerName': playerName,
				 },
		   //dataType: "json",
		   success: function(data){
			   updateChat();
		   },
		});
}
