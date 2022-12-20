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
 $stmt =$link->prepare("SELECT ID,SiteName,City,Country,SearchKeyWords,PhotoUri,Description,ShortDescription,updated_at FROM tourismsites where ID=$realacc  Order by ID ASC");
 
 //executing the query 
 $stmt->execute();
 
 //binding results to the query 
 $stmt->bind_result($id,$sitename,$city,$country,$searchkeywords,$photouri,$description,$shortdescription,$updatedat);
 $response = array(); 
 
 //traversing through all the result 
while ($stmt->fetch()) {
    $temp = array();
    $temp['ID'] = $id;
    $temp['SiteName'] = $sitename;
    $temp['City'] = $city;
    $temp['Country'] = $country;
    $temp['SearchKeyWords'] = $searchkeywords;
    $temp['PhotoUri'] = $photouri;
    $temp['Description'] = $description;
    $temp['ShortDescription'] = $shortdescription;
    $temp['updated_at'] = $updatedat;

    array_push($response, $temp);
}
 
 //displaying the result in json format 
 echo json_encode($response);