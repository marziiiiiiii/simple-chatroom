<html>

<head>
	<link rel="stylesheet" href="signinsignup.css" />

	<title>SignUp/SignUp</title>

</head>

<body OnLoad="document.myform.user.focus();">

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

			$expire = time() + 60 * 60 * 24 * 7;

			if ($sign == "Sign Up") {
				$sql = "INSERT INTO users (user, pass, picture) 
					VALUES ('" . $user . "', '" . $pass . "',NULL)";

				if (mysqli_query($con, $sql)) {

					setcookie("user", $user, $expire);
					setcookie("signedin", "1", $expire);
					header('Location: chat.php');
				} else {
					// echo "Error: " . $sql . "<br>" . mysqli_error($con);
					$msg = "Username is already taken. Try again.";
				}
			} else {
				$result = mysqli_query($con, "SELECT user, pass FROM users WHERE user = '" . $user . "' AND  pass = '" . $pass . "'");

				$check_user = null;
				$check_pass = null;

				while ($row = mysqli_fetch_array($result)) {
					$check_user = $row['user'];
					$check_pass = $row['pass'];

					// echo "user pass is correct.";
				}

				if ($user == $check_user && $pass == $check_pass) {
					// echo "Matches.";
					setcookie("user", $user, $expire);
					setcookie("dest", "   " , $expire);
					setcookie("signedin", "1", $expire);
					header('Location: chat.php');
				} else {
					$msg = "No match found. Try again.";
				}
			}



			$con->close();
		} else {
			$msg = "*You must enter a username and password.";
		}
	}
	?>
	<div class='welcome'>SMSM messenger</div>
	<!-- <img  src="./resourses/paper3.gif" alt=""> -->
	<div class='main'>
		<form name="myform" action="signinsignup.php" method="POST">
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