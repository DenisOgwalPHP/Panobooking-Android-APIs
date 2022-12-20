<?php
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
 $realacc=test_input($_GET["realacc"]);
$realacc1=test_input($_GET["realacc1"]);
include_once 'DB_Connect.php';
  //creating a query
 //error_log($realacc);
 $stmt =$link->prepare("SELECT IDs,DriverName,DriverAge,TaxiNo,Ratings,CarSpec,Repayments,Price,CurrentLocation,EmailAddress,PhotoUri FROM ambulances where CurrentLocation like '".$realacc1."%' OR City like '".$realacc1."%'  OR SearchTerms like '".$realacc1."%' and  Availability='Available'");
 
 //executing the query 
 $stmt->execute();
 
 //binding results to the query 
 $stmt->bind_result($ids,$drivername,$driverage,$taxino,$pickrating,$carspec,$repayments,$pickprices,$currentlocation,$email,$pickphoto);
 $response = array(); 
 
 //traversing through all the result 
while ($stmt->fetch()) {
  $temp = array();
  $temp['IDs'] = $ids;
  $temp['DriverName'] = $drivername;
  $temp['DriverAge'] = $driverage;
  $temp['TaxiNo'] = $taxino;
  $temp['Ratings'] = $pickrating;
  $temp['CarSpec'] = $carspec;
  $temp['Repayments'] = $repayments;
  $temp['Price'] = $pickprices;
  $temp['CurrentLocation'] = $currentlocation;
  $temp['Email'] = $email;
  $temp['PhotoUri'] = $pickphoto;
  array_push($response, $temp);
}
 
 //displaying the result in json format 
 echo json_encode($response);