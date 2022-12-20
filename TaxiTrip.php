<?php
include_once 'DB_Connect.php';
  //creating a query
 $sql1="SELECT Ids,Froms,Tos,Price FROM taxitrip  order by Tos ASC";
 $result1=mysqli_query($link,$sql1);
  $response = array();
while ($row = mysqli_fetch_array($result1)) {
  //binding results to the query 
  $ids = $row['Ids'];
  $pickplace = $row['Froms'];
  $pickcity = $row['Tos'];
  $pickcountry = $row['Price'];
  //traversing through all the result 
  $temp = array();
  $temp['Ids'] = $ids;
  $temp['Froms'] = $pickplace;
  $temp['Tos'] = $pickcity;
  $temp['Price'] = $pickcountry;
  array_push($response, $temp);
}
 
 //displaying the result in json format 
 echo json_encode($response);