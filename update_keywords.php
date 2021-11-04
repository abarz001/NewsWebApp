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
	
	$counter = 1;
	$server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass = "myadminpass";
    $db = "PROJECT";
	$counter = 1;
	foreach($keywordFiles as $file) {

		$file = fopen("$file", 'r');
		
		//Get the current file number
		$keyword_file_num = substr($keywordFiles[$counter-1],-6);
		$keyword_file_num = substr($keyword_file_num,0,2);
		if (strpos($keyword_file_num, '_') === 0){
			$keyword_file_num = substr($keyword_file_num,-1);
		}
		echo "<b><h1>TextRank keywords for fake news article $keyword_file_num </h1></b>";
		
		while ($keyword = fgets($file)){
			$keyword = preg_replace('/\s+/', '', $keyword);
			echo $keyword . ", ";
			$conn = new mysqli($server, $sqlUser, $sqlPass, $db);
    $myTable = "keywords";
    $sqlStatement = "INSERT INTO $myTable
	VALUES (NULL,'$keyword', '$keyword_file_num', '$counter')";

    //Run the SQL statement, return false if error.
    $query_result = $conn->query($sqlStatement);
    if (!$query_result) {
        echo $sqlStatement;
        echo "<br>Sorry, the keyword insert failed.";
		return false;
    }
		}
		fclose($file);
		$counter++;
		echo "<br><br>---------------------------------------------------------------------------------------------------------";
	}
	return true;
}

    
	
?>