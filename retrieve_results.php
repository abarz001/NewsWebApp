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
$searchTerm = str_replace(' ', '+', $searchTerm);
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
	echo 'You selected article # ' . $_GET['article'] . ".<br>"; 
	echo '<br><br>';
		echo "<div class=\"loadingmsg\" style=\"display: block;\">Please wait while the data loads.....</div>";
		if (grabOriginalArticleBody($_GET['article'])){
			echo "<body>
				 <div class=\"splitpanel\" style=\"display: none;\"><form action=\"\" method=\"post\" name=\"frmProfile\" id=\"frmProfile\">
							<table class=\"paneltable\">
							<th>";
							echo "<div class=\"overflow-auto\" style=\"white-space: pre-wrap;\">";
							echo "<h2>";
							echo grabOriginalArticleTitle($_GET['article']);
							echo "</h2>" . '<br><br>';
							echo grabOriginalArticleBody($_GET['article']);
							echo "</div></th>
							<th>
							
	<div class=\"overflow-auto\">
	
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
			$keywordstemp = grabKeywords($_GET['article']);
			$keywords = implode("+",$keywordstemp);
			$json_url = getSemanticURL($_GET['article'], $keywords);
			echo "TextRank Keywords: " . implode(",",$keywordstemp);
			echo "<br><br>";
			$json_file = file_get_contents($json_url);
			$data = json_decode($json_file,true);
			$paperCount = 1;
			if ($data['total'] > 0){
			for ($i = 0; $i < $data['total'] && $i < 10; $i++){
			$refuteTitle = $data['data'][$i]['title'];
			echo "<h4>- Refute Paper #$paperCount: </h4>" . $refuteTitle;
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
			
			echo "</p></div>
        </div>
        <div class=\"tab-pane fade\" id=\"tab2\">
            <p><div class=\"overflow-auto\" style=\"white-space: pre-wrap;\">";
			
		}
			echo "<h2>";
			echo grabSnopesTitle($_GET['article']);
			echo "</h2>";
			echo "<br><br>";
			echo grabSnopesBody($_GET['article']);
			echo "</p></div>
        </div>
        <div class=\"tab-pane fade\" id=\"tab3\">";
		require_once 'SurveyProcess.php';
		echo "<br>
		Article #  " . $_GET['article'];
		if (isset($_POST['ArticleTrueOrFalse']) 
			&& isset($_POST['PriorBelievesOnTopic'])
			&& isset($_POST['PriorBeliefsAlign'])
			&& isset($_POST['DidSystemChangeBelief'])
			&& isset($_POST['WillingnessToAdoptSystem'])){
				SubmitSurvey($_SESSION['email'], $_GET['article'], $_POST['ArticleTrueOrFalse'],
				$_POST['PriorBelievesOnTopic'], $_POST['PriorBeliefsAlign'],
				$_POST['DidSystemChangeBelief'], $_POST['WillingnessToAdoptSystem']);
			}
		if (CheckIfUserAlreadyAnsweredSurvey($_SESSION['email'], $_GET['article'])){
			echo 
			"<br>
			<form action=\"\">
			1. Was the article true or false based on SciPEP's recommendation?<br>
			<input type=\"radio\" name=\"ArticleTrueOrFalse\" value=\"True\" required> True<br>
			<input type=\"radio\" name=\"ArticleTrueOrFalse\" value=\"False\"> False<br>
			<input type=\"radio\" name=\"ArticleTrueOrFalse\" value=\"I do not know\"> I do not know<br>
	
			<br><br>
	
			2. Did you have any prior beliefs/opinions about this topic?<br>
			<input type=\"radio\" name=\"PriorBelievesOnTopic\" value=\"Yes\" required> Yes<br>
			<input type=\"radio\" name=\"PriorBelievesOnTopic\" value=\"No\"> No<br>
	
			<br><br>
			3. Did your prior beliefs/opinions on this topic align with our recommendation?<br>
			<input type=\"radio\" name=\"PriorBeliefsAlign\" value=\"Yes\" required> Yes<br>
			<input type=\"radio\" name=\"PriorBeliefsAlign\" value=\"No\"> No<br>
			<input type=\"radio\" name=\"PriorBeliefsAlign\" value=\"Not Applicable\"> Not Applicable<br>
	
			<br><br>
	
			4. If you held prior beliefs/opinions that did not align with the system’s
			recommendation, did the system change your beliefs/opinions on this topic?<br>
			<input type=\"radio\" name=\"DidSystemChangeBelief\" value=\"Yes\" required> Yes<br>
			<input type=\"radio\" name=\"DidSystemChangeBelief\" value=\"Somewhat\"> Somewhat<br>
			<input type=\"radio\" name=\"DidSystemChangeBelief\" value=\"No\"> No<br>
			<input type=\"radio\" name=\"DidSystemChangeBelief\" value=\"Not Applicable\"> Not Applicable<br>
	
	
			<br><br>
			5. What is your willingness to adopt the system for checking article credibility?<br>
			<input type=\"radio\" name=\"WillingnessToAdoptSystem\" value=\"Yes\" required> Definitely<br>
			<input type=\"radio\" name=\"WillingnessToAdoptSystem\" value=\"No\"> Probably<br>
			<input type=\"radio\" name=\"WillingnessToAdoptSystem\" value=\"Probably Not\"> Probably Not<br>
			<input type=\"radio\" name=\"WillingnessToAdoptSystem\" value=\"Definitely Not\"> Definitely Not<br>
			<br>
			<input type=\"submit\" value=\"Submit\">
			</form>";
		}
		else {
			echo '<br>Survey has been submitted for this article.';
		}
		echo "
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
	height: 700px;
	width: 770px;
	border-width: 0px;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: normal;
	background: linear-gradient(to right, #FAFAFA, #A4BFDE);
	overflow-y: scroll;
overflow-x: hidden;
}
.paneltable{
	 border-style: dashed;
	 border-width: 1px;
	 height: 700px;
	 overflow-y: scroll;
overflow-x: hidden;
margin-bottom: 150px;
}
</style>

<script>
$(document).ready(function() {
    $(".splitpanel").delay(0).fadeIn(500);
    $(".loadingmsg").delay(0).fadeOut(500);
});
</script>
