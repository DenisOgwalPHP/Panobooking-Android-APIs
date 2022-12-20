<?php
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
$emails=test_input($_GET['emails']);
include_once 'DB_Connect.php';
$sql1="UPDATE registration  SET ApprovalStatus='Approved' where Email ='".$emails."'";
$result1=mysqli_query($link,$sql1);
if ($result1) {
    echo '<script type="application/javascript">';
    echo 'alert("Account Confirmed");';
    echo 'window.location.href="https://panobooking.com/Login";';
    echo '</script>';
} else {
    echo '<script type="application/javascript">';
    echo 'alert("Account Confirmation Failed");';
    echo 'window.location.href="https://panobooking.com/Register";';
    echo '</script>';
}
?>