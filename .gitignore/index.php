<?php 
define('BOT_TOKEN', '537600355:AAHXCkeihgkm_a5oXxJUpK1F8m7I9tCiYNk');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');
 
// read incoming info and grab the chatID
$content = file_get_contents("php://input");
$update = json_decode($content, true);
$chatID = $update["message"]["chat"]["id"];

$texto = $update["message"]["text"];
  
if($texto == '/start'){
    $reply = sendMessage();
}
else{
    $reply = sendElse(); 
}

function sendMessage(){
$message = "Esse é o IF funcionando";
return $message;
}

function sendElse(){
$message = "Esse é o Else funcionando";
return $message;
}

$sendto =API_URL."sendmessage?chat_id=".$chatID."&text=".$reply;
file_get_contents($sendto);

?>
