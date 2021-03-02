<?
$mms = urlencode($_REQUEST['mms']);
//SEND MESSAGE TO LINE NOTIFY
$lineapi = "pU4T5laMe8p5hCyOPiGWhB3P0LjFfQM9wnOTeb9uf6o";
//$mms =  "\nYou have new IT Service Request \n";
//$mms .=  "Job No : ".$new_id."\n";
//$mms .=  "Problem : ".lang_thai_from_database($problem_topic)."\n";
//$mms .=  "Request By : ".get_full_name($empno)."\n";
//line Send

$chOne = curl_init(); 
curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
// SSL USE 
curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
//POST 
curl_setopt( $chOne, CURLOPT_POST, 1); 
// Message 
curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$mms"); 
//ถ้าต้องการใส่รุป ให้ใส่ 2 parameter imageThumbnail และimageFullsize
//curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$mms&imageThumbnail=http://plusquotes.com/images/quotes-img/surprise-happy-birthday-gifts-5.jpg&imageFullsize=http://plusquotes.com/images/quotes-img/surprise-happy-birthday-gifts-5.jpg&stickerPackageId=1&stickerId=100"); 
// follow redirects 
curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1); 
//ADD header array 
$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$lineapi.'', ); 
curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
//RETURN 
curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
$result = curl_exec( $chOne ); 
//Check error 
if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); } 
else { 
$result_ = json_decode($result, true); 
//echo "status : ".$result_['status']; echo "message : ". $result_['message']; 
} 
//Close connect 
curl_close( $chOne );   

?>