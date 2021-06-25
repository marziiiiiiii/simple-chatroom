<?php
//session_start(); 
?>
<html>

<head>
	<link rel="stylesheet" href="signinup styles.css" />

	<title>SignUp</title>

</head>

<body>

	<?php


	if (isset($_POST['user']) && isset($_POST['pass'])) {
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		if (!empty($user) && !empty($pass)) {

			//check database
			$con = mysqli_connect("localhost", "root", "", "chat");
			if (!$con) {
				die(mysqli_connect_errno());
			}

			$sql = "INSERT INTO users (user, pass, picture) 
			VALUES ('" . $user . "', '" . $pass . "',NULL)";



			if (mysqli_query($con, $sql)) {
				echo "New record created successfully";
				$expire = time() + 60 * 60 * 24 * 7;
				setcookie("user", $user, $expire);
				setcookie("signedin", "1", $expire);

				echo "Cookies have set.";

				header('Location: chat.php');
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($con);
			}

			mysqli_close($con);
		} else {
			echo '<div class="warning">You must enter a username and password.</div>';
		}
	}
	?>
	<div class='main'>
		<form action="signup.php" method="POST">
			<br>
			<div class='info'>
				Usrename: <input type="text" name="user">
			</div>
			<div class='info'>
				Password: <input type="password" name="pass">
			</div>
			<div><button class="btn" type="submit">Sign Up</button>
				<button class="btn" type="submit">Sign In</button>
			</div>
		</form>
	</div>
</body>
<!-- <style>
	

	

	.info {
		color: #551A8B;
		font-size: 18px;
		font-weight: bold;
	}

	
</style> -->

</html>