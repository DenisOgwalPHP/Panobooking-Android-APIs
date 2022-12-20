<?php
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
 include_once 'DB_Connect.php';
$realacc=test_input($_GET["realacc"]);
  //creating a query
  //error_log($realacc);
 $stmt =$link->prepare("SELECT IDs,ArticleTitle,PostedBy,PostedAt,ArticleThumbNail,Attachment,Details FROM travelarticles where IDs='".$realacc."' order by IDs ASC");
 //executing the query 
 $stmt->execute();
 //binding results to the query 
 $stmt->bind_result($tourismid,$tourismarticles,$tourismpostedby,$tourismpostedat,$tourismthumbnail,$tourismattachment,$tourismdetails);
 $response = array(); 
 //traversing through all the result 
if ($stmt->fetch()) {
    $temp = array();
    $temp['IDs'] = $tourismid;
    $temp['ArticleTitle'] = $tourismarticles;
    $temp['PostedBy'] = $tourismpostedby;
    $temp['PostedAt'] = $tourismpostedat;
    $temp['ArticleThumbNail'] = $tourismthumbnail;
    $temp['Attachment'] = $tourismattachment;
    $temp['Details'] = $tourismdetails;
    array_push($response, $temp);
}
 //displaying the result in json format 
 echo json_encode($response);
