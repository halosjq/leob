<?php

// use App\Config\Keys;

require './Crypto.php';
require './Key.php';

Key::generate(rand() . '.enc');
