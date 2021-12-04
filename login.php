<?php

//include database information and user information
require 'authenticate.php';
session_start();
$errorMessage = '';
$recaptchaError = '';
//are user ID and Password provided?
if (isset($_POST['email']) && isset($_POST['pass'])) {

    if (isset($_POST['g-recaptcha-response'])) {
        $userResponse = $_POST['g-recaptcha-response'];
        $remoteIP = $_SERVER['REMOTE_ADDR'];
        $secretkey = '6Ldg4F8dAAAAAGoQrlu9LABE6mvAzfC03XzFi1UT';
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_response = file_get_contents($url . '?secret=' . $secretkey . '&response=' . $userResponse);
        $decodedResponse = json_decode($recaptcha_response);
        if (isset($decodedResponse->success) &&  $decodedResponse->success === true) {

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

                // after login we move to the home page
                header('Location: index.php');
                exit;
            } else {
                $errorMessage = 'Sorry, wrong username/password. Please try again.<br>';
            }
        } else {
           $recaptchaError = 'Sorry, you failed the reCAPTCHA challenge. Please try again.<br><br>';
        }
    }
}
?>

<html>

<head>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="./js/bootstrap.bundle.min.js"></script>

    <title>User Login</title>
    <style>
        .loginform {
            border-width: 2px;
            border-style: dashed;
            margin: 150;
            min-width: 335px;
            border-color: gray;
        }
        .buttons {
            width: 150px;
            height: 25px;
        }
        
    </style>
</head>

<body>
<div class="loginform">
    <div class="container">
    
        <center><?php echo $errorMessage . '<br>' . $recaptchaError ?></center>
        <form action="" method="post" name="frmLogin" id="frmLogin">
            <table border="0" align="center" cellpadding="2" cellspacing="2">
            <div class="row">
            <div class='col-md-4 col-sm-12'>Email Address</div>
            <div class='col-md-4 col-sm-12'><div class="input-group mb-3"><input name="email" type="email" id="email"></div></div>
            </div>
            <div class="row">
            <div class='col-md-4 col-sm-12'>Password</div>
            <div class='col-md-4 col-sm-12'><input name="pass" type="password" id="pass"></div>
            </div>
            <div class="row">
            <div class='col-md-4 col-sm-12'></div>
            <div class='col-md-4 col-sm-12'>
                    <br><div class="g-recaptcha" data-sitekey="6Ldg4F8dAAAAAIKQ-Dcs-qnGwN9lOMv469KCKkD7"></div><br>
                        <input name="btnLogin" type="submit" id="btnLogin" value="Login" class="btn btn-secondary">
            </div>
            </div><br>
            <div class="row">
            <div class='col-md-4 col-sm-12'>Forgot password?</div>
            <div class='col-md-4 col-sm-12'><a href="./sendresetemail.php"><input name="resetpass" type="button" value="Reset Password" class="btn btn-secondary"></a></div>
            </div><br>
            <div class="row">
            <div class='col-md-4 col-sm-12'>No account?</div>
            <div class='col-md-4 col-sm-12'><a href="./signup.php"><input name="signup" type="button" value="Sign Up" class="btn btn-secondary"></a></div>
            </div>
            </table>
        </form>
    </div>
    </div>
    <?php require_once('footer.php'); ?>
</body>

</html>