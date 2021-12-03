<?php
header("Content-Type: JSON");
require 'vendor/autoload.php';
$searchTerm = htmlspecialchars($_GET['query']);
$articleLimit = htmlspecialchars($_GET['n']);
$client = Elasticsearch\ClientBuilder::create()->build();

$params = [
    'index' => 'fake_articles',
    'body'  => [
        'query' => [
            'fuzzy' => ['title' => $searchTerm]
		]
    ]
];

$results = $client->search($params);
$json_preliminary_result = array();
if ($results['hits']['total'] > 0){
	$results = $results['hits']['hits'];
}
$i = 0;
foreach($results as $r){
    if ($i < $articleLimit){
        $json_preliminary_result['Time'] = date('Y-m-d H:i:s');
        $json_preliminary_result[$i]['Rank'] = $i+1;
        $json_preliminary_result[$i]['Article_ID'] = $r['_id'];
        $json_preliminary_result[$i]['Article_Title'] = $r['_source']['title'];
        $i++;
    }
}
echo json_encode($json_preliminary_result, JSON_PRETTY_PRINT);
?>