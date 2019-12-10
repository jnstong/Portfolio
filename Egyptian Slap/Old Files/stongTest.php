<HTML>
	<?php
		$discardDeck = array('2H', '3H', '4H', '5H', '6H', '7H', '8H', '9H', '10H', 'JH', 'QH', 'KH', 'AH',
							'2D', '3D', '4D', '5D', '6D', '7D', '8D', '9D', '10D', 'JD', 'QD', 'KD', 'AD',
							'2C', '3C', '4C', '5C', '6C', '7C', '8C', '9C', '10C', 'JC', 'QC', 'KC', 'AC',
							'2S', '3S', '4S', '5S', '6S', '7S', '8S', '9S', '10S', 'JS', 'QS', 'KS', 'AS',
							);
		shuffle($discardDeck);
		$playerDecks = array();
		$players = 2;		//number of players playing
		
		//creates a deck (array) for each player
		for($i=0; $i<$players; $i++){
			$playerDecks[] = array();
		}
		$players--; //here to prevent an off by 1 error
		
		//deals out cards to the players decks
		foreach($discardDeck as $card){
			if($players < 0){
				$players = count($playerDecks) - 1;
			}
			$playerDecks[$players][] = $card;
			$players--;
		}
		
		//clears the discardDeck, isn't actually needed for now
		$discardDeck = array();
		
		$servername = "sql209.epizy.com";
		$username = "epiz_24645009";
		$password = "4cOMn3ct3F8";
		$dbname = "epiz_24645009_egyptian_slap";
		
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$players = count($playerDecks);
		//create the game
		$sql = "INSERT INTO Games(number_of_players, turn_owner) VALUES (".$players.", 1)";
		if ($conn->query($sql) === TRUE) {
			echo "created Game <br>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		//Get Game Id
		$sql = "SELECT LAST_INSERT_ID() AS 'game_id';";
		$gameId = $conn->query($sql)->fetch_assoc()["game_id"];
		
		echo "Game Id: ".$gameId."<br>";
		
		//loops through so each player is saved
		;
		for($i=0; $i<$players;){
			$deck = "";
			//formats the array to be saved in the database
			foreach($playerDecks[$i] as $card){
				$deck = $deck.$card.",";
			}
			$i++; //increments here so the "player_number" doesn't start at 0 when it gets saved
			$sql = "INSERT INTO Decks(game_id,player_number, player_deck) VALUES (".$gameId.",".$i.", '".$deck."')";

			if ($conn->query($sql) === TRUE) {
				echo "created ".$deck."<br>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		$sql = "INSERT INTO Decks(game_id,player_number, player_deck) VALUES (".$gameId.",0,'')";
		$conn->query($sql);
		$conn->close();
	?>
	
</HTML>