<?php
	session_start();
	if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == true)
	{
        echo 'Welcome ', $_SESSION['email'] , '.<br><br>';
        if (isset($_SESSION['ApprovedByAdmin']) && $_SESSION['ApprovedByAdmin'])
        {
            echo 'Your account has been approved by an admin so you have full access to the site!';
        }
        else 
        {
            echo 'Your account is currently pending approval by an admin. Please check back later to see if your account has been approved by an admin.';
            exit;
        }
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
</html>