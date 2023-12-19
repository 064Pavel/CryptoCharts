<?php

namespace App\ApiServices;
class BybitApiService
{
    private string $baseUrl = 'https://api-testnet.bybit.com/v5/market/';

    public function getData(string $category, string $symbol, string $interval)
    {
        $url = $this->baseUrl . 'kline';

        $params = [
            'category' => $category,
            'symbol'   => $symbol,
            'interval' => $interval,
        ];

        return $this->buildRequest($url, $params);
    }

    private function buildRequest(string $url, array $params)
    {
        $curl = curl_init();

        $url .= '?' . http_build_query($params);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }
}