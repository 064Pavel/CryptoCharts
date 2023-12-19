<?php

namespace App\Model;

use App\ApiServices\BybitApiService;

class BybitDataModel
{
    private BybitApiService $bybitApiService;

    public function __construct(BybitApiService $bybitApiService)
    {
        $this->bybitApiService = $bybitApiService;
    }

    public function getCandles()
    {
        $res = $this->bybitApiService->getData(CATEGORY_LINEAR, SYMBOL_BTCUSDT, INTERVAL_5);

        return isset($res['result']['list']) && is_array($res['result']['list']) ? $res['result']['list'] : [];
    }
}
