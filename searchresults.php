<?php
session_start();
require_once('favicon.php');
if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == true) {
	if (isset($_GET['search'])) {
		echo "
		<body><br><br><br><center>
    <form action=\"searchresults.php\" method=\"get\" name=\"frmSearch\" id=\"frmSearch\">
<a href=\"index.php\"><input name=\"home\" type=\"button\" value=\"Home\" class=\"buttons\"></a>
		<a href=\"profile.php\"><input name=\"userprofile\" type=\"button\" value=\"View/Update Profile Information\" class=\"buttons\"></a>
		<a href=\"create_api_key.php\"><input name=\"apikey\" type=\"button\" value=\"View/Update API Key\" class=\"buttons\"></a>
        <a href=\"logout.php\"><input name=\"logoutbtn\" type=\"button\" value=\"Logout\" class=\"buttons\"></a>
		<br><br><input type=\"search\" id=\"searchText\" name=\"search\" placeholder=\"Search for an article\" style=\"width: 400px\";>
            <input type=\"submit\" value=\"Search\">
			<input name=\"speech2text\" type=\"button\" value=\"Voice Search\" class=\"buttons\" onclick=\"startDictation(event)\">
    </form>
    </center>
</body>";

		echo '
		<center><br><br>Search Query: ' . htmlspecialchars($_GET['search']) . '<br><br>';
		require 'retrieve_results.php';
		echo '</center>';
	} else {
		echo 'logged in, but no search word was detected.';
	}
} else {
	header('Location: login.php');
}
?>

<script src="./js/speech2text.js"></script>

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

<?php require_once('footer.php'); ?>