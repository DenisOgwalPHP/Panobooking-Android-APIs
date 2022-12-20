<?php
 include_once 'DB_Connect.php';
 
  //creating a query
 $stmt =$link->prepare("SELECT DestinationID,Country,Region,City FROM destinations order by City ASC");
 //executing the query 
 $stmt->execute();
 //binding results to the query 
 $stmt->bind_result($destinationid,$destinationcountry,$destinationregion,$destinationcity);
 $response = array(); 
 //traversing through all the result 
while ($stmt->fetch()) {
    $temp = array();
    $temp['DestinationID'] = $destinationid;
    $temp['Country'] = $destinationcountry;
    $temp['Region'] = $destinationregion;
    $temp['City'] = $destinationcity;
    array_push($response, $temp);
}
 //displaying the result in json format 
 echo json_encode($response);
