<?php
require 'vendor/autoload.php';
$client = Elasticsearch\ClientBuilder::create()->build();
$params = [
  'index' => 'fake_articles',
];
$response = $client->indices()->delete($params);
print_r($response);
?>
