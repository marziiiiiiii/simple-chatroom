
<html>

<head>

	<title>SignIn</title>

</head>

<body>

	<?php



	if (isset($_COOKIE["signedin"]) && $_COOKIE["signedin"] == '1')
		header('Location: home.php');

	if (isset($_POST['user']) && isset($_POST['pass'])) {
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		$as = $_POST['as'];
		if (!empty($user) && !empty($pass)) {

			//check database
			$con = mysqli_connect("localhost", "root", "", "training");
			if (!$con) {
				die(mysqli_connect_errno());
			}


			if ($as == "Sign In as Teacher") {
				$result = mysqli_query($con, "SELECT user, pass FROM Teachers WHERE user = '" . $user . "' AND  pass = '" . $pass . "'");
			} else {
				$result = mysqli_query($con, "SELECT user, pass FROM Students WHERE user = '" . $user . "' AND  pass = '" . $pass . "'");
			}

			$check_user = null;
			$check_pass = null;

			while ($row = mysqli_fetch_array($result)) {
				$check_user = $row['user'];
				$check_pass = $row['pass'];

				echo "user pass is correct.";
			}

			if ($user == $check_user && $pass == $check_pass) {
				echo "Matches.";

				// echo date_sub ( $row['lastAccess'] , STR_TO_DATE('15/01/2017 10:10:15','%d/%m/%Y %H:%i:%s') );
				$lastAccess = $row['lastAccess'];

				if ($as == "Sign In as Teacher") {
					$sql = "UPDATE Teachers SET dailyAccess=0 WHERE DATE('" . $lastAccess . "') = DATE( DATE_SUB( NOW() , INTERVAL 1 DAY ) )";
					$sql = "UPDATE Teachers SET lastAccess=now() WHERE user='" . $user . "'";
				} else {
					$sql = "UPDATE Students SET dailyAccess=0 WHERE DATE('" . $lastAccess . "') = DATE( DATE_SUB( NOW() , INTERVAL 1 DAY ) )";
					$sql = "UPDATE Students SET lastAccess=now() WHERE user='" . $user . "'";
				}

				$con->query($sql);

				$expire = time() + 60 * 60 * 24 * 7;
				setcookie("user", $user); //, $expire);
				setcookie("as", $as); //, $expire);
				setcookie("signedin", "1"); //, $expire);

				header('Location: home.php');

				$con->close();
			} else {
				echo "No match found. Try again.";
			}
		} else {
			echo 'You must enter a username and password.';
		}
	}
	?>
	<div class='main'>
		<form action="signIn.php" method="POST">
			<br>
			<div class='info'>Usrename: <input type="text" name="user">
				<br>Password: <input type="password" name="pass">
			</div>
			<br><input type="submit" class="btn" name="as" value="Sign In as Teacher">
			<br><input type="submit" class="btn" name="as" value="Sign In as Student">
		</form>

	</div>

</body>

<style>
	.btn {
		background-color: #00D1BB;
		color: white;
		border: none;
		border-radius: 15px;
		padding: 13px;
		cursor: pointer;
		font-weight: bolder;
		font-size: 23px;
	}

	.btn:hover {
		background-color: #551A8B;
	}

	input {
		margin: 15px;
		font-size: 17px;
	}

	.info {
		color: #551A8B;
		font-size: 18px;
		font-weight: bold;
	}

	.main {

		display: flex;
		justify-content: space-around;
		align-items: center;
	}
</style>

</html>