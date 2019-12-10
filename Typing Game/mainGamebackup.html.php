<!DOCTYPE html>
<html>
<head>
<meta name="description" content="Vue Template">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <script src="https://unpkg.com/vue/dist/vue.js"></script>
  <title>Typing Game</title>
</head>
<style>
	.column{
		margin: auto;
		display: inline-block;
		width: 19%;
		height: 500px;
		border: 1px solid black;
		text-align: center;
	}
	div div{
		width: 100%;
		border: 1px solid black;
		position: relative;
		animation-name: falling;
		animation-duration: 12.5s;
		background-image: url("images/asteroid.jpg");
	}
	
	@keyframes falling {
		from {top:0%;}
		to{top:96%;}
	}
</style>
<body onload="loadGame()" onkeypress="myFunction(event)">
	
	<span> 
		<div class="column" id="column1"></div>
		<div class="column" id="column2"></div>
		<div class="column" id="column3"></div>
		<div class="column" id="column4"></div>
		<div class="column" id="column5"></div>
	</span>
	<p id="text"> </p>
	<form id="form" name="hiddenForm" action="saveScore.php" method="post">
		<input type="hidden" name="score">
	</form>
	

<script>
	var extraWords = <?php
		//database login info
		$servername = "sql111.epizy.com";
		$username = "epiz_24432239";
		$password = "uhtayIl4oZMmqA";
		$dbname = "epiz_24432239_game_db";
		
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$sql = "SELECT * FROM words";
		$result = $conn->query($sql);
		$columns = array();
		while($r = $result->fetch_assoc()){
			$columns[] = mb_convert_encoding($r["word"], 'UTF-8','UTF-8');
		}
		echo json_encode($columns);
		$conn->close();
	?>;
	var buffer = "";
	var words = [];
	var startTime = Date.now();
	var addWordTimer;
	var gameEnded = false;
	var maxWordLength = 3;
	var minWordLength = 1;
	var matchedWords = 0;
	var increaseMax = true;
	
	
	
	
	function myFunction() {
		if(!gameEnded){
		  var x = event.key;
		  var matches = false;
		  buffer = buffer + x;
		  
		  for(i=0; i < words.length; i++){
			var word = words[i];
			if(buffer == word.substring(0,buffer.length)){
				matches = true;
				boldedWord = word.substring(0,buffer.length).bold() + word.substring(buffer.length, word.length);
				document.getElementById(word).innerHTML = boldedWord;
				if(buffer.length == word.length){
					document.getElementById(word).remove();
					addWord(i+1);
					buffer = "";
					matchedWords++;
					if(matchedWords == 7){
						if(increaseMax && maxWordLength < 10){
							maxWordLength++;
							increaseMax = false;
						}else if(minWordLength < 10){
							minWordLength++;
							increaseMax = true;
						}
						matchedWords = 0;
					}
					
				}
			}else{
				document.getElementById(word).innerText = word;
			}
		  }
		  if(matches == false){
			buffer = "";
		  }
		  
		  document.getElementById("text").innerHTML = buffer + "<br>Max: " + maxWordLength + "<br>Min: " + minWordLength;
	  }
	}
	
	
	
	function addWord(column){
		if(!gameEnded){
			
			var word;
			do{
				var randomNum = Math.floor(Math.random() * extraWords.length);
				word = extraWords[randomNum];
			}while(word.length > maxWordLength || word.length < minWordLength);
			
			words[column-1] = word;
			
			var div = document.createElement("div");
			div.id = word;
			div .innerHTML = word;
			document.getElementById("column"+column).appendChild(div);
			div.addEventListener("animationend", listener, false);
		}
	}
	
	function loadGame(){
		for(i=1; i<6; i++){
			addWord(i);
		}
	}
	
	function listener(event){
		if(event.type == "animationend" && !gameEnded){
			var score = Date.now()-startTime;
			alert("Game Over!\nYour score is: "+score);
			gameEnded = true;
			document.forms["hiddenForm"]["score"].value = score;
			document.getElementById("form").submit();
		}
	}
	
	
</script>
</body>
</html>