<html>

<head>
	<link rel="stylesheet" href="signinsignup.css" />

	<title>SignUp/SignUp</title>

</head>

<body>

	<?php
	$msg = "";
	if (isset($_COOKIE["signedin"]) && $_COOKIE["signedin"] == '1')
		header('Location: chat.php');

	if (isset($_POST['user']) && isset($_POST['pass'])) {
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		$sign = $_POST['sign'];

		if (!empty($user) && !empty($pass)) {

			//check database
			$con = mysqli_connect("localhost", "root", "", "chat");
			if (!$con) {
				die(mysqli_connect_errno());
			}
			$chekedSignIn = false;
			$checkedSignUp = false;

			if ($sign == "Sign Up") {
				$sql = "INSERT INTO users (user, pass, picture) 
					VALUES ('" . $user . "', '" . $pass . "',NULL)";

				$checkedSignUp = true;
			} else {
				$result = mysqli_query($con, "SELECT user, pass FROM users WHERE user = '" . $user . "' AND  pass = '" . $pass . "'");

				$check_user = null;
				$check_pass = null;

				while ($row = mysqli_fetch_array($result)) {
					$check_user = $row['user'];
					$check_pass = $row['pass'];

					echo "user pass is correct.";
				}

				if ($user == $check_user && $pass == $check_pass) {
					echo "Matches.";
					$chekedSignIn = true;
				}
			}

			if ($chekedSignIn || $checkedSignUp) {
				$con->query($sql);
				$expire = time() + 60 * 60 * 24 * 7;
				setcookie("user", $user, $expire);
				setcookie("signedin", "1", $expire);
				header('Location: chat.php');
			} else {
				$msg = "No match found. Try again.";
			}


			$con->close();

			// if (mysqli_query($con, $sql)) {

			// 	echo "Cookies have set.";

			// } else {
			// 	echo "Error: " . $sql . "<br>" . mysqli_error($con);
			// }

			// mysqli_close($con);
		} else {
			$msg = "*You must enter a username and password.";
			// echo '<div class="warning">You must enter a username and password.</div>';
		}
	}
	?>
	<div class='welcome'>welcome to SMSM messenger</div>
	<img src="./resourses/sep2.png" alt="">
	<div class='main'>
		<form action="signinsignup.php" method="POST">
			<br>
			<div class='info'>
				Usrename: <input type="text" name="user">
			</div>
			<div class='info'>
				Password: <input type="password" name="pass">
			</div>
			<div>
				<button class="btn" type="submit" name="sign" value="Sign Up">Sign Up</button>
				<button class="btn" type="submit" name="sign" value="Sign In">Sign In</button>
			</div>
		</form>
	</div>
	<div class="warning"><?php echo $msg ?></div>
</body>

</html>