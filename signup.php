<?php
require 'authenticate.php';
session_start();
$errorMessage = 'Create a user account';

if (
    isset($_POST['email'])
    && isset($_POST['pass'])
    && isset($_POST['repass'])
) {
    $loginEmail = $_POST['email'];
    $loginPassword = $_POST['pass'];
    $reLoginPassword = $_POST['repass'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $organization = $_POST['organization'];

    if ($loginPassword == $reLoginPassword) {

        //connect to the db
        $conn = new mysqli($server, $sqlUser, $sqlPass, $db);
        $userTable = "USERS";
        $hashedPass = md5($loginPassword);
        $currentDateTime = date('Y-m-d H:i:s');
        //Check if user is already in database
        $checkUserStatement = "SELECT * FROM $userTable WHERE Email = '$loginEmail'";
        $check_query_result = $conn->query($checkUserStatement)
            or die("There was an error checking if the user already exists." . $checkUserStatement . $conn->connect_error);
        if ($check_query_result->num_rows != 0) {
            $errorMessage = "That email is already taken. Please choose another email address.";
        } else {
            //Generate a unique email verification code based off email.
            $verificationCode = md5($loginEmail);
            $insertStatement = "INSERT INTO $userTable 
            VALUES ('$loginEmail', '$currentDateTime', '$hashedPass',
                    '$firstName', '$lastName',
                    '$organization', '$currentDateTime',
                      null, null, 0,
                    '$verificationCode',0,0,0,0)";
            SendVerificationEmail($loginEmail, $loginPassword);
            // Insert into db
            $query_result = $conn->query($insertStatement)
                or die("SQL Query ERROR. Contact an admin. There was an error creating a user." . $insertStatement . $conn->connect_error);

            
            // Go to the login page
            header('Location: index.php');
            exit;
        }
    } else {
        $errorMessage = "Passwords do not match";
    }
}
?>

<html>

<head>
    <title>Sign-in</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <style>
        .centerforms {
            border-width: 5px;
            border-style: groove;
            margin: 0;
            position: absolute;
            top: 30%;
            left: 50%;
            -ms-transform: translate(-40%, -40%);
            transform: translate(-50%, -65%);
            text-align: center;
        }
    </style>
</head>

<body>
<div class="centerforms">
    <?php echo $errorMessage ?><br><br>
    <form action="" method="post" name="frmLogin" id="frmLogin">
        <table width="400" border="0" align="center" cellpadding="2" cellspacing="2">
            <tr>
                <td width="150">Enter valid email address*</td>
                <td><input name="email" type="email" id="email"></td>
            </tr>
            <tr>
                <td width="150">Enter Password*</td>
                <td><input name="pass" type="password" id="pass"></td>
            </tr>
            <tr>
                <td width="150">Re-enter Password*</td>
                <td><input name="repass" type="password" id="repass"></td>
            </tr>


            <tr>
                <td width="150">First Name</td>
                <td><input name="firstName" type="text" id="firstName"></td>
            </tr>
            <tr>

            <tr>
                <td width="150">Last Name</td>
                <td><input name="lastName" type="text" id="lastName"></td>
            </tr>
            <tr>
                <td width="150">Organization</td>
                <td><input name="organization" type="text" id="organization"></td>
            </tr>
            <tr>
            <tr>
                <td width="150">&nbsp;</td>
                <td><input name="btnLogin" type="submit" id="btnLogin" value="Register"></td>
            </tr>
        </table>
    </form>
    </div>
</body>

</html>