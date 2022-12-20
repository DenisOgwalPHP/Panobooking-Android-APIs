<?php
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
if (isset($_GET)) {
  $realacc = test_input($_GET["realacc"]);
  include_once 'DB_Connect.php';
  //creating a query
  //error_log($realacc);
  $stmt = $link->prepare("SELECT IDs,Place,City,Country,Rating,Comment,LeftRooms,Prices,PriceSpecifications,TaxesInclusive,Prepayment,PhotoUrl,BedBreakFast,CreditCard,ExactLocation,Description,Facilities,SustainabilityInitiatives,Policies,Checkout,Transportation,coordinates,TransportAir,TransportPark,Market,SuperMarket,CafeandBar,Restaurant FROM pickuplocations where Place='" . $realacc . "'");

  //executing the query 
  $stmt->execute();

  //binding results to the query 
  $stmt->bind_result($ids, $pickplace, $pickcountry, $pickcity, $pickrating, $pickcomment, $pickleftrooms, $pickprices, $pickpricespecs, $picktaxes, $pickprepayment, $pickphoto, $breakfast, $creditcard, $exactlocation, $description, $facilities, $sustainability, $policies, $checkout, $transportation, $coordinates, $transportair, $transportpark, $market, $supermarket, $cafeandbar, $restaurant);
  $response = array();

  //traversing through all the result 
  if ($stmt->fetch()) {
    $temp = array();
    $temp['IDs'] = $ids;
    $temp['Place'] = $pickplace;
    $temp['City'] = $pickcity;
    $temp['Country'] = $pickcountry;
    $temp['Rating'] = $pickrating;
    $temp['Comment'] = $pickcomment;
    $temp['LeftRooms'] = $pickleftrooms;
    $temp['Prices'] = $pickprices;
    $temp['PriceSpecifications'] = $pickpricespecs;
    $temp['TaxesInclusive'] = $picktaxes;
    $temp['Prepayment'] = $pickprepayment;
    $temp['PhotoUrl'] = $pickphoto;
    $temp['BedBreakFast'] = $breakfast;
    $temp['CreditCard'] = $creditcard;
    $temp['ExactLocation'] = $exactlocation;
    $temp['Description'] = $description;
    $temp['Facilities'] = $facilities;
    $temp['SustainabilityInitiatives'] = $sustainability;
    $temp['Policies'] = $policies;
    $temp['Checkout'] = $checkout;
    $temp['Transportation'] = $transportation;
    $temp['coordinates'] = $coordinates;
    $temp['TransportAir'] = $transportair;
    $temp['TransportPark'] = $transportpark;
    $temp['Market'] = $market;
    $temp['SuperMarket'] = $supermarket;
    $temp['CafeandBar'] = $cafeandbar;
    $temp['Restaurant'] = $restaurant;

    array_push($response, $temp);
  } else {
    $messages = 'No Result Found';
    $response['error'] = $messages;
    echo json_encode($response);
  }

  //displaying the result in json format 
  echo json_encode($response);
}