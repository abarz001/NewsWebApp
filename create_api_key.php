<?php
session_start();
require_once('favicon.php');

$CurrentAPIKey = "None";
echo '<center><br><a href="index.php">Home Page</a><br>
<a href="logout.php">Logout</a></center><br><br>';
if (!isset($_SESSION['userLoggedIn']) || $_SESSION['userLoggedIn'] == false) {
    echo 'Unauthorized user. You must be logged in to create an api key.';
} else {
    if (isset($_SESSION['ApprovedByAdmin']) && $_SESSION['ApprovedByAdmin']) {
        //Get current API key
        $server = "localhost";
        $sqlUser = "myadmin";
        $sqlPass = "myadminpass";
        $db = "PROJECT";
        $conn = new mysqli($server, $sqlUser, $sqlPass, $db);
        $email = $_SESSION['email'];
        $sqlStatement = "SELECT api_code FROM users WHERE Email='$email'";
        $query_result = $conn->query($sqlStatement);
        if (!$query_result) {
            echo $sqlStatement;
            echo "<br>Sorry, there was an error returning your current api key.";
            $CurrentAPIKey = "None";
        } else {
            if ($query_result->num_rows > 0) {
                $CurrentAPIKey = $query_result->fetch_row();
                $CurrentAPIKey = $CurrentAPIKey[0];
            } else {
                $CurrentAPIKey = "None";
            }
        }

        if (isset($_POST['btnUpdateKey'])) {
            //Update API key
            $newAPICode = md5('api' . $email . rand());
            $updateStatement = "UPDATE users 
            SET api_code = '$newAPICode'
            WHERE Email='$email'";
            // Run query
            $query_result = $conn->query($updateStatement)
                or die("SQL Query ERROR. Contact an admin. There was an error updating the api key." . $updateStatement . $conn->connect_error);
            $CurrentAPIKey = $newAPICode;
        }
    }
    else {
        echo 'Your account has not yet been approved by an admin.';
    }
}


?>


<html>

<head>
    <title>Create/Get API key</title>
</head>

<body>
    <div class="myform">
        <form action="" method="post" name="frmAPIKEY" id="frmAPIKEY">
            <table border="0" align="center" cellpadding="2" cellspacing="2">
                <tr>
                    <td><br><br><br><br><br>Current API Key: <?php 
                    if (isset($CurrentAPIKey[0])){
                        print_r($CurrentAPIKey);
                        echo "<br><br>API Usage: <br>
                        http://localhost/api.php?key=";
                        print_r($CurrentAPIKey);
                        echo "&query=YOURQUERY&n=ARTICLELIMIT";
                        } else 
                        { 
                            echo "None";
                        } 
                        ?>
                        </td>
                </tr>
                <tr>
                    <td><br><input name="btnUpdateKey" type="submit" id="btnUpdateKey" value="Get new API key" class="buttons"></td>
                </tr>
            </table>
        </form>
    </div>
    <?php require_once('footer.php'); ?>
</body>

</html>