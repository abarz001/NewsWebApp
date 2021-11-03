<?php
session_start();
if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == true){
	if(isset($_GET['search'])){
		echo '<center><br><br><br><br>Search Query: ' . $_GET['search'] . '<br><br>';
		require 'retrieve_results.php';
		/* require 'grab_original_articles.php';
		if (grabOriginalArticleBody($_GET['search'])){
			echo "<body>
				 <div class=\"splitpanel\"><form action=\"\" method=\"post\" name=\"frmProfile\" id=\"frmProfile\">
							<table width=\"650\" border=\"1\" align=\"center\" cellpadding=\"3\" cellspacing=\"3\">
							<th>";
							echo grabOriginalArticleBody($_GET['search']);
							echo "</th>
							<th>
							Panel 2
							</th>
					</table></form></div>
					</body>";
		} */
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

