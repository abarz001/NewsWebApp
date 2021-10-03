<?php
    $server = "localhost";
    $sqlUser = "myadmin";
    $sqlPass= "myadminpass";
    $db = "PROJECT";
	function authenticate($email, $password)
	{
	  if (!isset($email) || !isset($password))
	  {
		  echo 'email or pass not set';
		return false;  
	  }
	  $server = "localhost";
	  $sqlUser = "myadmin";
      $sqlPass= "myadminpass";
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
      if (!$query_result) 
	  {
              echo $sqlStatement;
			  echo "<br>Sorry, query is wrong";
      }


	  // error handling
      $numRowsReturned = $query_result->num_rows;
	  if ( $numRowsReturned != 1)
	  {
		 return false; 
	  }
	  else
	  {
        while ($result = $query_result->fetch_assoc())
        {
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
        return true;
    }
    }

    function CheckIfUserIsApproved($email, $password)
	{
	  if (!isset($email) || !isset($password))
	  {
		  echo 'email or pass not set';
		return false;  
	  }
	  $server = "localhost";
	  $sqlUser = "myadmin";
      $sqlPass= "myadminpass";
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
      if (!$query_result) 
	  {
              echo $sqlStatement;
			  echo "<br>Sorry, query is wrong";
      }


	  // error handling
      $numRowsReturned = $query_result->num_rows;
	  if ($numRowsReturned > 0)
	  {
        while ($result = $query_result->fetch_assoc())
        {
            if ($result["Approved_By_Admin"] == 1)
            {
                return true;
            }
            else 
            {
                return false;
            };
        }
        
	  }
	}
