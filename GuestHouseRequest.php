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
    $cost = test_input($_POST['cost']);
    $users = test_input($_POST['user']);
    $datesfrom = test_input($_POST['datesfrom']);
    $datesto = test_input($_POST['datesto']);
    $desDesc = test_input($_POST['desDesc']);
    $Facilityname = test_input($_POST['Facilityname']);
    $ordercode = "210107";
    include_once 'DB_Connect.php';
    $sql = "INSERT into cart(ProductName,Quantity,Cost,User,OrderCode,DatesFrom,DatesTo,Descriptions,Facility,ImageUrl)VALUES('$product','1','$cost','$users','$ordercode','$datesfrom','$datesto','$desDesc','$Facilityname','Guest House')";
    $result = mysqli_query($link, $sql);
    $response = array();
    if ($result) {
        $sql1 = "UPDATE homeguesthouses SET Availability='Not Available' WHERE GuestHouseName='" . $product . "'";
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
