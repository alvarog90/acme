<?php
$usuario		= "AAAAA@mataroin365.onmicrosoft.com";
$password		= "*******";

$nombre 		= $_POST['campo_nombre'];
$asunto 		= addslashes($_POST['campo_asunto']);
$email 			= $_POST['campo_email'];
$destinatario	= $_POST['campo_destinario'];

$cuerpo = "<html><head></head><body><style>table {font-family:tahoma,sans-serif;} th {text-align:right;}</style>\n";
$cuerpo .= "<table>\n";
foreach($_POST as $nombre_campo => $valor){
   $cuerpo .= "<tr><th>".$nombre_campo.": </th><td>".$valor."</td></tr>\n";
}

$cuerpo .= "</table>\n";
$cuerpo .= "</body></html>\n";

$cuerpo2 = "Asunto: ".$asunto."\n";
foreach($_POST as $nombre_campo => $valor){
   $cuerpo2 .= $nombre_campo.": ".$valor."\n";
}


// recaptcha
/*
$sk = '';
if(isset($_POST['g-recaptcha-response'])) {
	$captcha=$_POST['g-recaptcha-response'];
	  
	$response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$sk."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
	if($response['success'] == true) {
*/
		require('_class.phpmailer.php');
		require('_class.smtp.php');


		$mail = new phpmailer();
		$mail->IsSMTP();
		$mail->Host			= "smtp.office365.com";
		$mail->SMTPAuth		= true; 
		$mail->SMTPSecure 	= 'tls';
		$mail->Port 		= 587;
		$mail->Username		= $usuario	;
		$mail->Password		= $password;   

		$mail->SMTPDebug  	= 0;
		$mail->From 	  	= $usuario	;	
		$mail->FromName   	= "Web Mi proyecto";
		$mail->CharSet		= "UTF-8";
		$mail->isHTML(true); 

		$mail->AddAddress($destinatario);
		$mail->addReplyTo($email, $nombre);
		$mail->Subject 		= $asunto;

		$mail->Body = $cuerpo;
		$mail->AltBody = $cuerpo2;
		if ( $mail->Send() ) { 
			header('Location: ../envio-correcto.html');
			//echo "ok";
		} else {
			header('Location: ../envio-error.html');
			//echo "error";
		}
/*	
	} else { // recaptcha
		header('Location: ../envio-error.html');
	}
} else { // recaptcha
	header('Location: ../envio-error.html');
}
*/
?>