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
    echo 'Welcome ', $_SESSION['email'], '.<br><br>';
    if (isset($_SESSION['ApprovedByAdmin']) && $_SESSION['ApprovedByAdmin']) {
        if (isset($_SESSION['emailVerified']) && $_SESSION['emailVerified']){
            if (isset($_SESSION['2FA_Approved']) && $_SESSION['2FA_Approved'])
            {
                echo 'Welcome! Everything is good to go and you have full access to the site.';
            }
            else {
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
        <a href="profile.php">Update User Information</a><br>
        <a href="logout.php">Logout</a>
    </form>
</body>

</html>