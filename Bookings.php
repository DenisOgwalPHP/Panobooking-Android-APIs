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
 //error_log($realacc);
 $stmt =$link->prepare("SELECT IDs,OrderCode,CurrencyAmount,Date,Currency  FROM cart where User like '%".$realacc."%' and Confirmed !='Pending'");

 //executing the query 
 $stmt->execute();
 
 //binding results to the query 
 $stmt->bind_result($IDs,$OrderCode,$Cost,$Date,$Currency);
 $response = array(); 
 
 //traversing through all the result 
while ($stmt->fetch()) {
    $temp = array();
    $temp['IDs'] = $IDs;
    $temp['OrderCode'] = $OrderCode;
    $temp['TotalCost'] = $Cost;
    $temp['Date'] = $Date;
    $temp['Currency'] = $Currency;
    array_push($response, $temp);
}
 
 //displaying the result in json format 
 echo json_encode($response);