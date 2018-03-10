<?php 
$message = file_get_contents("php://input");
$result = json_decode($message,true);
$token = "557647184:AAHJ6VVhs-GUHN0TgJ08TywzW71CJU_4xmw";
$chat_id = ["message"]["chat"]["id"];

if($result["message"]["text"] == '/start'){
	$array1=array('chat_id'=>$chat_id);
	$array2=array('photo'=>'/storage/ssd2/272/4886272/public_html/canais-digitais.jpg'); //path
	$array3 = {caption: "legenda"};
	$ch = curl_init();       
	curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot557647184:AAHJ6VVhs-GUHN0TgJ08TywzW71CJU_4xmw/sendPhoto");
	curl_custom_postfields($ch,$array1,$array2, $array3);//above custom function
	$output=curl_exec($ch);
	close($ch);
}
else{
	$sendto ="https://api.telegram.org/bot557647184:AAHJ6VVhs-GUHN0TgJ08TywzW71CJU_4xmw/sendmessage?chat_id=".$chat_id."&text=Para enviar a imagem digite /start";
	file_get_contents($sendto);
}

function curl_custom_postfields($ch, array $assoc = array(), array $files = array()) {
		// invalid characters for "name" and "filename"
        static $disallow = array("\0", "\"", "\r", "\n");

        // build normal parameters
        foreach ($assoc as $k => $v) {
		$k = str_replace($disallow, "_", $k);
        $body[] = implode("\r\n", array(
                  "Content-Disposition: form-data; name=\"{$k}\"",
                  "",
                  filter_var($v),
              ));
          }
          // build file parameters
          foreach ($files as $k => $v) {
              switch (true) {
                  case false === $v = realpath(filter_var($v)):
                  case !is_file($v):
                  case !is_readable($v):
                      continue; // or return false, throw new InvalidArgumentException
              }
              $data = file_get_contents($v);
              $v = call_user_func("end", explode(DIRECTORY_SEPARATOR, $v));
              $k = str_replace($disallow, "_", $k);
              $v = str_replace($disallow, "_", $v);
              $body[] = implode("\r\n", array(
                  "Content-Disposition: form-data; name=\"{$k}\"; filename=\"{$v}\"",
                  "Content-Type: multipart/form-data",
                  "",
                  $data,
              ));
          }
          // generate safe boundary
          do {
              $boundary = "---------------------" . md5(mt_rand() . microtime());
          } while (preg_grep("/{$boundary}/", $body));

          // add boundary for each parameters
          array_walk($body, function (&$part) use ($boundary) {
              $part = "--{$boundary}\r\n{$part}";
          });

          // add final boundary
          $body[] = "--{$boundary}--";
          $body[] = "";

          // set options
          return @curl_setopt_array($ch, array(
              CURLOPT_POST       => true,
              CURLOPT_POSTFIELDS => implode("\r\n", $body),
              CURLOPT_HTTPHEADER => array(
                  "Expect: 100-continue",
                  "Content-Type: multipart/form-data; boundary={$boundary}", // change Content-Type
              ),
          ));
}
?>