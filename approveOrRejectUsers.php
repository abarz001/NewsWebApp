<?php
function approveOrReject($approveOrReject, $email)
{
    if (!isset($approveOrReject) || !isset($email)) {
        echo 'There has been an error';
        return false;
    } else {
        $server = "localhost";
        $sqlUser = "myadmin";
        $sqlPass = "myadminpass";
        $db = "PROJECT";
        $conn = new mysqli($server, $sqlUser, $sqlPass, $db);
        $userTable = "USERS";
        if ($approveOrReject == 1){
            $approvedByAdmin = 1;
            $rejected = 0;
        }
        else if ($approveOrReject == 0){
            $approvedByAdmin = 0;
            $rejected = 1;
        }
            $updateQuery = "UPDATE $userTable
					   SET Approved_By_Admin = $approvedByAdmin, Rejected = $rejected
                       WHERE Email = '$email'";
        
        //Run the SQL statement
        $result = $conn->query($updateQuery);
        if (!$result){
            return false;
            echo "Failed to update $email<br><br>The query was:<br>$updateQuery<br>";
        } else {
            if ($conn->affected_rows == 1){
                return true;
            }
            else {
                return false;
                echo "Failed to update $email<br><br>The query was:<br>$updateQuery<br>";
            }
        }
    }
}
?>