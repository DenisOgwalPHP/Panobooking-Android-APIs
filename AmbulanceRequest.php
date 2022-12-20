<?php
 include_once 'DB_Connect.php';
  //creating a query
 $stmt =$link->prepare("SELECT IDs,CurrentLocation,City FROM ambulances order by CurrentLocation ASC");
 //executing the query 
 $stmt->execute();
 //binding results to the query 
 $stmt->bind_result($locationid,$currentlocation,$district);
 $response = array(); 
 //traversing through all the result 
while ($stmt->fetch()) {
    $temp = array();
    $temp['IDs'] = $locationid;
    $temp['Station'] = $currentlocation;
    $temp['District'] = $district;
    array_push($response, $temp);
}
 //displaying the result in json format 
 echo json_encode($response);
