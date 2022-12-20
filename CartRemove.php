<?php
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
if (isset($_POST)) {
    $product = test_input($_POST['product']);
    $users = test_input($_POST['user']);
    $ordercodes = test_input($_POST['ordercodes']);

    include_once 'DB_Connect.php';
    $sql = "DELETE FROM cart WHERE ProductName='" . $product . "' and User='" . $users . "' and OrderCode='" . $ordercodes . "'";
    $result = mysqli_query($link, $sql);
    $response = array();
    if ($result) {
        $messages = 'Correct Info';
        $response['error'] = $messages;
        echo json_encode($response);
    } else {
        $messages = 'Something Un Expected Happened, Try Again Later';
        $response['error'] = $messages;
        echo json_encode($response);
    }
}
?>
