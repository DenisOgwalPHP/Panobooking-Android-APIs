<?php
 $realacc=$_GET["realacc"];
include_once 'DB_Connect.php';
  //creating a query
 error_log($realacc);
 $stmt =$link->prepare("SELECT IDs,Place,Distance FROM nearbysupermarkets where PropertyName like '".$realacc."%'");
 
 //executing the query 
 $stmt->execute();
 
 //binding results to the query 
 $stmt->bind_result($ids,$nearplace,$neardist);
 $responsess = array(); 
 
 //traversing through all the result 
 while($stmt->fetch()){
 $temp = array();
  $temp['IDs'] = $ids; 
  $temp['Place'] =  $nearplace;
  $temp['Distance'] = $neardist; 
 array_push($responsess, $temp);
 }
 
 //displaying the result in json format 
 echo json_encode($responsess);