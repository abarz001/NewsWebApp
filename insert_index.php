<?php
function InsertIndex($articleID, $title, $body){
	require 'vendor/autoload.php';
	$client = Elasticsearch\ClientBuilder::create()->build();

	$params = [
	  'index' => 'fake_articles',
	  'id'    => "$articleID",
	  'body'  => [
			'title' => "$title",
			'website_text' => "$body"
		]
	];
	$response = $client->index($params);
	echo "<h3>Indexed:</h3>";
	print_r($params);
	echo "<br><h3><Response:/h3>";
	print_r($response);
	echo "<br>";
}

?>



