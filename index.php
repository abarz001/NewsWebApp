<?php
session_start();
require_once('favicon.php');
if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == true) {
    $userEmail = $_SESSION['email'];
    $firstName = $_SESSION['firstName'];
    $lastName = $_SESSION['lastName'];
    $organization = $_SESSION['organization'];
    $lastLogin = $_SESSION['lastLogin'];
    $adminUser = $_SESSION['adminUser'];
    $emailVerified = $_SESSION['emailVerified'];
    $approvedByAdmin = $_SESSION['approvedByAdmin'];
	echo "<link href=\"./css/bootstrap.min.css\" rel=\"stylesheet\">
<script src=\"./js/jquery-3.6.0.min.js\"></script>
<script src=\"./js/bootstrap.bundle.min.js\"></script>
<script src=\"./js/load_tabs.js\"></script>
<script src=\"./js/speech2text.js\"></script>";
    //For Debugging 
    //echo 'Logged in as: ' . '<br><br>' . $userEmail . '.<br>' . md5($userEmail . $lastLogin) . '<br>' . $lastLogin;
    if (isset($_SESSION['emailVerified']) && $_SESSION['emailVerified']) {
        if (isset($_SESSION['ApprovedByAdmin']) && $_SESSION['ApprovedByAdmin']) {
            require 'authenticate.php';
            if (CheckTwoFactor($userEmail, md5($userEmail . $lastLogin), $lastLogin)) {
                if ($adminUser){
                    echo "<div class=\"container-fluid\"><div class=\"row\"><center><br><br><br><br>Welcome, $firstName! [administrator]</div><br>";
                    echo '<br><center><a href="userqueue.php"><input name="userqueue" type="button" value="Approve/Reject User Registration Requests" class="btn btn-secondary"></button></a>
                    <a href="addarticles.php"><input name="addarticles" type="button" value="Add Articles" class="btn btn-secondary"></button></a>
					<a href="insert_keywords.php"><input name="addkeywords" type="button" value="Update Keywords Table" class="btn btn-secondary"></button></a>
                    </button>
					<a href="update_semantic.php"><input name="addsemantic" type="button" value="Update Semantic Scholar Table" class="btn btn-secondary"></button></a>
                    </button>
					</center>';
                }
                else {
                    echo "<center><br><br><br><br>Welcome $firstName! Everything is good to go and you have full access to the site.<br><br></center>";
                }
            } else {
               header('Location: 2FA.php');
            }
        }
        else {
		echo 'Your account is currently pending approval by an admin. Please check back later to see if your account has been approved by an admin.';
        	echo '<br><br><a href="logout.php"><input name="logoutbtn" type="button" value="Logout" class="buttons"></a>';
        	exit;
        }
    } else {
	echo 'You need to confirm your email before logging in. Please check your email for the verification code/link.';
	echo '<br><br><a href="logout.php"><input name="logoutbtn" type="button" value="Logout" class="buttons"></a>';        
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
    <script src="./js/bootstrap.bundle.min.js"></script>
    <style>
            .buttons{
            height:30px;
        }
    </style>
</head>

<body><br><center>
    
    <form action="searchresults.php" method="get" name="frmSearch" id="frmSearch"><br>
            <input type="search" id="searchText" name="search" placeholder="Search for an article" style="width: 400px";>
            <input type="submit" value="Search" class="btn btn-primary">
            <input name="speech2text" type="button" value="Voice Search" class="btn btn-primary" onclick="startDictation(event)">
            <br><br><br>
        <a href="profile.php"><input name="userprofile" type="button" value="View/Update Profile Information" class="btn btn-secondary"></a>
        <a href="create_api_key.php"><input name="apikey" type="button" value="View/Update API Key" class="btn btn-secondary"></a><br><br>
        <a href="logout.php"><input name="logoutbtn" type="button" value="Logout" class="btn btn-secondary"></a>
    </form>
    </center>
    </div>
    <?php require_once('footer.php'); ?>
</body>

</html>
