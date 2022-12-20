<?php
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
if (isset($_POST)) {
	$email = test_input($_POST['email']);
	$newpassword = test_input($_POST['newpassword']);
	$oldpassword = test_input($_POST['oldpassword']);
	$hashed_password = md5($newpassword);
	$hashed_password1 = md5($oldpassword);
	include_once 'DB_Connect.php';

	$sql2 = "SELECT FullNames,Email,created_at,unique_id,Telephone FROM registration where Email ='" . $email . "' and Password='" . $hashed_password1 . "'";
	$result2 = mysqli_query($link, $sql2);
	if (mysqli_num_rows($result2) > 0) {
		$sql1 = "UPDATE registration SET Password='" . $hashed_password . "' where Email ='" . $email . "'";
		$result1 = mysqli_query($link, $sql1);
		$response = array();
		if ($result1) {
			$messages = 'Correct Info';
			$response['error'] = $messages;
			echo json_encode($response);
		} else {
			$messages = 'Password Update Failed';
			$response['error'] = $messages;
			echo json_encode($response);
		}
	} else {
		$messages = 'Old Password is Incorrect';
		$response['error'] = $messages;
		echo json_encode($response);
	}
} else {
	$messages = 'Something UnExpected Happened, Try Again Later';
	$response['error'] = $messages;
	echo json_encode($response);
}
?>
