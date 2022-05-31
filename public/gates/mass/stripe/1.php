<?php
ini_set('display_errors', 1);
require '../init_gate.php';
$content = file_get_contents("php://input");
$update = json_decode($content, true);
use App\Gate\Responses as Res;

$arr = [
    ' Your card was declined',
    ' security code is incorrect',
    ' "valid": true',
    ' card_error_authentication_required',
    ' stolen_card',
    ' "code": "invalid_token"'
];

$re = $arr[array_rand($arr)];

Res::SetParams($re, $re, null, null, $re);
$res = Res::Stripe();
echo json_encode([
    'cc' => $update['card'],
    'user' => $update['user'],
    'gate' => $update['gate'],
    'res' => $res
]);