<?php
	session_start();
	if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == true)
	{
		echo 'Welcome ', $_SESSION['email'];
	}
	else
	{
		header('Location: login.php');
		exit;
	}
?>

<html>
	<head>
		<title>Fake News Analyzer Home Page</title>
	</head>
	
	<body>
		<p>Search box will be here</p>
	</body>
</html>