<?php
if (!isset($_SESSION['adminUser']) || !$_SESSION['adminUser']) {
        echo 'Unauthorized user. You must be an admin to access this page.';
        return false;
    }
    else {
require 'insert_semantic_search.php';
require 'update_refute_papers.php';
require 'grab_original_articles.php';

	$server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass = "myadminpass";
    $db = "PROJECT";
	$conn = new mysqli($server, $sqlUser, $sqlPass, $db);
    $sqlStatement = "SELECT MAX(Article_ID) FROM articles";
    $query_result = $conn->query($sqlStatement);
    if (!$query_result) {
        echo $sqlStatement;
        echo "<br>Sorry, there was an error returning the max number of articles.";
    }
	else {
		$numArticles = $query_result->fetch_row();
	}

//Get all of the keywords for each 
for ($x = 1; $x <= 10; $x++){
			$keywordstemp = grabKeywords($x);
			$keywords = implode("+",$keywordstemp);
			$json_url = getSemanticURL($x, $keywords);
			//echo "TextRank Keywords: " . implode(",",$keywordstemp);
			//echo "<br><br>";
			$json_file = file_get_contents($json_url);
			$data = json_decode($json_file,true);
			$paperCount = 1;
			if ($data['total'] > 0){
			for ($i = 0; $i < $data['total'] && $i < 10; $i++){
			$refuteTitle = $data['data'][$i]['title'];
			//echo "<h4>- Refute Paper #$paperCount: </h4>" . $refuteTitle;
			//echo "<br><button class=\"btn btn-primary\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#details$paperCount\" aria-expanded=\"false\" aria-controls=\"details$paperCount\">
			//Show/hide details
			//</button>
			//<br><div class=\"collapse\" id=\"details$paperCount\">";
			//echo "<br>Authors: ";
			$refuteAuthors = array();
			foreach($data['data'][$i]['authors'] as $author){
				//echo $author['name'] . "; ";
				array_push($refuteAuthors, $author['name']);
			}
			$refuteAbstract = $data['data'][$i]['abstract'];
			$refuteDate = $data['data'][$i]['year'];
			$refuteCitations = $data['data'][$i]['citationCount'];
			//echo "<br><br>Year Published: " . $refuteDate;
			//echo "<br><br>Citation Count: " . $refuteCitations;
			//echo "<br><br>Abstract: " . $refuteAbstract . "</div>";
			$paperCount++;
			//echo "<br><br>";
			//Insert into refute_paper table if not already in there
			insertScholarArticles($keywords, $refuteTitle, $refuteAuthors, $refuteAbstract, $refuteDate, $refuteCitations, $json_url, $x);
				}
			}
}
echo 'Success!';
	}
	
?>