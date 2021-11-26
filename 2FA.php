<?php
session_start();
require 'authenticate.php';
require_once('favicon.php');
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
            echo '<div class="centertext"><br>Error confirming 2FA code.<br>Please click the link in your email or re-login to generate new code.</div>';
        }
    }
}
?>

<html>

<head>
    <title>2FA Authentication - Continue to login</title>
        <style>
        .twofa {
            border-width: 5px;
            border-style: groove;
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-40%, -40%);
            transform: translate(-50%, -65%);
            text-align: center;
        }
                .centertext {
            text-align: center;
        }
    </style>
</head>


<body>
    <div class="twofa">
    <form action="" method="post" name="frmVerification" id="frmVerification">
        <table width="400" border="0" align="center" cellpadding="5" cellspacing="5">
            <tr>
                <td width="150">Email</td>
                <td><input name="email" type="email" id="email" required value="<?php echo $email ?>"></td>
            </tr>
            <tr>
                <td width="150">Two Factor Authentication Code</td>
                <td><input name="auCode" type="text" id="auCode" required value="<?php echo $authorizationCode ?>"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <center><br><input name="btnContinue" type="submit" id="btnContinue" value="Complete Login">
                    </center><br>
                </td>
            </tr>
        </table>
    </form>
    </div>
    <?php require_once('footer.php'); ?>
</body>

</html>