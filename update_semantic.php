<?php
session_start();
require_once('favicon.php');
echo '<center><br><a href="index.php">Home Page</a><br>
<a href="logout.php">Logout</a></center><br><br>';
if (!isset($_SESSION['adminUser']) || !$_SESSION['adminUser']) {
        echo 'Unauthorized user. You must be an admin to access this page.';
        return false;
    }
    else {
//Check if a list has been pasted
if (isset($_POST['btnUpdateSemantic'])){
	require 'mass_insert_semantic.php';
}
	}
?>


<html>

<head>
    <title>(Admin) Mass update semantic scholar articles in database</title>
</head>

<body>
    <div class="myform">
    <form action="" method="post" name="frmSemantic" id="frmSemantic">
        <table border="0" align="center" cellpadding="2" cellspacing="2">
            <tr>
                <td><br><br><br><br><br>Click 'Update Semantic Scholar Papers' below to mass update the current refute papers in the database based off of the current articles in the database.</td>
			</tr>
			<tr>
			<td><input name="btnUpdateSemantic" type="submit" id="btnUpdateSemantic" value="Update Semantic Scholar Papers" class="buttons"></td>
			</tr>
        </table>
    </form>
    </div>
    <?php require_once('footer.php'); ?>
</body>

</html>