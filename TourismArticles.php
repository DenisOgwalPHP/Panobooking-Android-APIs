<?php
 include_once 'DB_Connect.php';
  //creating a query
 $stmt =$link->prepare("SELECT IDs,ArticleTitle,PostedBy,PostedAt,ArticleThumbNail FROM tourismarticles order by IDs ASC");
 //executing the query 
 $stmt->execute();
 //binding results to the query 
 $stmt->bind_result($tourismid,$tourismarticles,$tourismpostedby,$tourismpostedat,$tourismthumbnail);
 $response = array(); 
 //traversing through all the result 
while ($stmt->fetch()) {
    $temp = array();
    $temp['IDs'] = $tourismid;
    $temp['ArticleTitle'] = $tourismarticles;
    $temp['PostedBy'] = $tourismpostedby;
    $temp['PostedAt'] = $tourismpostedat;
    $temp['ArticleThumbNail'] = $tourismthumbnail;
    array_push($response, $temp);
}
 //displaying the result in json format 
 echo json_encode($response);
