<?php
session_start();

if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == true) {
    $userEmail = $_SESSION['email'];
    $firstName = $_SESSION['firstName'];
    $lastName = $_SESSION['lastName'];
    $organization = $_SESSION['organization'];
    $lastLogin = $_SESSION['lastLogin'];
    $adminUser = $_SESSION['adminUser'];
    $emailVerified = $_SESSION['emailVerified'];
    $approvedByAdmin = $_SESSION['approvedByAdmin'];
    //For Debugging 
    //echo 'Logged in as: ' . '<br><br>' . $userEmail . '.<br>' . md5($userEmail . $lastLogin) . '<br>' . $lastLogin;
    if (isset($_SESSION['ApprovedByAdmin']) && $_SESSION['ApprovedByAdmin']) {
        if (isset($_SESSION['emailVerified']) && $_SESSION['emailVerified']) {
            require 'authenticate.php';
            if (CheckTwoFactor($userEmail, md5($userEmail . $lastLogin), $lastLogin)) {
                if ($adminUser){
                    echo '<br>Welcome, admin!<br>';
                    echo '<br><a href="userqueue.php">Approve/Reject User Registration Requests</a><br><br>';
                }
                else {
                    echo 'Welcome! Everything is good to go and you have full access to the site.<br><br>';
                }
            } else {
               header('Location: 2FA.php');
            }
        }
        else {
            echo 'Your account has been approved by an administrator, but you still need to confirm your email. <br>
            Click the email you have been sent to confirm your account.';
            exit;
        }
    } else {
        echo 'Your account is currently pending approval by an admin. Please check back later to see if your account has been approved by an admin.';
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}
?>

<html>

<head>
    <title>Fake News Analyzer Home Page</title>
</head>

<body>
    <form action="" method="post" name="frmProfile" id="frmProfile">
        <a href="profile.php">Update Profile Information</a><br>
        <a href="logout.php">Logout</a>
    </form>
</body>

</html>