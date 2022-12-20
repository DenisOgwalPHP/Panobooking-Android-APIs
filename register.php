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
    $username = test_input($_POST['name']);
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);
    $telephone = test_input($_POST['telephone']);
    $address = test_input($_POST['address']);
    $hashed_password = md5($password);
    $token = md5(uniqid(rand(), true));
    $timeregistered = date("Y-m-d H:i:s");
    include_once 'DB_Connect.php';
    $sql1 = "SELECT Email,Telephone FROM registration where Email ='" . $email . "'";
    $result1 = mysqli_query($link, $sql1);
    while ($row = mysqli_fetch_array($result1)) {
        $rowresult = $row['Email'];
        $rowresult1 = $row['Telephone'];
    }
    if ($rowresult != $email) {
        if ($telephone == "070") {
            $sql = "INSERT into registration(Fullnames,Email,Password,Telephone,Address,ApprovalStatus)VALUES('$username','$email','$hashed_password','$telephone','$address','Approved')";
        } else {
            $sql = "INSERT into registration(Fullnames,Email,Password,Telephone,Address)VALUES('$username','$email','$hashed_password','$telephone','$address')";
        }
        $result = mysqli_query($link, $sql);
        $response = array();
        if ($result) {
            $messages = 'Correct Info';
            $response['error'] = $messages;
            $response['uid'] = $token;
            $response['name'] = $username;
            $response['email'] = $email;
            $response['created_at'] = $timeregistered;
            $response['phone'] = $telephone;

            if ($telephone == "070") {
            } else {
                $emails = 'accounts@panobooking.email';
                $to = $email;
                $subject = "Panobooking Account Confirmation";
                $headers = "From: " . $emails . "\r\n";
                $headers .= "Reply-To: " . $emails . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                $message = '<html><body>';
                $message .= '<div style=" box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);transition: 0.3s;width: 80%;background-color: #F0F0F0;margin: 0 auto;float: none;margin-bottom: 10px;border-radius: 30px 30px 30px 30px;">';
                $message .= '<div style="text-align:center;background-color:#3383ff;width:100%;padding-top:10px;padding-bottom:10px;border-radius: 30px 30px 0px 0px;"><h1 style="text-align: center;padding:0px;font-size:20px;font-weight:500;color:white;">Confirmation Email</h1></div>';
                $message .= '<p style="font-size:15px;padding:10px; margin:10px;text-align:justify">You have been sent this email  because you have registered for an account with panobooking. Click Confirm button  to Approve your account and start using it to book </p>';
                $message .= '<div style="padding:10px;text-align:center"><a href="https://panobooking.com/SendEmails/ConfirmEmail.php?emails=' . $to . '"><button style="padding:10px;text-align:center;height:50px;border-radius: 10px;background-color:#3383ff; color:white;font-size:20px;">Confirm</button></a></div></div>';
                $message .= '</body></html>';
                mail($to, $subject, $message, $headers);
            }
            echo json_encode($response);
        } else {
            $messages = 'Something Un Expected Happened, Try Again Later';
            $response['error'] = $messages;
            echo json_encode($response);
        }
    } else if ($rowresult == $email && $rowresult1 == "070") {
        $messages = 'Correct Info';
        $response['error'] = $messages;
        $response['uid'] = $token;
        $response['name'] = $username;
        $response['email'] = $email;
        $response['created_at'] = $timeregistered;
        $response['phone'] = $telephone;

        echo json_encode($response);
    } else {
        $messages = 'Email already Exists';
        $response['error'] = $messages;
        echo json_encode($response);
    }
}
?>
