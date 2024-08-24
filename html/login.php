<?php
session_start();
if (isset($_SESSION['user'])) {
	header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/login-registration.css">
	
</head>
<body>
	<header>
		
	</header>
	<div class="container">
		<?php
			if (isset($_POST["submit"])) {
				$email = $_POST["email"];
				$password = $_POST['password'];
				require_once "database.php";

				$sql = "SELECT * FROM admins WHERE email = '$email'";
				$result = mysqli_query($conn, $sql);
				$user = mysqli_fetch_array($result, MYSQLI_ASSOC);
				if ($user) {
					if (password_verify($password, $user["Password"])) {
						header("Location: index.php");
						session_start();
						$_SESSION['user']="yes";

						die();
					}
					else{
						echo "<div class = 'alert alert-danger'>Password does not match</div>";
					}
				}
				else{
					echo "<div class = 'alert alert-danger'>Email does not match</div>";
				}
			}
		?>
		<form action="login.php" method="post">
		<h1 id="formH1">Log in</h1>
			<div class="form-group">
				<input type="email" class="form-control" name="email" placeholder="Enter Email:">
			</div>

			<div class="form-group">
				<input type="password" class="form-control" name="password" placeholder="Enter Password:">
			</div>

			<div class="form-btn">
				<input type="submit" class="btn btn-primary" name="submit" value="Login">
			</div>

		</form>
		<div><p id="regText">Not registered yet<a href="registration2.php"> Register Here</a></p></div>
	</div>
</body>
</html>