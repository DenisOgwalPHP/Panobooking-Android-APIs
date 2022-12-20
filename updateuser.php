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
	$fullnames = test_input($_POST['fullnames']);
	$addrees = test_input($_POST['addrees']);
	$phonenumber = test_input($_POST['phonenumber']);
	$SelectedCurrency = test_input($_POST['SelectedCurrency']);
	include_once 'DB_Connect.php';
	$sql1 = "UPDATE registration SET SelectedCurrency='" . $SelectedCurrency . "',FullNames='" . $fullnames . "',Telephone='" . $phonenumber . "',Address='" . $addrees . "' where Email ='" . $email . "'";
	$result1 = mysqli_query($link, $sql1);
	$response = array();
	if ($result1) {
		$messages = 'Correct Info';
		$response['error'] = $messages;
		echo json_encode($response);
	} else {
		$messages = 'User Update Failed';
		$response['error'] = $messages;
		echo json_encode($response);
	}
} else {
	$messages = 'Something UnExpected Happened, Try Again Later';
	$response['error'] = $messages;
	echo json_encode($response);
}
?>
