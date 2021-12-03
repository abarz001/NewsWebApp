<?php
//Connect to db
$server = "localhost";
$sqlUser = "myadmin";
$sqlPass = "myadminpass";
$db = "PROJECT";
$conn = new mysqli($server, $sqlUser, $sqlPass, $db);
$table = "articles";
$sqlStatement = "SELECT * FROM $table";

//Run the SQL statement, return false if error.
$query_result = $conn->query($sqlStatement);
if (!$query_result) {
    echo $sqlStatement;
    echo "<br>Query error.";
    die;
}
else {
    
    $result = array();
    $i = 0;
    while ($res = mysqli_fetch_assoc($query_result)){
        $result[$i]['title'] = $res['Title'];
        $i++;
    }
    header("Content-Type: JSON");
    echo json_encode($result, JSON_PRETTY_PRINT);
}
?>