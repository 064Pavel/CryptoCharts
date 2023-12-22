<?php

namespace App\Model;

use App\ApiServices\BybitApiService;
class BybitDataModel
{
    private BybitApiService $bybitApiService;
    private string $category;
    private string $symbol;
    private string $interval;
    private string $limit;

    public function __construct(BybitApiService $bybitApiService, string $category, string $symbol, string $interval, string $limit)
    {
        $this->bybitApiService = $bybitApiService;
        $this->category = $category;
        $this->symbol = $symbol;
        $this->interval = $interval;
        $this->limit = $limit;
    }

    public function getCandles()
    {
        $res = $this->bybitApiService->getData($this->category, $this->symbol, $this->interval, $this->limit);

        return isset($res['result']['list']) && is_array($res['result']['list']) ? $res['result']['list'] : [];
    }
}
