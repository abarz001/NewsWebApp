<?php
//This will be where Approved_By_Admin = 0 AND Rejected = 0;
$server = "localhost";
$sqlUser = "myadmin";
$sqlPass = "myadminpass";
$db = "PROJECT";
$conn = new mysqli($server, $sqlUser, $sqlPass, $db);
$userTable = "USERS";
$sqlStatement = "SELECT Email, Registration_Date FROM $userTable
                     WHERE Approved_By_Admin = 0
                     AND Rejected = 0
                    ORDER BY Registration_Date";

//Run the SQL statement, return false if error.
$query_result = $conn->query($sqlStatement);
if (!$query_result) {
    echo $sqlStatement;
} else {
    echo '<form action="" method="post" name="frmProfile" id="frmProfile">
        <table width="400" border="1" align="center" cellpadding="3" cellspacing="3">';
    if ($query_result->num_rows > 0) {
        $columnNamesPrinted = 0;
        $rowNumber = 0;
        $emailArray = array();
        while ($result = $query_result->fetch_assoc()) {
            echo '<tr>';
            if (!$columnNamesPrinted) {
                echo "<th>Select</th>";
                foreach ($result as $key => $value) {
                    if (!$columnNamesPrinted) {
                        echo "<th>$key</th>";
                    }
                }
                $columnNamesPrinted = 1;
            }
            echo "</tr>";
            echo "<tr>";
            echo "<th><input type=\"checkbox\" id=\"user$rowNumber\" name=\"user$rowNumber\" value></th>";
            foreach ($result as  $value) {
                echo ("<td id=\"user$rowNumber\">$value</td>");
                if(filter_var($value, FILTER_VALIDATE_EMAIL)){
                    array_push($emailArray, $value);
                };
            }
            echo "</tr>";
            $rowNumber++;
        }
        echo '<td colspan=5><center><input name="btnApprove" type="submit" id="btnApprove" value="Approve Selected Users">
                        </center></td>';

        echo '<tr><td colspan=5><center><input name="btnReject" type="submit" id="btnReject" value="Reject Select Users">
                        </center></td></tr>';
    echo '</table></form>';
    }
    else {
        echo '<center><br><br>There are no users to approve or reject at this time.</center>';
    }
    
    if (isset($_POST['btnApprove'])){
        $approveOrReject = 1;
    }
    else if (isset($_POST['btnReject'])){
        $approveOrReject = 0;
    }
   if (isset($approveOrReject)){
       require 'approveOrRejectUsers.php';
       //Loop through all of the rows in the table
       for ($i = 0; $i < $rowNumber; $i++){
           if (isset($_POST["user$i"])){
               if (approveOrReject($approveOrReject, $emailArray[$i])){
                header('Location: userqueue.php');
                }
                else {
                    echo 'Error updating users';
                }
           }
       }
    }
}
?>

<head>
    <title>New User Approval Queue</title>
</head>

<body>

</body>

</html>