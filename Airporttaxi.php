<?php
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
include_once 'DB_Connect.php';
 $realacc1=test_input($_GET["realaccs"]);
  
$stmtss =$link->prepare("SELECT Price FROM taxitrip where Tos like '%".$realacc1."%'");
$stmtss->execute();
$stmtss->bind_result($Pricess);
while ($stmtss->fetch()) {
   $realprice = $Pricess;
}
   
 $stmt =$link->prepare("SELECT IDs,DriverName,TaxiNo,Ratings,CarSpec,Repayments,Price,PhotoUri FROM airporttaxi where CurrentLocation like '%".$realacc1."%' OR SearchTerms like '%".$realacc1."%' and Availability='Available'");

 //executing the query 
 $stmt->execute();
 $stmt->store_result();
 $count=$stmt->num_rows;
 $response = array();
if ($count == 0) {
   //binding results to the query
   $stmts = $link->prepare("SELECT IDs,DriverName,TaxiNo,Ratings,CarSpec,Repayments,Price,PhotoUri FROM airporttaxi where Availability='Available'");
   $stmts->execute();
   $stmts->bind_result($ids, $drivername, $taxino, $rating, $carspec, $repayments, $prices, $photo);

   //traversing through all the result 
   while ($stmts->fetch()) {
      $temp = array();
      $temp['IDs'] = $ids;
      $temp['DriverName'] = $drivername;
      $temp['TaxiNo'] = $taxino;
      $temp['Ratings'] = $rating;
      $temp['CarSpec'] = $carspec;
      $temp['Repayments'] = $repayments;
      $temp['Price'] = $realprice;
      $temp['PhotoUri'] = $photo;
      array_push($response, $temp);
   }
} else {
   //binding results to the query 
   $stmt->bind_result($ids, $drivername, $taxino, $rating, $carspec, $repayments, $prices, $photo);
   //traversing through all the result 
   while ($stmt->fetch()) {
      $temp = array();
      $temp['IDs'] = $ids;
      $temp['DriverName'] = $drivername;
      $temp['TaxiNo'] = $taxino;
      $temp['Ratings'] = $rating;
      $temp['CarSpec'] = $carspec;
      $temp['Repayments'] = $repayments;
      $temp['Price'] = $realprice;
      $temp['PhotoUri'] = $photo;
      array_push($response, $temp);
   }
}
 //displaying the result in json format 
 echo json_encode($response);