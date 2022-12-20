<?php
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
if (isset($_POST)) {
   $email = test_input($_POST['email']);
   $password = test_input($_POST['password']);
   $hashed_password = md5($password);

   include_once 'DB_Connect.php';
   $sql1 = "SELECT FullNames,Email,created_at,IDDesc,Telephone,SelectedCurrency FROM registration where Email ='" . $email . "' and Password='" . $hashed_password . "' and ApprovalStatus='Approved'";
   $result1 = mysqli_query($link, $sql1);
   if (mysqli_num_rows($result1) > 0) {
      while ($row = mysqli_fetch_array($result1)) {
         $rowresult1 = $row['FullNames'];
         $rowresult2 = $row['Email'];
         $rowresult3 = $row['created_at'];
         $rowresult4 = $row['IDDesc'];
         $rowresult5 = $row['Telephone'];
         $rowresult6 = $row['SelectedCurrency'];
         $response = array();
         if ($result1) {
            $messages = 'Correct Info';
            $response['error'] = $messages;
            $response['name'] = $rowresult1;
            $response['uid'] = $rowresult4;
            $response['email'] = $rowresult2;
            $response['created_at'] = $rowresult3;
            $response['phone'] = $rowresult5;
            $response['SelectedCurrency'] = $rowresult6;
            echo json_encode($response);
         } else {
            $messages = 'Something Un Expected Happened, Try Again Later';
            $response['error'] = $messages;
            echo json_encode($response);
         }
      }
   } else {
      $messages = 'Password User Name Do not Match any Account';
      $response['error'] = $messages;
      echo json_encode($response);
   }
}
?>
