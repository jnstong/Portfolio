<HTML>
<body onload="setForm()">
	<form action="discardPile.php" id="egypt" method="post">
		<input type = "hidden" name = "player" id="player">
		<input type = "hidden" name = "gameId" id="game">
		<input type="submit" value="Slap Discard Pile">
		
	</form>
	
	<script>
		function setForm(){
			document.getElementById("player").value = <?php echo $_POST["player"];?>;
			document.getElementById("game").value = <?php echo $_POST["gameId"];?>;
		}
	</script>
	<?php
		function testFaceCard($card){
			$cardValue = substr($card,0,1);
			switch($cardValue){
				case "J":
					return 1;
				case "Q":
					return 2;
				case "K":
					return 3;
				case "A":
					return 4;
				default:
					return 0;
			}
		}
		
		function changeTurnOwner($turnOwner, $numberOfPlayers, $conn){
			
			if($turnOwner < $numberOfPlayers){
				$turnOwner++;
			}else{
				$turnOwner = 1;
			}
			
			$sql = "SELECT player_deck FROM Decks WHERE game_id = '".$_POST["gameId"]."' AND player_number = ".$turnOwner.";";
			
			$result = $conn->query($sql)->fetch_assoc();
			$deck = $result["player_deck"];
			//echo "Player: ".$turnOwner."'s Deck: ".$deck."<br>";
			
			if($deck == ""){
				//echo "Player ".$turnOwner." is out of cards. <br>";
				$turnOwner = changeTurnOwner($turnOwner, $numberOfPlayers, $conn);
			}
			
			return $turnOwner;
		}
	
		$servername = "sql209.epizy.com";
		$username = "epiz_24645009";
		$password = "4cOMn3ct3F8";
		$dbname = "epiz_24645009_egyptian_slap";
		
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		//Get Game info
		$sql = "SELECT game_id, number_of_players, turn_owner, attempts_left, current_owner FROM Games WHERE game_id = '".$_POST["gameId"]."';";
		$result = $conn->query($sql)->fetch_assoc();
		$gameId = $result["game_id"];
		$numberOfPlayers = $result["number_of_players"];
		$turnOwner = $result["turn_owner"];
		$attemptsLeft =  $result["attempts_left"];
		$currentOwner = $result["current_owner"];
		
		
		echo "Player ".$_POST["player"]. " trying to take your turn<br>";
		if($_POST["player"] != $turnOwner){
			//echo "Player ".$_POST["player"]." it is not your turn! It is player ".$turnOwner."'s turn.";
			exit();
		}elseif($attemptsLeft != NULL and $attemptsLeft == 0){
			$winner = $turnOwner-1;
			if($winner == 0){
				$winner = $numberOfPlayers;
			}
			echo "You are out of attempts!<br>Player ".$winner." wins the pile";
		}else{
			
			//return the card on top of the deck
			$sql = "SELECT player_deck FROM Decks WHERE game_id = '".$_POST["gameId"]."' AND player_number = ".$_POST["player"].";";
			$result = $conn->query($sql)->fetch_assoc();
			$card = substr($result["player_deck"], 0, strpos($result["player_deck"],","));
			$deck = substr($result["player_deck"], strpos($result["player_deck"],",")+1);
			
			if($card == ""){
				$turnOwner = changeTurnOwner($turnOwner, $numberOfPlayers, $conn);
				echo "You are out of cards and have lost!<br>";
			}
			else{
			
				echo "You played ".$card;
				echo "<br>";
				echo "Your deck is: ".$deck."<br>";
			
				//remove the card from the deck
				$sql = "UPDATE Decks SET player_deck = '".$deck."' WHERE game_id = '".$_POST["gameId"]."' AND player_number = ".$_POST["player"].";";
				$conn->query($sql);
			
				//add the card to the discard deck
				$sql = "UPDATE Decks SET player_deck = CONCAT(CONCAT('".$card."', ','), player_deck) WHERE game_id = '".$_POST["gameId"]."' AND player_number = 0;";
				if ($conn->query($sql) === TRUE) {
				
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
			
				//show the discard pile
				$sql = "SELECT player_deck FROM Decks WHERE game_id = '".$_POST["gameId"]."' AND player_number = 0;";
				$discard = $conn->query($sql)->fetch_assoc()["player_deck"];
				echo "Discard Pile: ".$discard."<br>";
			
			
				$faceCardValue = testFaceCard($card);
				if($faceCardValue === 0){
					if($attemptsLeft === NULL){
						$turnOwner = changeTurnOwner($turnOwner, $numberOfPlayers, $conn);
						echo "No facecard yet!<br>";
					}else{
						$attemptsLeft--;
						echo "Attempts left ".$attemptsLeft."<br>";
					}
				}else{
					$attemptsLeft = $faceCardValue;
					$turnOwner = changeTurnOwner($turnOwner, $numberOfPlayers, $conn);
					$currentOwner = $_POST["player"];
					echo "You got a facecard!<br>";
				}
			}
			echo "It is player ".$turnOwner."'s turn! They have ".$attemptsLeft." attempts left";
			
			if($attemptsLeft === NULL){
				$attemptsLeft = "NULL";
			}
			if($currentOwner === NULL){
				$currentOwner = "NULL";
			}
			
			$sql = "UPDATE Games SET turn_owner = ".$turnOwner.", attempts_left = ".$attemptsLeft.", current_owner = ".$currentOwner." WHERE game_id = '".$_POST["gameId"]."';";
			if ($conn->query($sql) === TRUE) {
			
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
			
		}
	?>
</body>
</HTML>