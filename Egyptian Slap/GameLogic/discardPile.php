<HTML>
<?php
	$servername = "sql209.epizy.com";
	$username = "epiz_24645009";
	$password = "4cOMn3ct3F8";
	$dbname = "epiz_24645009_egyptian_slap";
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	//echo "Game: ".$_POST["gameId"]."<br>";
	//echo "Player: ".$_POST["player"]."<br>";
	
	//Get Game info
	$sql = "SELECT game_id, number_of_players, turn_owner, attempts_left, current_owner FROM Games WHERE game_id = '".$_POST["gameId"]."';";
	$result = $conn->query($sql)->fetch_assoc();
	$gameId = $result["game_id"];
	$numberOfPlayers = $result["number_of_players"];
	$turnOwner = $result["turn_owner"];
	$attemptsLeft =  $result["attempts_left"];
	$currentOwner = $result["current_owner"];
	
	//Get Discard Pile Info
	$sql = "SELECT player_deck FROM Decks WHERE game_id = '".$_POST["gameId"]."' AND player_number = 0;";
	$discard = $conn->query($sql)->fetch_assoc()["player_deck"];
	$pos1 = strpos($discard, ",");
	$pos2 = strpos($discard, ",", $pos1);
	$card1Value = substr($discard, 0, $pos1-1);
	$card2Value = substr($discard, $pos1+1, $pos2-1);
	//echo $discard."<br>";
	//echo "Card1: ".$card1Value."<br>Card2: ".$card2Value."<br>";
	
	//set the winner of the pile if there is one
	$winner = "";
	if($attemptsLeft != NULL and $attemptsLeft == 0){
		$winner = $currentOwner;
		//echo "Winner: ".$winner."<br>";
	}
	
	//decide what should happen because of their slap
	if($_POST["player"] > $numberOfPlayers){
			echo "You aren't in the game!";
	}elseif($card1Value == $card2Value && $card2Value != FALSE){
		//echo "You won the slap and get the pile!";
		winPile($discard, $conn);
	}
	elseif($winner == $_POST["player"]){
		//echo "You won the pile!<br>";
		winPile($discard, $conn);
	}
	elseif($discard != ""){
		//echo "You slapped the deck when you shouldn't have!<br>The top 2 cards of your deck are going on the bottom of the discard!<br>";
		loseCards($discard, $conn);
	}else{
		//echo "The discard is empty nothing happens";
	}
	$conn->close();
	
	function winPile($discard, $conn){
		$sql = "SELECT player_deck FROM Decks WHERE game_id = '".$_POST["gameId"]."' AND player_number = ".$_POST["player"].";";
		$playerDeck = $conn->query($sql)->fetch_assoc()["player_deck"];
		$playerDeck = $playerDeck . $discard;

		$sql = "UPDATE Decks SET player_deck = '".$playerDeck."' WHERE game_id = '".$_POST["gameId"]."' AND player_number = ".$_POST["player"].";";
		$conn->query($sql);
		
		$sql = "UPDATE Decks SET player_deck = '' WHERE game_id = '".$_POST["gameId"]."' AND player_number = 0;";
		$conn->query($sql);
		
		$sql = "UPDATE Games SET turn_owner = ".$_POST["player"].", attempts_left = NULL WHERE game_id = '".$_POST["gameId"]."';";
		$conn->query($sql);
		//echo "It is you turn <br>";
	}
	
	function loseCards($discard, $conn){
		$sql = "SELECT player_deck FROM Decks WHERE game_id = '".$_POST["gameId"]."' AND player_number = ".$_POST["player"].";";
		$playerDeck = $conn->query($sql)->fetch_assoc()["player_deck"];
		$pos1 = strpos($playerDeck, ",");
		if($pos1 != false){
			$pos2 = strpos($playerDeck, ",", $pos1+1);
		}
		$cardsLost = "";
		echo "Pos1 $pos1<br>";
		echo "Pos2 $pos2<br>";
		
		if($pos1 < $pos2){
			$cardsLost = substr($playerDeck, 0, $pos2+1);
			$playerDeck = substr($playerDeck, $pos2+1);
		}else{
			$cardsLost = $playerDeck;
			$playerDeck = "";
		}
		

		
		//echo "After: ".$playerDeck."<br>";
		echo "Cards Lost: ".$cardsLost."<br>";
		
		$discard = $discard . $cardsLost;
		//echo "Discard: ".$discard."<br>";
		
		$sql = "UPDATE Decks SET player_deck = '".$playerDeck."' WHERE game_id = '".$_POST["gameId"]."' AND player_number = ".$_POST["player"].";";
		$conn->query($sql);
		
		$sql = "UPDATE Decks SET player_deck = '".$discard."' WHERE game_id = '".$_POST["gameId"]."' AND player_number = 0;";
		$conn->query($sql);
		
		
	}
?>
</HTML>