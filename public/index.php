<?php

require_once "../vendor/autoload.php";

use App\ApiServices\BybitApiService;
use App\Controller\CandleController;
use App\Model\BybitDataModel;
use App\Database\Database;
use App\Database\QueryExecutor;

$configFile = '../config/database.php';

if (!file_exists($configFile)) {
    exit("Config file not found: $configFile");
}

$config = require_once $configFile;

$database = new Database($config);
$pdo = $database->getPDO();

const CATEGORY_LINEAR = 'linear';
const SYMBOL_BTCUSDT = 'BTCUSDT';
const INTERVAL_5 = '5';

$bybitApi = new BybitApiService();
$dataModel = new BybitDataModel($bybitApi);
$queryExecutor = new QueryExecutor($pdo);

$candleController = new CandleController($dataModel, $queryExecutor);
$candleController->processCandles();



