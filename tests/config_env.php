<?php 

require __DIR__ . '/../vendor/autoload.php';
use App\Config\GetConfig;

GetConfig::LoadEnV(__DIR__ . '/../');
GetConfig::Eval();
var_dump($_ENV);