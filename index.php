<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="login-box">
		<h2 class="login-heading">Login Here</h2>
		<form class="login-form" method="post" action="login.php">
			<p>Username:</p>
			<input type="text" name="username" placeholder="Enter Username" class="login-input">
			<p>Password:</p>
			<input type="password" name="password" placeholder="Enter Password" class="login-input">
			<input type="submit" name="submit" value="Login" class="login-button">
		</form>
		
		<h2 class="signup-heading">Sign Up Here</h2>
		<form class="signup-form" method="post" action="signup.php">
			<p>Username:</p>
			<input type="text" name="username" placeholder="Enter Username" class="signup-input">
			<p>First Name:</p>
			<input type="text" name="firstname" placeholder="Enter First Name" class="signup-input">
			<p>Last Name:</p>
			<input type="text" name="lastname" placeholder="Enter Last Name" class="signup-input">
			<p>Email:</p>
			<input type="email" name="email" placeholder="Enter Email" class="signup-input">
			<p>Telephone:</p>
			<input type="tel" name="telephone" placeholder="Enter Telephone" class="signup-input">
			<p>Password:</p>
			<input type="password" name="password" placeholder="Enter Password" class="signup-input">
			<p>Are you an Admin? <br> Enter Admin Pass.</p>
			<input type="password" name="isadmin" class="signup-input">
			<input type="submit" name="submit" value="Sign Up" class="signup-button">
		</form>
	</div>
</body>
</html>
