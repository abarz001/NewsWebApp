<?php
function getSemanticURL($articleID, $keyword){
	$semanticQuery = "https://api.semanticscholar.org/graph/v1/paper/search?query=" . 
					 "$keyword&limit=10&fields=title,authors,abstract,year,citationCount";
					 
	return $semanticQuery;
}

?>