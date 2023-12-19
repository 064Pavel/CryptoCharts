<?php

require_once "../vendor/autoload.php";

use App\ApiServices\BybitApiService;
use App\Database\Database;

$configFile = '../config/database.php';

if (!file_exists($configFile)) {
    exit("Config file not found: $configFile");
}

$config = require_once $configFile;

new Database($config);

const CATEGORY_LINEAR = 'linear';
const SYMBOL_BTCUSDT = 'BTCUSDT';
const INTERVAL_5 = '5';

$bybitApi = new BybitApiService();
$res = $bybitApi->getData(CATEGORY_LINEAR, SYMBOL_BTCUSDT, INTERVAL_5);
dd($res);

