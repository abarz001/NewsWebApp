<?php
session_start();
if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == true){
	if(isset($_GET['search'])){
		echo '<center><br><br><br><br>Search Query: ' . $_GET['search'] . '<br><br>';
		require 'retrieve_results.php';
	}
	else {
		echo 'logged in, but no search word was detected.';
	}
}
else {
	echo 'Not logged in.';
}
?>

<head>
    <title>Search Engine Result Page</title>
        <style>
        .splitpanel {
            border-width: 0px;
            border-style: groove;
            margin: 0;
        }
    </style>
</head>

