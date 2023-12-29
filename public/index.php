<?php

require '../vendor/autoload.php';

if ($_SERVER['REQUEST_URI'] === '/'){
    require_once 'frontend-ws.php';
}

if ($_SERVER['REQUEST_URI'] === '/backend'){
    require_once 'backend-ws.php';
}

