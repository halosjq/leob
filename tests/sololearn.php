<?php 

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.sololearn.com/user/publicToken?subject=placeholderFingerprint');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

print_r(curl_exec($ch));