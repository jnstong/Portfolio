<!DOCTYPE html>
<html>
	<head>
		<title>New User</title>
	</head>
	<body>
		<h1>Create New User</h1>
		<form  name = "userInfo" onsubmit="confirm()" method="post">
			User Name:<br>
			<input type="text" name="userName" required>
			<br>
			Password:<br>
			<input type="text" name="password" id="password" required>
			<br>
			Confirm Password:<br>
			<input type="text" name="confirmPassword" id="confirmPassword" required>
			<br>
			<input type="submit" value="Create User">
		</form>
		
	</body>
	
	<script>
		function confirm(){
			var pass = document.getElementById("password").value;
			var confirmPass = document.getElementById("confirmPassword").value;
			if(pass != confirmPass){
				alert("Password did not match!");
				return false;
			}
			var salt = <?php echo 35; ?>;
			alert(salt);
			return true;
		}
		
	</script>
	<script src="hashPassword.js"></script>
	
</html>