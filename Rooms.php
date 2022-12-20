<?php
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
 $realacc=test_input($_GET["realacc"]);
include_once 'DB_Connect.php';
  //creating a query
 error_log($realacc);
 $stmt =$link->prepare("SELECT IDs,RoomName,RefundPolicy,BedSpec,RoomSize,BreakFast,Price,RoomDesc,HotelName,PhotoUrl FROM rooms where HotelName like '".$realacc."%' and Availability='Available'");

 //executing the query 
 $stmt->execute();
 
 //binding results to the query 
 $stmt->bind_result($ids,$roomname,$refundpolicy,$bedspec,$roomsize,$breakfast,$costs,$roomdesc,$hotelname,$photourl);
 $response = array(); 
 
 //traversing through all the result 
while ($stmt->fetch()) {
  $temp = array();
  $temp['IDs'] = $ids;
  $temp['RoomName'] = $roomname;
  $temp['RefundPolicy'] = $refundpolicy;
  $temp['BedSpec'] = $bedspec;
  $temp['RoomSize'] = $roomsize;
  $temp['BreakFast'] = $breakfast;
  $temp['Price'] = $costs;
  $temp['RoomDesc'] = $roomdesc;
  $temp['HotelName'] = $hotelname;
  $temp['PhotoUrl'] = $photourl;
  array_push($response, $temp);
}
 
 //displaying the result in json format 
 echo json_encode($response);