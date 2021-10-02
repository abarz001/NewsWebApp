<?php

	//include database information and user information
	require 'authenticate.php';

	session_start();
	$errorMessage = '';

	//are user ID and Password provided?
	if (isset($_POST['email']) && isset($_POST['pass'])) 
	{

		$email = $_POST['email'];
		$loginPassword = $_POST['pass'];
		
		//connect to db
        $connection = new mysqli($server, $sqlUser, $sqlPassword, $db);
		
		// Authenticate user
		if (authenticate($connection, $email, $pass))
		{
			//the user id and password match,
			// set the session	
			$_SESSION['userLoggedIn'] = true;
			$_SESSION['email'] = $email;
			
			// after login we move to the home page
			header('Location: index.php');
			exit;
		} else 
		{
			$errorMessage = 'Sorry, wrong email address and/or password.';
		}
	}
?>

<html>
	<head>
		<title>User Login</title>
	</head>

	<body>
		<Strong> <?php echo $errorMessage ?> </Strong>
		If you don't have an account, please <a href="signup.php">sign up</a>.
		<form action="" method="post" name="frmLogin" id="frmLogin">
			 <table width="400" border="1" align="center" cellpadding="2" cellspacing="2">
				  <tr>
					<td width="150">Email Address</td>
					<td><input name="email" type="text" id="email"></td>
				  </tr>
				  <tr>
					<td width="150">Password</td>
					<td><input name="pass" type="password" id="pass"></td>
				  </tr>
				  <tr>
					<td width="150">&nbsp;</td>
					<td><input name="btnLogin" type="submit" id="btnLogin" value="Login"></td>
				  </tr>
			 </table>
		</form>
	</body>
</html>