<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
if (isset($_POST)) {
    $product = test_input($_POST['ambulance_no']);
    $cost = test_input($_POST['cost']);
    $users = test_input($_POST['user']);
    $desDesc = test_input($_POST['reason']);
    $Facilityname = test_input($_POST['pickuppoint']);
    $date = new DateTime("now", new DateTimeZone('Africa/Kampala'));
    $formatteddate = $date->format('Y-m-d H:i:s');
    $datesfrom = $formatteddate;
    $datesto = $formatteddate;
    $ordercode = "210107";
    include_once 'DB_Connect.php';
    $sql = "INSERT into cart(ProductName,Quantity,Cost,User,OrderCode,DatesFrom,DatesTo,Descriptions,Facility,ImageUrl,BookingType)VALUES('$product','1','$cost','$users','$ordercode','$datesfrom','$datesto','$desDesc','$Facilityname','Ambulance','Ambulance')";
    $result = mysqli_query($link, $sql);
    $response = array();
    if ($result) {
        $sql1 = "UPDATE ambulances SET Availability='Not Available' WHERE TaxiNo='" . $product . "'";
        $result1 = mysqli_query($link, $sql1);


        $sql8 = "SELECT FullNames  FROM  registration where Email ='" . $users . "'";
        $result8 = mysqli_query($link, $sql8);
        if (mysqli_num_rows($result8) > 0) {
            while ($row2 = mysqli_fetch_array($result8)) {
                $rowresult2 = $row2['FullNames'];


                $sql7 = "SELECT EmailAddress FROM  ambulances  where TaxiNo like '" . $product . "%'";
                $result7 = mysqli_query($link, $sql7);
                if (mysqli_num_rows($result7) > 0) {
                    while ($row = mysqli_fetch_array($result7)) {
                        $rowresult1 = $row['EmailAddress'];

                        $emails = 'sales@panobooking.email';
                        $to = trim($rowresult1);
                        $booknotes = 'Please Help ' . $rowresult2 . ' Ambulance No. ' . $product . ' EXACT PICKUPPOINT: ' . $Facilityname . '.  REASON: ' . $desDesc;
                        $subject = "Panobooking Sales";
                        $headers = "From: " . $emails . "\r\n";
                        $headers .= "Reply-To: " . $emails . "\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                        $message = '<html><body>';
                        $message .= '<div style=" box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);transition: 0.3s;width: 80%;background-color: #F0F0F0;margin: 0 auto;float: none;margin-bottom: 10px;border-radius: 30px 30px 30px 30px;">';
                        $message .= '<div style="text-align:center;background-color:#3383ff;width:100%;padding-top:10px;padding-bottom:10px;border-radius: 30px 30px 0px 0px;"><h1 style="text-align: center;padding:0px;font-size:20px;font-weight:500;color:white;">Booking From Panobooking</h1></div>';
                        $message .= '<p style="font-size:15px;padding:10px; margin:10px;text-align:justify">' . $booknotes . '</p>';
                        $message .= '<div style="padding:10px;text-align:center"><a href="http://ambulance.panobooking.com/"><button style="padding:10px;text-align:center;height:50px;border-radius: 10px;background-color:#3383ff; color:white;font-size:20px;">Confirm Order</button></a></div></div>';
                        $message .= '</body></html>';
                        mail($to, $subject, $message, $headers);
                    }
                }
            }
        }

        $messages = 'Correct Info';
        $response['error'] = $messages;
        echo json_encode($response);
    } else {
        $messages = 'Something Un Expected Happened, Try Again Later';
        $response['error'] = $messages;
        echo json_encode($response);
    }
}
?>
