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
 $stmt =$link->prepare("SELECT IDs,Place,City,Country,Rating,Comment,GuestHouseName,Prices,PriceSpecifications,TaxesInclusive,Prepayment,PhotoUrl FROM homeguesthouses where City like '".$realacc1."%' and  Availability='Available'");
 
 //executing the query 
 $stmt->execute();
 
 //binding results to the query 
 $stmt->bind_result($ids,$pickplace,$pickcountry,$pickcity,$pickrating,$pickcomment,$pickleftrooms,$pickprices,$pickpricespecs,$picktaxes,$pickprepayment,$pickphoto);
 $response = array(); 
 
 //traversing through all the result 
while ($stmt->fetch()) {
  $temp = array();
  $temp['IDs'] = $ids;
  $temp['Place'] = $pickplace;
  $temp['City'] = $pickcity;
  $temp['Country'] = $pickcountry;
  $temp['Rating'] = $pickrating;
  $temp['Comment'] = $pickcomment;
  $temp['GuestHouseName'] = $pickleftrooms;
  $temp['Prices'] = $pickprices;
  $temp['PriceSpecifications'] = $pickpricespecs;
  $temp['TaxesInclusive'] = $picktaxes;
  $temp['Prepayment'] = $pickprepayment;
  $temp['PhotoUrl'] = $pickphoto;
  array_push($response, $temp);
}
 
 //displaying the result in json format 
 echo json_encode($response);