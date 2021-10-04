<?php
session_start();
require 'authenticate.php';
if (isset($_GET['email']) && isset($_GET['authCode'])) {
    $email = $_GET['email'];
    $authorizationCode = $_GET['authCode'];
    $lastLogin = $_SESSION['lastLogin'];
    if (isset($_POST['btnContinue'])) {
        if (SetTwoFactorApproved($email, $authorizationCode, $lastLogin)){
            $_SESSION['2FA_Approved'] = true;
            header('Location: index.php');
        }
        else {
            $_SESSION['2FA_Approved'] = false;
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
                <td width="150">2FA Authentication Code</td>
                <td><input name="authCode" type="text" id="authCode" value="<?php echo $authorizationCode ?>"></td>
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