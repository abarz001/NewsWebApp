<?php
   require_once 'simple_html_dom.php';
   require 'insert_index.php';
   $snopesArray = explode("\r\n", $_POST['snopesList']);
   $count = 0;
   $fileCount = 1;
   foreach(explode("\r\n", $_POST['articlesList']) as $article) {
	$snopesArticle = $snopesArray[$count];
	$html = file_get_html($article);
	$url = $article;
	//echo $html->find('title',0)->plaintext . '<br><br>';
	$title = $html->find('title',0)->plaintext;
	$title = str_replace('\'', '', $title);
	echo "Original fake news article title: $title<br>";
	echo "Original fake news article URL : $article<br>";
	echo "Snopes fact check URL: $snopesArray[$count]<br>";
	//echo $html->find('body',0)->plaintext . '<br><br>';
	foreach($html->find('a') as $r){
	$r->innertext = '';
	}
	foreach($html->find('h1') as $r){
		$r->innertext = '';
	}
	foreach($html->find('h2') as $r){
		$r->innertext = '';
	}
	foreach($html->find('ul') as $r){
		$r->innertext = '';
	}
	foreach($html->find('li') as $r){
		$r->innertext = '';
	}
	foreach($html->find('img') as $r){
		$r->innertext = '';
	}
	foreach($html->find('div[class="lcds-datatable lcds-datatable--ckeditor inset-column"]') as $r){
		$r->innertext = '';
	}
	foreach($html->find('div[class="row lcds-footer__secondary"]') as $r){
		$r->innertext = '';
	}
	foreach($html->find('div[class="secondary-nav"]') as $r){
		$r->innertext = '';
	}
	foreach($html->find('div[class="footer-upper"]') as $r){
		$r->innertext = '';
	}
	foreach($html->find('div[class="site-footer"]') as $r){
		$r->innertext = '';
	}
	foreach($html->find('ad-search-sponsor') as $r){
		$r->innertext = '';
	}
 	foreach($html->find('img') as $r)
	{
		//echo $r = "$element->src";
		$r = '';
	}
	$html->load($html->save());
	$body = $html->find('body',0)->plaintext;
	$body = str_replace('\'', '', $body);

	
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
	InsertIndex($fileCount, $title, $body);
	$count++;
	$fileCount++;
	
	
	
	echo '<br>-----------------------------------------------------------------------------------<br>';
	}
	echo '<h1><br><br>Complete!<br></h1>';
?>