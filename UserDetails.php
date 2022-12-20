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
 $stmt =$link->prepare("SELECT IDDesc,FullNames,Telephone,Address,SelectedCurrency FROM registration where Email like '".$realacc."%'");

 //executing the query 
 $stmt->execute();
 
 //binding results to the query 
 $stmt->bind_result($IDDesc,$FullNames,$Telephone,$Address,$SelectedCurrency);
 $response = array(); 
 
 //traversing through all the result 
while ($stmt->fetch()) {
  $temp = array();
  $temp['IDDesc'] = $IDDesc;
  $temp['FullNames'] = $FullNames;
  $temp['Telephone'] = $Telephone;
  $temp['Address'] = $Address;
  $temp['SelectedCurrency'] = $SelectedCurrency;
  array_push($response, $temp);
}
 
 //displaying the result in json format 
 echo json_encode($response);