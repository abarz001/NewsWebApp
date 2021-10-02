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
            if ($result["Approved_By_Admin"] == 2)
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
?>
