<?php
include('PHPMailerAutoload.php');

class Email
{

	function smtp_mailer($to, $subject, $msg)
	{

		$mail = new PHPMailer();
		$mail->SMTPDebug  = 3;
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'tls';
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 587;
		$mail->IsHTML(true);
		$mail->CharSet = 'UTF-8';
		$mail->Username = "nine9877@gmail.com";
		$mail->Password = "0968081641";
		$mail->SetFrom("nine9877@gmail.com","ฝ่ายงานกองทุนฯ");
		$mail->Subject = $subject;
		$mail->Body = $msg;
		$mail->AddAddress($to);

		if (!$mail->Send()) {
			return false;
		} else {
			return true;
		}
	}
}
