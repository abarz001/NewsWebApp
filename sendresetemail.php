<?php
	session_start();
    unset($_SESSION["userLoggedIn"]);
    unset($_SESSION["email"]);
    unset($_SESSION["firstName"]);
    unset($_SESSION["lastName"]);
    unset($_SESSION["organization"]);
    unset($_SESSION["lastLogin"]);
    unset($_SESSION["adminUser"]);
    unset($_SESSION["emailVerified"]);
    unset($_SESSION["approvedByAdmin"]);
    unset($_SESSION['2FA_Approved']);
    session_destroy();
    session_start();
    require 'authenticate.php';
    $resultMessage = null;
    if (isset($_POST['email'])){
		$email = $_POST['email'];
	}
	
    if (isset($_POST['btnSendResetEmail'])) {
        $resetCode = md5($email . rand(0, 10000));
        if (SetResetCodeAndSendEmail($email, $resetCode)){
            $resultMessage = 'A password reset link has been sent to your inbox.';
        }
        else {
            $resultMessage = 'There was an error sending the password reset link.';
        }
    
}

?>

<html>

<head>
    <title>Reset Password</title>
</head>

<body>
    <form action="" method="post" name="frmProfile" id="frmProfile">
        <table width="400" border="1" align="center" cellpadding="3" cellspacing="3">
            <tr>
                <td width="400" td colspan="3">
                    <center>You will be sent an email to reset your password.<br>Ensure that it is correct.</center>
                </td>
            </tr>
            <tr>
                <td width="150">Confirm Email Address</td>
                <td><input name="email" type="email" id="email" value=""></td>
            </tr>
            <tr>
                <td width="400" td colspan="3">
                    <center><input name="btnSendResetEmail" type="submit" id="btnSendResetEmail" value="Send Reset Email"></center>
                </td>
            </tr>
        </table>
        <center><br><?php echo $resultMessage ?></center>
    </form>
</body>

</html>