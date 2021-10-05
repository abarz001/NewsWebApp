<?php
session_start();

if (isset($_GET['email']) && isset($_GET['verificationCode'])) {
    $email = $_GET['email'];
    $verificationCode = $_GET['verificationCode'];
    if (isset($_POST['btnVerify'])){
        require 'authenticate.php';
        if (VerifyUser($email, $verificationCode)){
            header('Location: login.php');
        }
        else {
            echo 'failed to verify account';
        };
    }
}
else {
    echo 'Error';
}
?>

<html>

<head>
    <title>Verify Your Account / Email Address</title>
</head>


<body>
    <form action="" method="post" name="frmVerification" id="frmVerification">
        <table width="800" border="1" align="center" cellpadding="2" cellspacing="2">
                        <tr>
                    <td width="400" td colspan="2">
                        <center><label for="info">If your verification code has not already been pre-filled, copy and paste it into the box below and submit.'</label>
                        </center>
                    </td>

            </tr>
            <tr>
                <td width="150">Email Address</td>
                <td><?php echo $email ?></td>
            </tr>
            <tr>
            <td width="150">Verification Code</td>
            <td><input name="verificationCode" type="text" id="verificationCode" value="<?php echo $verificationCode?>"></td>
            </tr>
            <tr>
                    <td width="400" td colspan="2">
                        <center><input name="btnVerify" type="submit" id="btnVerify" value="Verify my account/email address">
                        </center>
                    </td>
            </tr>
        </table>
    </form>
</body>

</html>