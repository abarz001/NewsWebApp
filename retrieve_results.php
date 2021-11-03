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
	echo ": <a href=./searchresults.php?search=$searchTerm&article=";
	print_r($r['_id']);
	echo  '>';
	print_r($r['_source']['title']);
	echo '</a>';
	echo ': ';	
}
echo '<br><br>';

if (isset($_GET['article'])){
	echo 'You selected article number ' . $_GET['article'];
	require 'grab_original_articles.php';
		if (grabOriginalArticleBody($_GET['article'])){
			echo "<body>
				 <div class=\"splitpanel\"><form action=\"\" method=\"post\" name=\"frmProfile\" id=\"frmProfile\">
							<table width=\"650\" border=\"1\" align=\"center\" cellpadding=\"3\" cellspacing=\"3\">
							<th>";
							echo grabOriginalArticleBody($_GET['article']);
							echo "</th>
							<th>
							Panel 2
							</th>
					</table></form></div>
					</body>";
		}
}


?>

