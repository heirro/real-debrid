<?php

function readableBytes($bytes) {
    $i = floor(log($bytes) / log(1024));
    $sizes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

    return sprintf('%.02F', $bytes / pow(1024, $i)) * 1 . ' ' . $sizes[$i];
}

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.real-debrid.com/rest/1.0/unrestrict/link',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => false,
  CURLOPT_TIMEOUT => '300',
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36',
  CURLOPT_PROXY => '118.99.98.4:4153',
  CURLOPT_HTTPPROXYTUNNEL => '1',
  CURLOPT_PROXYTYPE => CURLPROXY_SOCKS4,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('link' => $_POST['linkdl']),
  CURLOPT_HTTPHEADER => array('Authorization: Bearer YOUR_API_KEY'), // change your_api_key with your api key in real-debrid 
));

$response = curl_exec($curl);
curl_close($curl);
$explode = json_decode($response, true);
$fileName = $explode['filename'];
$linkDownload = $explode['download'];
$fileSize = $explode['filesize'];
$varLink = $_POST['linkdl'];
if(isset($varLink)){ echo "<div class='mt-5 p-3 bg-green-600 text-white'>Download: <a href='".$linkDownload."'>$fileName</a> (".readableBytes($fileSize).")</div>";
}else {header('Refresh: 2, URL=https://rdb.heirro.net/'); echo "Hello bitch...<br/>Come back to index.";}
