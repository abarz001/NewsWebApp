<?php
if (!isset($_GET['key'])) {
    echo 'Unauthorized user. Incorrect API key.';
} else {
    $apiKeyQueued = htmlspecialchars($_GET['key']);
    if (isset($apiKeyQueued)) {
        //Check if API key exists
        $server = "localhost";
        $sqlUser = "myadmin";
        $sqlPass = "myadminpass";
        $db = "PROJECT";
        $conn = new mysqli($server, $sqlUser, $sqlPass, $db);
        $sqlStatement = "SELECT api_code FROM users WHERE api_code='$apiKeyQueued'";
        $query_result = $conn->query($sqlStatement);
        if ($query_result->num_rows > 0) {
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
            if ($results['hits']['total'] > 0) {
                $results = $results['hits']['hits'];
            }
            $i = 0;
            foreach ($results as $r) {
                if ($i < $articleLimit) {
                    $json_preliminary_result['Time'] = date('Y-m-d H:i:s');
                    $json_preliminary_result[$i]['Rank'] = $i + 1;
                    $json_preliminary_result[$i]['Article_ID'] = $r['_id'];
                    $json_preliminary_result[$i]['Article_Title'] = $r['_source']['title'];
                    $i++;
                }
            }
            echo json_encode($json_preliminary_result, JSON_PRETTY_PRINT);
        }
        else {
            echo 'Incorrect API query. Check key, query, and n (article limit).';
        }
    }
}
