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
    echo '<br>';
	echo "Article #"; //debugging
	print_r($r['_id']);
	echo ": <a href=?search=$searchTerm&article=";
	print_r($r['_id']);
	echo  '>';
	print_r($r['_source']['title']);
	echo '</a>';
	echo ': ';	
}
echo '<br><br>';

if (isset($_GET['article'])){
	require 'grab_original_articles.php';
	echo 'You selected article number ' . $_GET['article'] . "<br>This has TextRank keywords: "; 
	foreach(grabKeywords($_GET['article']) as $keyword){
			echo $keyword;
	}
	echo '<br><br>';
		if (grabOriginalArticleBody($_GET['article'])){
			echo "<link href=\"./css/bootstrap.min.css\" rel=\"stylesheet\">
<script src=\"./js/jquery-3.6.0.min.js\"></script>
<script src=\"./js/bootstrap.bundle.min.js\"></script>
<script src=\"./js/load_tabs.js\"></script>";
			echo "<body>
				 <div class=\"splitpanel\"><form action=\"\" method=\"post\" name=\"frmProfile\" id=\"frmProfile\">
							<table width=\"1500\" border=\"1\" align=\"center\" cellpadding=\"3\" cellspacing=\"3\">
							<th>";
							echo "<div class=\"overflow-auto\">";
							echo grabOriginalArticleBody($_GET['article']);
							echo "</div></th>
							<th>
							
	<div class=\"rightPanel\">
    <ul class=\"nav nav-pills\" id=\"tabList\">
        <li class=\"nav-item\">
            <a href=\"#tab1\" class=\"nav-link active\">Semantic Search Articles</a>
        </li>
        <li class=\"nav-item\">
            <a href=\"#tab2\" class=\"nav-link\">Snopes Fact-Check</a>
        </li>
        <li class=\"nav-item\">
            <a href=\"#tab3\" class=\"nav-link\">Survey</a>
        </li>
    </ul>
    <div class=\"tab-content\">
        <div class=\"tab-pane fade show active\" id=\"tab1\">
            <p>Tab 1 content</p>
        </div>
        <div class=\"tab-pane fade\" id=\"tab2\">
            <p>Tab 2 content</p>
        </div>
        <div class=\"tab-pane fade\" id=\"tab3\">
            <p>Tab 3 content</p>
        </div>
    </div>
</div>
							</th>
					</table></form></div>
					</body>";
		}
}


?>

<style>
.overflow-auto{
	max-height: 500px;
	max-width: 800px;
}
.rightPanel{
	max-height: 500px;
	max-width: 600px;
}

</style>
