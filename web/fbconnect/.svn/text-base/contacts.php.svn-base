<?php

$ch = curl_init();
//$google_cookie=tempnam("./","XX");
$sendData = array('Email' => 'kuldeepkapade', 'Passwd' => 'iwannafly', 'service' => 'reader', 'source' => 'redanyway', 'continue' => 'http://www.google.com/');
curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/accounts/ClientLogin');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt ($ch, CURLOPT_COOKIEJAR, $google_cookie);
//curl_setopt ($ch, CURLOPT_COOKIEFILE, $google_cookie);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $sendData);
curl_setopt($ch, CURLOPT_HEADER, 0);
$result = curl_exec($ch);
if($result==false)
echo curl_error($ch);
else {
curl_close($ch);
echo "DATA: ". $result ."\n\n\n";
$data = explode("LSID=", $result);
$sid = substr($data[0], 4);
echo "****SID: ".$sid ."\n\n\n";
$data2 = explode("Auth=", $data[1]);
$lsid = $data2[0];
echo "*****LSID: ".$lsid ."\n\n\n";
$auth = $data2[1];
echo "*****Auth: ".$auth ."\n\n\n";
}

$ch = curl_init();

//$header[0] = 'Content-length: '. strlen($sendData);
$header[0] = 'Authorization: GoogleLogin auth='. $auth;
curl_setopt($ch, CURLOPT_URL, 'http://www.google.com/m8/feeds/contacts/kuldeepkapade%40gmail.com/full');
curl_setopt($ch, CURLOPT_GET, 1);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$result = curl_exec($ch);
if($result==false)
echo curl_error($ch);
else {
curl_close($ch);
print($result);
}



?>
