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


function grabSnopesTitle($articleID){
	require_once 'simple_html_dom.php';
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
            $snopesArticleURL = $result["Snopes_URL"];
		}
	}
	$html = file_get_html($snopesArticleURL);
	$html->find('title',0)->plaintext;
	$title = $html->find('title',0)->plaintext;
	$title = str_replace('\'', '', $title);
	return $title;
}

function grabSnopesBody($articleID){
require_once 'simple_html_dom.php';
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
            $snopesArticleURL = $result["Snopes_URL"];
		}
	}
	$html = file_get_html($snopesArticleURL);
	$html->find('body',0)->plaintext;
	$body = $html->find('div[class="single-body card card-body rich-text"]',0)->plaintext;
	$body = str_replace('\'', '', $body);
	return $body;
}

function grabKeywords($articleID){
	$server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass = "myadminpass";
    $db = "PROJECT";
	$conn = new mysqli($server, $sqlUser, $sqlPass, $db);
    $myTable = "keywords";
    $sqlStatement = "SELECT * FROM $myTable
					   WHERE Article_ID = '$articleID'";

    //Run the SQL statement, return false if error.
    $query_result = $conn->query($sqlStatement);
    if (!$query_result) {
        echo $sqlStatement;
        echo "<br>Sorry, there was an error returning the keywords.";
		return false;
    }
	else {
		$resultArrayOfKeywords = array();
		while ($result = $query_result->fetch_assoc()) {
            array_push($resultArrayOfKeywords, $result["Keyword"]);
		}
		return $resultArrayOfKeywords;
	}
}
?>