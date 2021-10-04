<?php

//include database information and user information
require 'authenticate.php';
session_start();
$errorMessage = '';

//are user ID and Password provided?
if (isset($_POST['email']) && isset($_POST['pass'])) {

    $email = $_POST['email'];
    $pass = $_POST['pass'];

    // Authenticate user
    if (authenticate($email, $pass)) {
        //the user id and password match,
        // set the session	
        $_SESSION['userLoggedIn'] = true;
        $_SESSION['email'] = $email;
        if (CheckIfConfirmedEmail($email, $pass)) {
            $_SESSION['emailVerified'] = true;
        } else {
            $_SESSION['emailVerified'] = false;
        }
        if (CheckIfUserIsApproved($email, $pass)) {
            $_SESSION['ApprovedByAdmin'] = true;
        } else {
            $_SESSION['ApprovedByAdmin'] = false;
        }
        if (CheckTwoFactor($email, md5($email . $_SESSION['lastLogin']), $_SESSION['lastLogin'])){
            $_SESSION['2FA_Approved'] = true;
        }
        else {
            $_SESSION['2FA_Approved'] = false;
        }
        // after login we move to the home page
        header('Location: index.php');
        exit;
    } else {
        $errorMessage = 'Sorry, wrong username/password. Please try again.<br>';
    }
}
?>

<html>

<head>
    <title>User Login</title>
</head>

<body>
    <Strong> <?php echo $errorMessage ?> </Strong>
    <form action="" method="post" name="frmLogin" id="frmLogin">
        <table width="400" border="1" align="center" cellpadding="2" cellspacing="2">
            <tr>
                <td width="150">Email Address</td>
                <td><input name="email" type="email" id="email"></td>
            </tr>
            <tr>
                <td width="150">Password</td>
                <td><input name="pass" type="password" id="pass"></td>
            </tr>
            <tr>
                <td width="150">&nbsp;</td>
                <td><input name="btnLogin" type="submit" id="btnLogin" value="Login"></td>
            </tr>
            <tr>
                <td width="150">Forgot password?</td>
                <td>
                    <a href="./sendresetemail.php">
                        Click here to reset password.
                    </a>
                </td>
            </tr>
            <tr>
                <td width="150">No account?</td>
                <td>
                    <a href="./signup.php">
                        Click here to sign up.
                    </a>
                </td>
            </tr>
        </table>
    </form>
</body>

</html>