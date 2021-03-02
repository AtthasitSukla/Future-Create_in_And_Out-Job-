<?php

		//return false;
		// mail
		require 'PHPMailer/PHPMailerAutoload.php';

		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP
		//$mail->SMTPDebug = 2; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mail->Host = "smtp.gmail.com";
		$mail->CharSet = "utf-8";
		$mail->Port = 465; // or 587
		$mail->IsHTML(true);
		$mail->Username = "ipackiwis@gmail.com";
		$mail->Password = "ipack@@@@2017";
		$mail->SetFrom("ipackiwis@gmail.com");
        $mail->Subject = "PRPO System Notification";
        $mail->Body = "ddd";

		$mail->IsHTML(true); 
        $mail->AddAddress("nakarin.j@ipacklogistics.com");
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }



?>