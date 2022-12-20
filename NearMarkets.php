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
 $stmt =$link->prepare("SELECT IDs,Place,Distance FROM nearbymarkets  where PropertyName like '".$realacc."%'");
 
 //executing the query 
 $stmt->execute();
 
 //binding results to the query 
 $stmt->bind_result($ids,$nearplace,$neardist);
 $responses = array(); 
 
 //traversing through all the result 
while ($stmt->fetch()) {
  $temp = array();
  $temp['IDs'] = $ids;
  $temp['Place'] = $nearplace;
  $temp['Distance'] = $neardist;
  array_push($responses, $temp);
}
 
 //displaying the result in json format 
 echo json_encode($responses);