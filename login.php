<!DOCTYPE html>

<?php
	session_start(); // Starting Session
?>
<html>

<head>
	<title>My Dairy Farm | Login</title>
	<link rel="icon" type="image/x-icon" href="pinkcow.png">

	<style>
		@import url('https://fonts.googleapis.com/css?family=Abel|Abril+Fatface|Alegreya|Arima+Madurai|Dancing+Script|Dosis|Merriweather|Oleo+Script|Overlock|PT+Serif|Pacifico|Playball|Playfair+Display|Share|Unica+One|Vibur');

		* {
			padding: 0;
			margin: 0;
			box-sizing: border-box;
		}

		body {
			background-attachment: fixed;
			background-repeat: no-repeat;

			font-family: 'Vibur', cursive;
			/*   the main font */
			font-family: 'Abel', sans-serif;
			opacity: .95;
			background-image: linear-gradient(to top, #d9afd9 0%, #97d9e1 100%);
		}

		form {
			width: 450px;
			height: auto;
			border-radius: 99px;
			margin: 2% auto;
			box-shadow: 0 9px 50px hsla(20, 67%, 75%, 0.31);
			padding: 2%;
			background-image: linear-gradient(-225deg, #E3FDF5 50%, #FFE6FA 50%);
		}

		form .con {
			display: -webkit-flex;
			display: flex;
			-webkit-justify-content: space-around;
			justify-content: space-around;
			-webkit-flex-wrap: wrap;
			flex-wrap: wrap;
			margin: 0 auto;
		}

		header {
			margin: 2% auto 10% auto;
			text-align: center;
		}

		header h2 {
			font-size: 250%;
			font-family: 'Playfair Display', serif;
			color: #3e403f;
		}

		header p {
			letter-spacing: 0.05em;
		}

		.input-item {
			background: #fff;
			color: #333;
			padding: 14.5px 0px 15px 9px;
			border-radius: 5px 0px 0px 5px;
		}

		input[class="form-input"] {
			width: 270px;
			height: 50px;
			margin-top: 2%;
			padding: 15px;
			font-size: 16px;
			font-family: 'Abel', sans-serif;
			color: #5E6472;
			outline: none;
			border: none;
			border-radius: 0px 5px 5px 0px;
			transition: 0.2s linear;
		}

		input:focus {
			transform: translateX(-2px);
			border-radius: 5px;
		}

		button {
			display: inline-block;
			color: #252537;
			width: 280px;
			height: 50px;
			padding: 0 20px;
			background: #fff;
			border-radius: 5px;
			outline: none;
			border: none;
			cursor: pointer;
			text-align: center;
			transition: all 0.2s linear;
			margin: 7% auto;
			letter-spacing: 0.05em;
		}

		.submits {
			width: 48%;
			display: inline-block;
			float: left;
			margin-left: 2%;
		}

		button:hover {
			transform: translatey(3px);
			box-shadow: none;
		}

		button:hover {
			animation: ani9 0.4s ease-in-out infinite alternate;
		}

		@keyframes ani9 {
			0% {
				transform: translateY(3px);
			}

			100% {
				transform: translateY(5px);
			}
		}

		footer {
			text-align: center;
			padding-bottom: 20px;
		}

		h1{
			padding-top: 2rem;
			font-size: 2.5rem;
		}
	</style>
</head>

<body>

	<?php
	require('conn.php');

	$error = "";
	$username = "";
	if (isset($_REQUEST["submit"])) {

		$username = $_REQUEST["username"];
		$password = $_REQUEST["password"];

		$sql = "SELECT * FROM admin where username='$username' and password='$password'";

		$result = mysqli_query($conn, $sql);

		$recordsFound = mysqli_num_rows($result);

		if ($recordsFound > 0) {
			$row = mysqli_fetch_assoc($result);
			$_SESSION['user'] = $username;
			$_SESSION["userid"] = $row["username"];
			header('Location: dashboard.php');
		} else {
			$_SESSION["user"] = null;
			$error = "Invalid credentials !";
		}

	}

	?>

	<center>
		<h1>Welcome to My Dairy Farm</1>
	</center>

	<div class="overlay">
		<form action="login.php" method="POST">
			<div class="con">
				<header class="head-form">
					<h2>Login</h2>
					<p>login here using your username and password</p>
				</header>
				<br>
				<div class="field-set">

					<span class="input-item">
						<i class="fa fa-user-circle"></i>
					</span>
					<input class="form-input" id="txt-input" type="text" name="username" placeholder="UserName"
						required>
					<br>

					<span class="input-item">
						<i class="fa fa-key"></i>
					</span>
					<input class="form-input" type="password" placeholder="Password" id="pwd" name="password" required>
					<br>
					<button class="log-in" name="submit"> Login </button>
					<br>
					<span
						style='color:red;display:flex;justify-content:center;font-weight:bold;letter-spacing: 0.05rem;'>
						<?php echo $error; ?>
					</span>

				</div>

			</div>

		</form>
	</div>

	<footer>
		&copy; Copyrights 2023. All rights reserved | <a href="login.php">My Dairy Farm</a>
	</footer>

	<script src="jquery.js"></script>
</body>

</html>