<!DOCTYPE html>
<head>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>
<body>
	<div id="discardDeck"></div>
	<br>
	<button onclick="flip()">Flip</button>
	<button onclick="slap()">Slap</button>
	
	<script>
	
		var playerId;
		var gameId = <?php echo "'".$_POST["gameId"]."'";?>;
		var updateDeck = function(){
			$.post("update.php",
			{
				gameId: <?php echo "'".$_POST["gameId"]."'";?>
			},
			function(data, status){
				document.getElementById("discardDeck").innerHTML = data;
			}
			);
		};
		
		setInterval(updateDeck, 3000);
		
		function flip(){
			$.post("playerDeck.php",
			{
				gameId: <?php echo "'".$_POST["gameId"]."'";?>,
				player: <?php echo $_POST["player"];?>
			}
			);
		};
		
		function slap(){
			$.post("discardPile.php",
			{
				gameId: <?php echo "'".$_POST["gameId"]."'";?>,
				player: <?php echo $_POST["player"];?>
			}
			);
		};
		
		$(window).unload(function () {
            $.ajax({
                type: 'POST',
                async: false,
                url: 'exitGame.php',
                data: {
					gameId: <?php echo "'".$_POST["gameId"]."'";?>,
					player: <?php echo $_POST["player"];?>	
				}
            });
        });
	</script>
</body>


</html>