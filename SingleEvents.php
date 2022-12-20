<?php
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
$realacc=test_input($_GET["realacc"]);
 $currdate = date('Y-m-d');
 $strinfcurrdate=$currdate;
include_once 'DB_Connect.php';
 $stmt =$link->prepare("SELECT ID,EventName,City,Country,SearchKeyWords,PhotoUri,Description,ShortDescription,StartDate,EndDate FROM events where str_to_date(EndDate,'%Y-%m-%d') between str_to_date('".$strinfcurrdate."','%Y-%m-%d') and str_to_date('2030-01-01','%Y-%m-%d') and ID=$realacc Order by ID ASC");
 
 //executing the query 
 $stmt->execute();
 //binding results to the query 
 $stmt->bind_result($id,$eventname,$city,$country,$searchkeywords,$photouri,$description,$shortdescription,$startdate,$enddate);
 $response = array(); 
 
 //traversing through all the result 
while ($stmt->fetch()) {
    $temp = array();
    $temp['ID'] = $id;
    $temp['EventName'] = $eventname;
    $temp['City'] = $city;
    $temp['Country'] = $country;
    $temp['SearchKeyWords'] = $searchkeywords;
    $temp['PhotoUri'] = $photouri;
    $temp['Description'] = $description;
    $temp['ShortDescription'] = $shortdescription;
    $temp['StartDate'] = $startdate;
    $temp['EndDate'] = $enddate;
    array_push($response, $temp);
}
 //displaying the result in json format 
 echo json_encode($response);