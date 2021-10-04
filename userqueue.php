<?php

?>

<head>
    <title>New User Approval Queue</title>
</head>

<body>
    <form action="" method="post" name="frmProfile" id="frmProfile">
        <table width="400" border="1" align="center" cellpadding="3" cellspacing="3">
            <tr>
                <td><b>Select</b></td>
                <td><b>Email Address</b></td>
                <td><b>Registration Date</b></td>
            </tr>
            <tr>
                <td><input type="checkbox" id="user1" name="user1" value=""></td>
                <td><?php echo $currentEmail ?></td>
                <td><input name="newEmail" type="email" id="newEmail" value=""></td>
            </tr>
            
        </table>
    </form>
</body>

</html>