<?php
session_start();
echo '<center><br><a href="index.php">Home Page</a><br>
<a href="logout.php">Logout</a></center><br><br>';
if (!isset($_SESSION['adminUser']) || !$_SESSION['adminUser']) {
        echo 'Unauthorized user. You must be an admin to access this page.';
        return false;
    }
    else {
//Check if a list has been pasted
if (isset($_POST['articlesList']) && strlen(trim($_POST['articlesList']))){
require 'parse_original_articles.php';
}
	}
?>


<html>

<head>
    <title>(Admin) Add (original) fake news articles to database</title>
</head>

<body>
    <div class="myform">
    <form action="" method="post" name="frmSnopes" id="frmSnopes">
        <table border="0" align="center" cellpadding="2" cellspacing="2">
            <tr>
                <td>Paste list of fake news articles, separated by new line.</td>
				<td>Paste list of Snopes fact-check articles, separated by new line.</td>
			</tr>
			<tr>
                <td><textarea rows="25" cols="75" name="articlesList" id="articlesList"></textarea></td>
		                 <td><textarea rows="25" cols="75" name="snopesList" id="snopesList"></textarea></td>
            </tr>
			<tr>
			<td><input name="btnAddSnopes" type="submit" id="btnAddSnopes" value="Add to database" class="buttons"></td>
			</tr>
        </table>
    </form>
    </div>
</body>

</html>