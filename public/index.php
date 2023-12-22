<?php

require_once "../vendor/autoload.php";

use App\ApiServices\BybitApiService;
use App\Controller\CandleController;
use App\Database\Database;
use App\Database\QueryExecutor;
use App\Model\BybitDataModel;
use App\Router\Router;

$configFile = '../config/database.php';
if (!file_exists($configFile)) {
    header('HTTP/1.0 500 Internal Server Error');
    echo 'Config file not found';
    exit();
}
$config = require_once $configFile;

$database = new Database($config);
$pdo = $database->getPDO();

$router = new Router();

const CATEGORY_LINEAR = 'linear';
const SYMBOL_BTCUSDT = 'BTCUSDT';
const INTERVAL_15 = '120';
const LIMIT = '100';

$bybitApi = new BybitApiService();

$bybitDataModel = new BybitDataModel($bybitApi,CATEGORY_LINEAR, SYMBOL_BTCUSDT, INTERVAL_15, LIMIT);
$candleController = new CandleController($bybitDataModel, new QueryExecutor($pdo));

$router->get('/api/data', function () use ($candleController) {

    $data = $candleController->getData();

    header('Content-Type: application/json');
    echo json_encode($data);

    exit();
});

$router->get('/', function () use ($candleController){

    $candleController->index();

    exit();
});
$router->handle($_SERVER['REQUEST_URI']);
