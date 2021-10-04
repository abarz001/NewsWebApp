<?php
$server = "localhost";
$sqlUser = "myadmin";
$sqlPass = "myadminpass";
$db = "PROJECT";
function authenticate($email, $password)
{
    if (!isset($email) || !isset($password)) {
        echo 'email or pass not set';
        return false;
    }
    $server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass = "myadminpass";
    $db = "PROJECT";
    $conn = new mysqli($server, $sqlUser, $sqlPass, $db);
    //Encrypt the cleartext password
    $hashedPass = md5($password);
    $userTable = "USERS";
    $sqlStatement = "SELECT * FROM $userTable
					   WHERE Email = '$email'
					   AND Password = '$hashedPass'";

    //Run the SQL statement, return false if error.
    $query_result = $conn->query($sqlStatement);
    if (!$query_result) {
        echo $sqlStatement;
        echo "<br>Sorry, query is wrong";
    }


    // error handling
    $numRowsReturned = $query_result->num_rows;
    if ($numRowsReturned != 1) {
        return false;
    } else {
        while ($result = $query_result->fetch_assoc()) {
            //Update last login time in database
            $currentDateTime = date('Y-m-d H:i:s');
            $updateStatement = "UPDATE $userTable 
            SET Last_Login = '$currentDateTime'
            WHERE Email = '$email'";
            $update_result = $conn->query($updateStatement);

            $_SESSION['firstName'] = $result["Name_First"];
            $_SESSION['lastName'] = $result["Name_Last"];
            $_SESSION['organization'] = $result["Organization"];
            $_SESSION['lastLogin'] = $currentDateTime;
            $_SESSION['adminUser'] = $result["Admin_User"];
            $_SESSION['emailVerified'] = $result["Email_Verified"];
            $_SESSION['approvedByAdmin'] = $result["Approved_By_Admin"];
        }
        $newTwoFactorCode = md5($email . $currentDateTime);
        //Only send 2FA email if the account has email verified
        UpdateTwoFactorCode($email, $newTwoFactorCode);
        Send2FAEmail($email, $newTwoFactorCode);
        
        return true;
    }
}

function CheckIfConfirmedEmail($email, $password)
{
    if (!isset($email) || !isset($password)) {
        echo 'email or pass not set';
        return false;
    }
    $server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass = "myadminpass";
    $db = "PROJECT";
    $conn = new mysqli($server, $sqlUser, $sqlPass, $db);
    //Encrypt the cleartext password
    $hashedPass = md5($password);
    $userTable = "USERS";
    $sqlStatement = "SELECT * FROM $userTable
					   WHERE Email = '$email'
					   AND Password = '$hashedPass'";

    //Run the SQL statement, return false if error.
    $query_result = $conn->query($sqlStatement);
    if (!$query_result) {
        echo $sqlStatement;
        echo "<br>Query error.";
    }


    // error handling
    $numRowsReturned = $query_result->num_rows;
    if ($numRowsReturned > 0) {
        while ($result = $query_result->fetch_assoc()) {
            if ($result["Email_Verified"] == 1) {
                return true;
            } else {
                return false;
            };
        }
    }
}

function CheckIfUserIsApproved($email, $password)
{
    if (!isset($email) || !isset($password)) {
        echo 'email or pass not set';
        return false;
    }
    $server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass = "myadminpass";
    $db = "PROJECT";
    $conn = new mysqli($server, $sqlUser, $sqlPass, $db);
    //Encrypt the cleartext password
    $hashedPass = md5($password);
    $userTable = "USERS";
    $sqlStatement = "SELECT * FROM $userTable
					   WHERE Email = '$email'
					   AND Password = '$hashedPass'";

    //Run the SQL statement, return false if error.
    $query_result = $conn->query($sqlStatement);
    if (!$query_result) {
        echo $sqlStatement;
        echo "<br>Query error.";
    }


    // error handling
    $numRowsReturned = $query_result->num_rows;
    if ($numRowsReturned > 0) {
        while ($result = $query_result->fetch_assoc()) {
            if ($result["Approved_By_Admin"] == 1) {
                return true;
            } else {
                return false;
            };
        }
    }
}

function SendVerificationEmail($email)
{
    if (!isset($email)) {
        echo 'email not set';
        return false;
    }
    $verificationCode = md5($email);
    $to = $email;
    $subject = "Confirm your account.";
    $message = "Your verification code is: " . $verificationCode . "

    Please use the link below to verify your account.
    
    http://localhost/verifyaccount.php?email=" . $email . "&verificationCode=" . $verificationCode;
    $headers = "From: barzanjiaran@gmail.com";
    if (mail($to, $subject, $message, $headers)) {
        return true;
    } else {
        return false;
    }
}

function VerifyUser($email, $verificationCode){
    if (!isset($email) || !isset($verificationCode)) {
        return false;
    }
    $server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass = "myadminpass";
    $db = "PROJECT";
    $conn = new mysqli($server, $sqlUser, $sqlPass, $db);
    $userTable = "USERS";
    $sqlStatement = "SELECT * FROM $userTable
                       WHERE Email = '$email'
                       AND Verification_Code = '$verificationCode'";

    //Run the SQL statement, return false if error.
    $query_result = $conn->query($sqlStatement);
    if (!$query_result) {
        echo $sqlStatement;
        echo "<br>Query error.";
    }

    $numRowsReturned = $query_result->num_rows;
    if ($numRowsReturned > 0) {
            $updateStatement = "UPDATE $userTable 
            SET Email_Verified = true
            WHERE Email = '$email'";
            $update_result = $conn->query($updateStatement);
            if ($update_result){
                return true; //we successfully updated the Email_Verified attribute
            }
            else {
                return false; //We found the user's email, but the verification code doesn't match
            }
    }
    else {
        return false; //We couldn't find that email/verification code.
    }
}

function UpdateTwoFactorCode($email, $TwoFACode){
if (!isset($email) || !isset($TwoFACode)) {
        return false;
    }
    $server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass = "myadminpass";
    $db = "PROJECT";
    $conn = new mysqli($server, $sqlUser, $sqlPass, $db);
    $userTable = "USERS";
    $sqlStatement = "UPDATE $userTable
                     SET Two_Factor_Code = '$TwoFACode', 
                     Two_Factor_Approved = false
                     WHERE Email = '$email'";

    //Run the SQL statement, return false if error.
    $query_result = $conn->query($sqlStatement);
    if (!$query_result) {
        echo $sqlStatement;
        echo "<br>Query error.";
    }

    if ($query_result->num_rows > 0) {
                return true; //we successfully updated the two factor code
            }
            else {
                return false; //We didn't update the two factor code
            }
}

function CheckTwoFactor($email, $verificationCode, $lastLoginTime){
    if (!isset($email) || !isset($verificationCode)) {
        return false;
    }
    $server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass = "myadminpass";
    $db = "PROJECT";
    $conn = new mysqli($server, $sqlUser, $sqlPass, $db);
    $userTable = "USERS";
    $sqlStatement = "SELECT * FROM $userTable
                     WHERE Email = '$email'
                     AND Two_Factor_Code = '$verificationCode'
                     AND Last_Login = '$lastLoginTime'";

    //Run the SQL statement, return false if error.
    $query_result = $conn->query($sqlStatement);
    if (!$query_result) {
        echo $sqlStatement;
        echo "<br>Query error.";
        return false;
    }
    else{
    if ($query_result->num_rows > 0) {
        while ($result = $query_result->fetch_assoc()) {
            if ($result["Two_Factor_Approved"] == 1) {
                return true;
            } else {
                return false;
            };
        }
     }
     else {
         return false;
     }
    }
}

function SetTwoFactorApproved($email, $verificationCode, $lastLoginTime){
    if (!isset($email) || !isset($verificationCode)) {
        return false;
    }
    $server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass = "myadminpass";
    $db = "PROJECT";
    $conn = new mysqli($server, $sqlUser, $sqlPass, $db);
    $userTable = "USERS";
    $sqlStatement = "UPDATE $userTable
                     SET Two_Factor_Approved = true
                     WHERE Email = '$email'
                     AND Two_Factor_Code = '$verificationCode'
                     AND Last_Login = '$lastLoginTime'";

    //Run the SQL statement, return false if error.
    $query_result = $conn->query($sqlStatement);
    if (!$query_result) {
        return false;
    }
    else {
        //Checking to make sure one row got updated
        if ($conn->affected_rows == 1){
        return true;
        }
        else {
            return false;
        }
    }
}

function Send2FAEmail($email, $twoFACode)
{
    if (!isset($email) || !isset($twoFACode)) {
        return false;
    }
    $to = $email;
    $subject = "Two Factor Authentication Code";
    $message = "Your 2FA Code is: " . $twoFACode . "

    Use the link below to complete login:
    
    http://localhost/2FA.php?email=" . $email . "&authCode=" . $twoFACode;
    $headers = "From: barzanjiaran@gmail.com";
    if (mail($to, $subject, $message, $headers)) {
        return true;
    } else {
        return false;
    }
}

function SetResetCodeAndSendEmail($email, $resetCode)
{
    $server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass = "myadminpass";
    $db = "PROJECT";
    $conn = new mysqli($server, $sqlUser, $sqlPass, $db);
    $userTable = "USERS";
    $sqlStatement = "UPDATE $userTable
                     SET Reset_Code = '$resetCode'
                     WHERE Email = '$email'";

    //Run the SQL statement, return false if error.
    $query_result = $conn->query($sqlStatement);
    if (!$query_result) {
        echo $sqlStatement;
        echo "<br>Query error.";
        return false;
    } else {
        if (!isset($email) || !isset($resetCode)) {
            return false;
        }
        $to = $email;
        $subject = "Password Reset Link";
        $message = "Please use the link below to complete your password reset:
    
    http://localhost/resetpassword.php?email=" . $email . "&resetCode=" . $resetCode;
        $headers = "From: barzanjiaran@gmail.com";
        if (mail($to, $subject, $message, $headers)) {
            return true;
        } else {
            return false;
        }
    }
}