<?php
require 'vendor/autoload.php';
$searchTerm = $_GET['search'];
$client = Elasticsearch\ClientBuilder::create()->build();

$params = [
    'index' => 'fake_articles',
    'body'  => [
        'query' => [
            'match' => ['title' => $searchTerm],
			'match' => ['website_text' => $searchTerm ]
        ]
    ]
];

$results = $client->search($params);
//echo '<pre>', print_r($results), '<pre>';

if ($results['hits']['total'] > 0){
	$results = $results['hits']['hits'];
}

echo 'Total number of results: ' . count($results) . '<br><br>';
foreach($results as $r){
	echo '<pre>';
	echo "Article #"; //debugging
	print_r($r['_id']);
	echo ': <a href=#';
	print_r($r['_id']);
	echo  '">';
	print_r($r['_source']['title']);
	echo '</a>';
	echo ': ';	
	
	echo '<pre>';
}

?>

