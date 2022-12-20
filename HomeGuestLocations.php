<?php
 include_once 'DB_Connect.php';
  //creating a query
 $stmt =$link->prepare("SELECT IDs,Country,Place,City FROM homeguestlocations order by Place ASC");
 //executing the query 
 $stmt->execute();
 //binding results to the query 
 $stmt->bind_result($destinationid,$destinationcountry,$destinationregion,$destinationcity);
 $response = array(); 
 //traversing through all the result 
while ($stmt->fetch()) {
    $temp = array();
    $temp['IDs'] = $destinationid;
    $temp['Country'] = $destinationcountry;
    $temp['Place'] = $destinationregion;
    $temp['City'] = $destinationcity;
    array_push($response, $temp);
}
 //displaying the result in json format 
 echo json_encode($response);
