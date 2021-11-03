<?php
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
	
	$counter = 1;
	$server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass = "myadminpass";
    $db = "PROJECT";
	foreach($keywordFiles as $file) {
        echo "<b><h1>TextRank keywords for fake news article $counter </h1></b>";
		$file = fopen("$file", 'r');
		$keywordLocalCount = 1;
		while ($keyword = fgets($file)){
			echo $keyword;
			$conn = new mysqli($server, $sqlUser, $sqlPass, $db);
    $myTable = "keywords";
    $sqlStatement = "INSERT INTO $myTable
	VALUES (NULL,'$keyword', '$counter', '$keywordLocalCount')";

    //Run the SQL statement, return false if error.
    $query_result = $conn->query($sqlStatement);
    if (!$query_result) {
        echo $sqlStatement;
        echo "<br>Sorry, the keyword insert failed.";
		
    }
	$keywordLocalCount++;
		}
		fclose($file);
		$counter++;
		echo "<br><br>---------------------------------------------------------------------------------------------------------";
	}
	

    
	
?>