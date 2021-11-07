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
	echo "Successfully indexed article title and body in Elasticsearch!<br>";
}

?>



