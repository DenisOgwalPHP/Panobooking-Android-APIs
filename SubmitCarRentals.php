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
    $product = test_input($_POST['product']);
    $cost = test_input($_POST['cost']);
    $users = test_input($_POST['user']);
    $datesfrom = test_input($_POST['datesfrom']);
    $datesto = test_input($_POST['datesto']);
    $desDesc = test_input($_POST['desDesc']);
    $Facilityname = test_input($_POST['Facilityname']);
    $taxino = test_input($_POST['taxino']);
    $ordercode = "210107";
    $CurrencyAmount = test_input($_POST['CurrencyAmount']);
    $Currency = test_input($_POST['Currency']);
    include_once 'DB_Connect.php';
    $sql = "INSERT into cart(ProductName,Quantity,Cost,User,OrderCode,DatesFrom,DatesTo,Descriptions,Facility,ImageUrl,BookingType,Currency,CurrencyAmount)VALUES('$product','1','$cost','$users','$ordercode','$datesfrom','$datesto','$desDesc','$Facilityname','Rental Car','Car Rental','$Currency','$CurrencyAmount')";
    $result = mysqli_query($link, $sql);
    $response = array();
    if ($result) {
        $sql1 = "UPDATE carrentals SET Availability='Not Available' WHERE TaxiNo='" . $taxino . "' and DriverName='" . $Facilityname . "'";
        $result1 = mysqli_query($link, $sql1);

        $sql8 = "SELECT FullNames  FROM  registration where Email ='" . $users . "'";
        $result8 = mysqli_query($link, $sql8);
        if (mysqli_num_rows($result8) > 0) {
            while ($row2 = mysqli_fetch_array($result8)) {
                $rowresult2 = $row2['FullNames'];
                $sql7 = "SELECT EmailAddress FROM carrentals  where DriverName like '" . $Facilityname . "%' and  TaxiNo like '" . $taxino . "%'";
                $result7 = mysqli_query($link, $sql7);
                if (mysqli_num_rows($result7) > 0) {
                    while ($row = mysqli_fetch_array($result7)) {
                        $rowresult1 = $row['EmailAddress'];
                        $emails = 'sales@panobooking.email';
                        $to = trim($rowresult1);
                        $booknotes = 'Please Reserve for ' . $rowresult2 . ' 1 ' . $product . ' for a Period: From ' . $datesfrom . '. To: ' . $datesto . '. TOTAL PAYABLE: ' . $cost . ', Booking Notes: ' . $desDesc;
                        $subject = "Panobooking Sales";
                        $headers = "From: " . $emails . "\r\n";
                        $headers .= "Reply-To: " . $emails . "\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                        $message = '<html><body>';
                        $message .= '<div style=" box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);transition: 0.3s;width: 80%;background-color: #F0F0F0;margin: 0 auto;float: none;margin-bottom: 10px;border-radius: 30px 30px 30px 30px;">';
                        $message .= '<div style="text-align:center;background-color:#3383ff;width:100%;padding-top:10px;padding-bottom:10px;border-radius: 30px 30px 0px 0px;"><h1 style="text-align: center;padding:0px;font-size:20px;font-weight:500;color:white;">Booking From Panobooking</h1></div>';
                        $message .= '<p style="font-size:15px;padding:10px; margin:10px;text-align:justify">' . $booknotes . '</p>';
                        $message .= '<div style="padding:10px;text-align:center"><a href="https://carrental.panobooking.com/"><button style="padding:10px;text-align:center;height:50px;border-radius: 10px;background-color:#3383ff; color:white;font-size:20px;">Confirm Order</button></a></div></div>';
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
