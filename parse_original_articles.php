<?php
   require_once 'simple_html_dom.php';
   
   $snopesArray = explode("\r\n", $_POST['snopesList']);
   $count = 0;
   $fileCount = 1;
   foreach(explode("\r\n", $_POST['articlesList']) as $article) {
	echo "Snopes fact check URL: $snopesArray[$count]";
	$snopesArticle = $snopesArray[$count];
    echo "Original fake news article: $article<br>";
	$html = file_get_html($article);
	$url = $article;
	echo $html->find('title',0)->plaintext . '<br><br>';
	$title = $html->find('title',0)->plaintext;
	$title = str_replace('\'', '', $title);
	echo $html->find('body',0)->plaintext . '<br><br>';
	$body = $html->find('body',0)->plaintext;
	$body = str_replace('\'', '', $body);
/* 	foreach($html->find('img') as $element)
	{
		echo $imgURL = "$element->src";
		echo '<br>';
	} */
	
	//Save the body for TextRank analysis
	file_put_contents('./files/fake_news_' . $fileCount . '.txt', $body);
	
	//Do the insert into the articles table
	$server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass = "myadminpass";
	$db = "PROJECT";
	$conn = new mysqli($server, $sqlUser, $sqlPass, $db);
    $articlesTable = "articles";
	$insertStatement = "INSERT INTO $articlesTable (Title, URL, Body, Snopes_URL)
						VALUES ('$title', '$url', '$body', '$snopesArticle')";
	$query_result = $conn->query($insertStatement)
                or die("SQL Query ERROR. There was an error inserting into the articles database:" . $insertStatement . $conn->connect_error);
				
	//Call elasticsearch indexing
	require 'insert_index.php';
	InsertIndex($fileCount, $title, $body);
	$count++;
	$fileCount++;
	
	
	
	echo '<br>-----------------------------------------------------------------------------------<br>';
	}
?>