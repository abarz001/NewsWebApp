<?php
function updateValues($email, $currentPassword, $newValues)
{
    if (!isset($email) || !isset($currentPassword)) {
        echo 'There has been an error';
        return false;
    } else {
        $server = "localhost";
        $sqlUser = "myadmin";
        $sqlPass = "myadminpass";
        $db = "PROJECT";
        $conn = new mysqli($server, $sqlUser, $sqlPass, $db);
        $hashedCurrentPass = md5($currentPassword);
        $userTable = "USERS";
        $emailAlreadyExists = false;
        $updatesForQuery = implode(', ', $newValues);
        $hashedPass = md5($currentPassword);
        $newValues = implode(', ', $newValues);
        $updateQuery = "UPDATE $userTable
					   SET $newValues
                       WHERE Email = '$email'
                       AND Password = '$hashedPass'";

        //Run the SQL statement
        $result = $conn->query($updateQuery);
        if (!$result) {
            if ($conn->errno == 1062) {
                echo 'Email address is already taken. Information was not updated. Please try another email address.';
            } else {
                echo 'There was an error updating your information.';
            }
            return false;
        } else {
            return true;
        }
    }
}

function resetPassword($email, $resetCode, $newPass)
{
    if (!isset($email) || !isset($resetCode) || !isset($newPass)) {
        return false;
    } else {
        $server = "localhost";
        $sqlUser = "myadmin";
        $sqlPass = "myadminpass";
        $db = "PROJECT";
        $conn = new mysqli($server, $sqlUser, $sqlPass, $db);
        $hashedNewPass = md5($newPass);
        $userTable = "USERS";
        $updateQuery = "UPDATE $userTable
					   SET Password = '$hashedNewPass'
                       WHERE Email = '$email'
                       AND Reset_Code = '$resetCode'";

        //Run the SQL statement
        $result = $conn->query($updateQuery);
        if (!$result) {
            return false;
        } else {
            return true;
        }
    }
}

function VerifyResetPasswordCode($email, $resetCode)
{
    if (!isset($email) || !isset($resetCode)) {
        return false;
    } else {
        $server = "localhost";
        $sqlUser = "myadmin";
        $sqlPass = "myadminpass";
        $db = "PROJECT";
        $conn = new mysqli($server, $sqlUser, $sqlPass, $db);
        $userTable = "USERS";
        $updateQuery = "SELECT * FROM $userTable
                       WHERE Email = '$email'
                       AND Reset_Code = '$resetCode'";

        //Run the SQL statement
        $result = $conn->query($updateQuery);
        if ($result->num_rows == 1) {
            return true;
        } else {
            return false;
        }
    }
}
