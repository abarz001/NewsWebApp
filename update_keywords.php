<?php
function insertKeywords()
{
	//Get all the files in the keywords directory
	$keywordFiles = array();
	$directory = opendir('./files/keywords/');
		while(false != ($file = readdir($directory))) 
	{
        if(($file != ".") and ($file != "..") and ($file != "index.php")) 
		{
                $keywordFiles[] = "./files/keywords/$file";
        }   
	}
	natsort($keywordFiles);
	
	$server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass = "myadminpass";
    $db = "PROJECT";
	$counter = 1;
	foreach($keywordFiles as $file) {

		$file = fopen("$file", 'r');
		
		echo "<b><h1>TextRank keywords for fake news article $counter </h1></b>";
		$keywordRank = 1;
		while ($keyword = fgets($file)){
			$keyword = preg_replace('/\s+/', '', $keyword);
			echo $keyword . ", ";
			$conn = new mysqli($server, $sqlUser, $sqlPass, $db);
    $myTable = "keywords";
    $sqlStatement = "INSERT INTO $myTable
	VALUES (NULL,'$keyword', '$counter', '$keywordRank')";

    //Run the SQL statement, return false if error.
    $query_result = $conn->query($sqlStatement);
    if (!$query_result) {
        echo $sqlStatement;
        echo "<br>Sorry, the keyword insert failed.";
		return false;
    }
	$keywordRank++;
		}
		fclose($file);
		$counter++;
		echo "<br><br>---------------------------------------------------------------------------------------------------------";
	}
	return true;
}

    
	
?>