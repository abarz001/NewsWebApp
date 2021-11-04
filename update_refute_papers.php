<?php
function insertScholarArticles($keywords, $refuteTitle, $refuteAuthors, $refuteAbstract, $refuteDate, $refuteCitations, $refuteURL, $articleID)
{
	$server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass = "myadminpass";
    $db = "PROJECT";

	$conn = new mysqli($server, $sqlUser, $sqlPass, $db);
    $myTable = "refute_papers";
	$refuteTitle = str_replace('\'', '', $refuteTitle);
	$refuteAbstract = str_replace('\'', '', $refuteAbstract);
	$checkUserStatement = "SELECT * FROM $myTable WHERE Refute_Title = '$refuteTitle'";
	$check_if_exists = $conn->query($checkUserStatement)
            or die("There was an error checking if the refute paper already exists." . $checkUserStatement . $conn->connect_error);
    if ($check_if_exists->num_rows == 0)
	{
		$refuteAuthors = implode(", ",$refuteAuthors);
		$sqlStatement = "INSERT INTO $myTable
		VALUES ('$keywords', NULL, '$refuteTitle', '$refuteAuthors', '$refuteAbstract',
		'$refuteDate', '$refuteCitations', '$refuteURL', '$articleID')";

		//Run the SQL statement, return false if error.
		$query_result = $conn->query($sqlStatement);
		if (!$query_result) {
			return false;
		}
		else {
			return true;
		}
	}
}

    
	
?>