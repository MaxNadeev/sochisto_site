<?php

$method = $_SERVER['REQUEST_METHOD'];

if ( $method === 'POST' ) {
	$json = file_get_contents('php://input');
	$data = json_decode($json, true);
	
	$name = $data['name'];
	$phone = $data['phone'];

	$message = '
	С формы "Оставьте заявку" на сайте sochisto.ru пришла новая заявка:

	' . $name . '
	' . $phone . '
	';

} else if ( $method === 'GET' ) {
	echo 'GET is not supported';
};



$to  = "lizatravel@icloud.com";
$subject = "Сочисто - новая заявка на форме";


$headers = "From: chisto@sochisto.ru\r\n";
// $headers .= "Reply-To: another-email@87lig687example.com\r\n";
$headers .= "CC: chisto@sochisto.ru\r\n";
$headers .= "BCC: e-max@bk.ru\r\n";
$headers .= "Content-Type: text/plain; charset=utf-8\r\n";

$mail_result = mail($to, $subject, $message, $headers);

if ($mail_result) {
    echo "Email успешно отправлен 📧";
} else {
    echo "Что-то пошло не так при отправке письма 🙁";
};

$conststxt = file_get_contents('consts.txt');
$consts = explode("\n", $conststxt);

$apiToken = substr($consts[0], 0, -1);
$owner = $consts[1];
$dev = $consts[2];

function sendTelegram($chat_id, $message, $apiToken) {
	$data = [
		'chat_id' => $chat_id,
		'text' => $message,
		'parse_mode' => 'HTML'
	];
	$response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?".http_build_query($data));
};

sendTelegram($owner, $message, $apiToken);
sendTelegram($dev, $message, $apiToken);

?>