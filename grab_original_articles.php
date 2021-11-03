<?php
function grabOriginalArticleBody($articleID){
	$server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass = "myadminpass";
    $db = "PROJECT";
	$conn = new mysqli($server, $sqlUser, $sqlPass, $db);
    $myTable = "articles";
    $sqlStatement = "SELECT * FROM $myTable
					   WHERE Article_ID = '$articleID'";

    //Run the SQL statement, return false if error.
    $query_result = $conn->query($sqlStatement);
    if (!$query_result) {
        echo $sqlStatement;
        echo "<br>Sorry, there was an error returning that article.";
		return false;
    }
	else {
		while ($result = $query_result->fetch_assoc()) {
            return ($result["Body"]);
		}
	}
}
?>