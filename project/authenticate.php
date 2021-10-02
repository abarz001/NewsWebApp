<?php
	$server = "localhost";
	$sqlUser = "myadmin";
	$sqlPass= "myadminpass";
	$db = "PROJECT";
    $conn = new mysqli($server, $sqlUser, $sqlPass, $db);

	function authenticate($connection, $email, $password)
	{
	  $userTable = "USERS";
	  if (!isset($email) || !isset($password))
	  {
		return false;  
	  }

	  //Encrypt the cleartext password
	  $hashedPass = md5($password);
	  $sqlStatement = "SELECT * FROM $userTable
					   WHERE Email = '$email' 
					   AND password = '$hashedPass'";
	  echo $query;

	  //Run the SQL statement, return false if error.
      $query_result = $connection->query($sqlStatement);
      if (!$query_result) 
	  {
              echo "Sorry, database query error. Contact admin with a screenshot of this error.";
              echo $query;
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

?>
