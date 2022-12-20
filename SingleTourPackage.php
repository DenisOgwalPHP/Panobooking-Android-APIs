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
 $stmt =$link->prepare("SELECT IDs,PackageName,City,TravelDate,TravelCompany,PackageFees2,PhotoUri,ServicesOffered,Country,DestinationsVisted,ExtraActivites,TravelHours,TripDays FROM tourpackage where IDs=$realacc  Order by IDs ASC");
 
 //executing the query 
 $stmt->execute();
 
 //binding results to the query 
 $stmt->bind_result($ids,$packagename,$city,$traveldate,$travelcompany,$packagefees,$photouri,$servicesoffered,$country,$destinationsvisited,$extraactivities,$Travelhours,$tripdays);
 $response = array(); 
 
 //traversing through all the result 
while ($stmt->fetch()) {
  $temp = array();
  $temp['IDs'] = $ids;
  $temp['PackageName'] = $packagename;
  $temp['City'] = $city;
  $temp['TravelDate'] = $traveldate;
  $temp['TravelCompany'] = $travelcompany;
  $temp['PackageFees2'] = $packagefees;
  $temp['PhotoUri'] = $photouri;
  $temp['ServicesOffered'] = $servicesoffered;
  $temp['Country'] = $country;
  $temp['DestinationsVisted'] = $destinationsvisited;
  $temp['ExtraActivites'] = $extraactivities;
  $temp['TravelHours'] = $Travelhours;
  $temp['TripDays'] = $tripdays;

  array_push($response, $temp);
}
 
 //displaying the result in json format 
 echo json_encode($response);