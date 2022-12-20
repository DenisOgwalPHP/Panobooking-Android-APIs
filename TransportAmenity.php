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
 $stmt =$link->prepare("SELECT IDs,Amenity FROM transportation  where PropertyName like '".$realacc."%'");
 
 //executing the query 
 $stmt->execute();
 
 //binding results to the query 
 $stmt->bind_result($ids,$nearplace);
 $responsessssss = array(); 
 
 //traversing through all the result 
while ($stmt->fetch()) {
  $temp = array();
  $temp['IDs'] = $ids;
  $temp['Amenity'] = $nearplace;
  array_push($responsessssss, $temp);
}
 
 //displaying the result in json format 
 echo json_encode($responsessssss);