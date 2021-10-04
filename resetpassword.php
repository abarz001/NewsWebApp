<?php
session_start();
if (isset($_GET['email']) && isset($_GET['resetCode']) && isset($_POST['newpassword'])) {
    $email = $_GET['email'];
    $resetCode = $_GET['resetCode'];
    if (isset($_POST['btnReset'])) {
        if ($_POST['newpassword'] == $_POST['renewpassword']) {
            require 'changeinformation.php';
            if (VerifyResetPasswordCode($email, $resetCode)) {
                $newPassword = $_POST['newpassword'];
                if (resetPassword($email, $resetCode, $newPassword)) {
                    header('Location: logout.php');
                } else {
                    echo 'There was an error resetting the password.';
                }
            }
            else {
                  echo 'There was an error setting a new password for that account.';
            }
        } else {
            echo 'Passwords do not match.';
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
        <table width="300" border="1" align="center" cellpadding="2" cellspacing="2">
            <tr>
                <td width="150">Enter your new password</td>
                <td><input name="newpassword" type="password" id="newpassword" value="" required></td>
            </tr>
            <tr>
                <td width="150">Confirm new password</td>
                <td><input name="renewpassword" type="password" id="renewpassword" value="" required></td>
            </tr>
            <tr>
                <td width="400" td colspan="2">
                    <center><input name="btnReset" type="submit" id="btnReset" value="Reset Password">
                    </center>
                </td>
            </tr>
        </table>
    </form>
</body>

</html>