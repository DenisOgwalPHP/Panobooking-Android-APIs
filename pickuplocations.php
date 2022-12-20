<?php

include_once 'DB_Connect.php';
  //creating a query
 $sql1="SELECT IDs,Place,City,Country FROM pickuplocations order by IDs ASC";
 $result1=mysqli_query($link,$sql1);
  $response = array();
while ($row = mysqli_fetch_array($result1)) {
  //binding results to the query 
  $ids = $row['IDs'];
  $pickplace = $row['Place'];
  $pickcity = $row['City'];
  $pickcountry = $row['Country'];
  //traversing through all the result 
  $temp = array();
  $temp['IDs'] = $ids;
  $temp['Place'] = $pickplace;
  $temp['City'] = $pickcity;
  $temp['Country'] = $pickcountry;
  array_push($response, $temp);
}
 
 //displaying the result in json format 
 echo json_encode($response);