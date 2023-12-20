<?php

namespace App\Model;

use App\ApiServices\BybitApiService;
class BybitDataModel
{
    private BybitApiService $bybitApiService;
    private string $category;
    private string $symbol;
    private string $interval;

    public function __construct(BybitApiService $bybitApiService, string $category, string $symbol, string $interval)
    {
        $this->bybitApiService = $bybitApiService;
        $this->category = $category;
        $this->symbol = $symbol;
        $this->interval = $interval;
    }

    public function getCandles()
    {
        $res = $this->bybitApiService->getData($this->category, $this->symbol, $this->interval);

        return isset($res['result']['list']) && is_array($res['result']['list']) ? $res['result']['list'] : [];
    }
}
