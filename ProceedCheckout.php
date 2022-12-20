<?php
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
if (isset($_POST)) {
    $cost = test_input($_POST['totalcost']);
    $users = test_input($_POST['user']);
    $yer = date('y');
    $mon = date('m');
    $da = date('d');
    $realdate = date('Y-m-d');
    $ordercode = $yer . $mon . $da;

    include_once 'DB_Connect.php';
    $sql2 = "SELECT COUNT(OrderCode) as total FROM bookings where Date like '" . $realdate . "%'";
    $result2 = mysqli_query($link, $sql2);
    $data = mysqli_fetch_assoc($result2);
    $count = $data['total'];
    if ($count >= 1) {
        $ordercode = $yer . $mon . $da . $count;
    } else {
        $count = "0";
        $ordercode = $yer . $mon . $da . $count;
    }
    //echo $ordercode;
    $sql = "INSERT into bookings(TotalCost,User,OrderCode)VALUES('$cost','$users','$ordercode')";
    $result = mysqli_query($link, $sql);
    $response = array();
    if ($result) {
        $sql1 = "UPDATE cart SET Booked='Yes', OrderCode='$ordercode' WHERE User='" . $users . "' and Booked='No'";
        $result1 = mysqli_query($link, $sql1);

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
