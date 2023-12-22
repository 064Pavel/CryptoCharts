<?php

namespace App\Controller;

use App\Model\BybitDataModel;
use App\Database\QueryExecutor;

class CandleController
{
    private BybitDataModel $dataModel;
    private QueryExecutor $queryExecutor;

    public function __construct(BybitDataModel $dataModel, QueryExecutor $queryExecutor)
    {
        $this->dataModel = $dataModel;
        $this->queryExecutor = $queryExecutor;
    }

    public function processCandles()
    {
        $this->queryExecutor->executeQuery("TRUNCATE TABLE candles");

        $candles = $this->dataModel->getCandles();

        if (!empty($candles)) {
            foreach ($candles as $candle) {
                $candle[0] = $candle[0] / 1000;

                $query = "INSERT INTO candles (time, open, close, low, high, volume, turnover) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $values = [
                    $candle[0],
                    $candle[1],
                    $candle[2],
                    $candle[3],
                    $candle[4],
                    $candle[5],
                    $candle[6],
                ];

                $this->queryExecutor->executeQuery($query, $values);
            }
        } else {
            echo "No data to process.";
        }
    }


    public function getData()
    {
        try {
            $this->processCandles();

            $query = "SELECT * FROM candles";
            $candles = $this->queryExecutor->executeQuery($query);

            return $candles;
        } catch (\Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
    }

    public function index()
    {
        include_once __DIR__ . "/../../public/view.php";
    }

}
