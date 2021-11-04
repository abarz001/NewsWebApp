<?php
require 'vendor/autoload.php';
echo "<link href=\"./css/bootstrap.min.css\" rel=\"stylesheet\">
<script src=\"./js/jquery-3.6.0.min.js\"></script>
<script src=\"./js/bootstrap.bundle.min.js\"></script>
<script src=\"./js/load_tabs.js\"></script>";
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
	echo "Article #";
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
			echo $keyword . ", ";
	}
	echo '<br><br>';
		echo "<div class=\"loadingmsg\" style=\"display: block;\">Please wait while the data loads.....</div>";
		if (grabOriginalArticleBody($_GET['article'])){
			echo "<body>
				 <div class=\"splitpanel\" style=\"display: none;\"><form action=\"\" method=\"post\" name=\"frmProfile\" id=\"frmProfile\">
							<table class=\"paneltable\">
							<th>";
							echo "<div class=\"overflow-auto\" style=\"white-space: pre-wrap;\">";
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
            <p><div class=\"overflow-auto\">";
			require 'insert_semantic_search.php';
			$resultArray = grabKeywords($_GET['article']);
			foreach($resultArray as $keywords){
			$json_url = getSemanticURL($_GET['article'], $keywords);
			echo "Keyword: $keywords";
			echo "<br><br>";
			$json_file = file_get_contents($json_url);
			$data = json_decode($json_file,true);
			$paperCount = 1;
			if ($data['total'] > 0){
			for ($i = 0; $i < 10; $i++){
			$refuteTitle = $data['data'][$i]['title'];
			echo "- Refute Paper #$paperCount: " . $refuteTitle;
			echo "<br><button class=\"btn btn-primary\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#details$paperCount\" aria-expanded=\"false\" aria-controls=\"details$paperCount\">
			Show/hide details
			</button>
			<br><div class=\"collapse\" id=\"details$paperCount\">";
			echo "<br>Authors: ";
			$refuteAuthors = array();
			foreach($data['data'][$i]['authors'] as $author){
				echo $author['name'] . "; ";
				array_push($refuteAuthors, $author['name']);
			}
			$refuteAbstract = $data['data'][$i]['abstract'];
			$refuteDate = $data['data'][$i]['year'];
			$refuteCitations = $data['data'][$i]['citationCount'];
			echo "<br><br>Year Published: " . $refuteDate;
			echo "<br><br>Citation Count: " . $refuteCitations;
			echo "<br><br>Abstract: " . $refuteAbstract . "</div>";
			$paperCount++;
			echo "<br><br>";
			//Insert into refute_paper table if not already in there
			require_once 'update_refute_papers.php';
			insertScholarArticles($keywords, $refuteTitle, $refuteAuthors, $refuteAbstract, $refuteDate, $refuteCitations, $json_url, $_GET['article']);
			} //end for loop
			
			echo "<br><br>----------------------------------------------<br>";
			}
			else {
				echo 'No refute papers found for this keyword.';
				echo "<br><br>----------------------------------------------<br>";
			}
			}
			echo "</p></div>
        </div>
        <div class=\"tab-pane fade\" id=\"tab2\">
            <p><div class=\"overflow-auto\" style=\"white-space: pre-wrap;\">";
			
		}
			echo grabSnopesTitle($_GET['article']);
			echo grabSnopesBody($_GET['article']);
			echo "</p></div>
        </div>
        <div class=\"tab-pane fade\" id=\"tab3\">
            <p>Coming soon</p>
        </div>
    </div>
</div>
							</th>
					</table></form></div>
					</body>";
		
}


?>

<style>
.overflow-auto{
	max-height: 800px;
	max-width: 700px;
}
.rightPanel{
	max-height: 850px;
	max-width: 700px;
}
.paneltable{
	 border-style: dotted;
	 height: 850px;
}
</style>

<script>
$(document).ready(function() {
    $(".splitpanel").delay(0).fadeIn(500);
    $(".loadingmsg").delay(0).fadeOut(500);
});
</script>
