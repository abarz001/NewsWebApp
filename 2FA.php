<?php
session_start();
require 'authenticate.php';
if (isset($_GET['email']) || isset($_SESSION['email'])) {

    $lastLogin = $_SESSION['lastLogin'];

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    } else if (isset($_GET['email'])) {
        $email = $_GET['email'];
    } else {
        $email = $_SESSION['email'];
    }
    if (isset($_POST['auCode'])) {
        $authorizationCode = $_POST['auCode'];
    } else if (isset($_GET['authCode'])) {
        $authorizationCode = $_GET['authCode'];
    } else {
        $authorizationCode = null;
    }

    if (isset($_POST['btnContinue'])) {
        if (SetTwoFactorApproved($email, $authorizationCode, $lastLogin)) {
            header('Location: index.php');
        } else {
            echo '<br>Error confirming 2FA code.<br>Please click the link in your email or re-login to generate new code.';
        }
    }
}
?>

<html>

<head>
    <title>2FA Authentication - Continue to login</title>
</head>


<body>
    <form action="" method="post" name="frmVerification" id="frmVerification">
        <table width="800" border="1" align="center" cellpadding="2" cellspacing="2">
            <tr>
                <td width="150">Email</td>
                <td><input name="email" type="email" id="email" required value="<?php echo $email ?>"></td>
            </tr>
            <tr>
                <td width="150">Two Factor Authentication Code</td>
                <td><input name="auCode" type="text" id="auCode" required value="<?php echo $authorizationCode ?>"></td>
            </tr>
            <tr>
                <td width="400" td colspan="2">
                    <center><input name="btnContinue" type="submit" id="btnContinue" value="Complete Login">
                    </center>
                </td>
            </tr>
        </table>
    </form>
</body>

</html>