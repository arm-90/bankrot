<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/src/Exception.php';
	require 'phpmailer/src/PHPMailer.php';

	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->setLanguage('ru', 'phpmailer/language/');
	$mail->IsHTML(true);

	//От кого письмо
	$mail->setFrom('адрес Вашего почтового домена');
	//Кому отправить
	$mail->addAddress('адрес на которую должны приходить письма');
	//Тема письма
	$mail->Subject = 'Письмо с сайта "Инженеркин"';


	//Тело письма
	$body = '<h3>Письмо с сайта "Инженеркин"</h3>';
	
	
		$body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
	
		$body.='<p><strong>Телефон:</strong> '.$_POST['phone'].'</p>';

	
	//Прикрепить файл
	if (!empty($_FILES['image']['tmp_name'])) {
		//путь загрузки файла
		$filePath = __DIR__ . "/files/" . $_FILES['image']['name']; 
		//грузим файл
		if (copy($_FILES['image']['tmp_name'], $filePath)){
			$fileAttach = $filePath;
			$mail->addAttachment($fileAttach);
		}
	}

	$mail->Body = $body;

	//Отправляем
	if (!$mail->send()) {
		$message = 'Ошибка';
	} 

	$response = ['message' => $message];

	header('Content-type: application/json');
	echo json_encode($response);
?>