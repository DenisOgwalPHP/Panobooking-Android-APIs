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
 $stmt =$link->prepare("SELECT CurrencyValue FROM  currency  where CurrencyName like '".$realacc."%'");

 //executing the query 
 $stmt->execute();
 
 //binding results to the query 
 $stmt->bind_result($CurrencyValue);
 $responsess = array(); 
 
 //traversing through all the result 
while ($stmt->fetch()) {
    $temp = array();
    $temp['CurrencyValue'] = $CurrencyValue;

    array_push($responsess, $temp);
}
 
 //displaying the result in json format 
 echo json_encode($responsess);