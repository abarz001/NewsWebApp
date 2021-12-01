<?php
function CheckIfUserAlreadyAnsweredSurvey($userEmail, $articleID){
    $server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass = "myadminpass";
    $db = "PROJECT";
	$conn = new mysqli($server, $sqlUser, $sqlPass, $db);
    $sqlStatement = "SELECT * FROM survey WHERE UserEmail = '$userEmail' AND Article_ID = '$articleID'";
    $query_result = $conn->query($sqlStatement);
    if (!$query_result) {
        echo 'There was an error checking if the survey has been answered already. Please contact an admin.<br>';
        return true;
    }
	else {
        $numrows = $query_result->num_rows;
        if ($numrows == 0){
            return true;
        }
        else if ($numrows == 1)
        {
            return false;
        }
        else {
            echo 'There was an error checking if the survey has been answered already. Multiple rows found. Please contact an admin.<br>';
            return false;
        }
	}
}


function SubmitSurvey($userEmail, $articleID,  $ArticleTrueOrFalse, $PriorBeliefsOnTopics, $PriorBeliefsAlign, 
$DidSystemChangeBelief, $WillingnessToAdoptSystem){
    $server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass = "myadminpass";
    $db = "PROJECT";
	$conn = new mysqli($server, $sqlUser, $sqlPass, $db);
    $sqlStatement = "SELECT * FROM survey WHERE UserEmail = '$userEmail' AND Article_ID = '$articleID'";
    $query_result = $conn->query($sqlStatement);
    $numrows = $query_result->num_rows;
        if ($numrows == 0){
            //Do the insert if no answer already exists
            $insertStatement = "INSERT INTO survey VALUES ('$userEmail', '$articleID','$ArticleTrueOrFalse',
            '$PriorBeliefsOnTopics', '$PriorBeliefsAlign', '$DidSystemChangeBelief', '$WillingnessToAdoptSystem')";
            $query_result = $conn->query($insertStatement)
            or die("SQL Query ERROR. Contact an admin. There was an error inserting survey results." . $insertStatement . $conn->connect_error);
        }
        else {
            echo 'Survey has been submitted for this article.';
        }
}
?>