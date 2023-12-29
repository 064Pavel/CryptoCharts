<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>График</title>
    <script src="https://unpkg.com/lightweight-charts@4.1.0/dist/lightweight-charts.standalone.production.js"></script>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100vh;
        }

        #candleChart {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
<h1>График</h1>
<div id="candleChart"></div>

<script>
    const chart = LightweightCharts.createChart(document.getElementById('candleChart'), { width: 800, height: 600 });
    const candleSeries = chart.addCandlestickSeries();

    const socket = new WebSocket('wss://stream.bybit.com/v5/public/linear');
    const candleDataArray = []; // Здесь будем хранить данные свечей

    socket.addEventListener('open', (event) => {
        const request = {
            op: 'subscribe',
            args: [`kline.1.BTCUSDT`]
        };

        socket.send(JSON.stringify(request));
        console.log('WebSocket opened');
    });

    socket.addEventListener('message', (event) => {
        try {
            const data = JSON.parse(event.data);
            console.log('Received data from the server:', data);

            if (data.topic === 'kline.1.BTCUSDT' && data.data && data.data.length > 0) {
                const newCandleData = {
                    time: data.data[0].start / 1000, // Переводим в секунды
                    open: parseFloat(data.data[0].open),
                    high: parseFloat(data.data[0].high),
                    low: parseFloat(data.data[0].low),
                    close: parseFloat(data.data[0].close),
                };
                console.log(newCandleData)
                // Добавляем новую свечу к массиву данных свечей, только если данные не null
                if (!Object.values(newCandleData).some(val => val === null || isNaN(val))) {
                    candleDataArray.push(newCandleData);


                        // Проверка наличия данных перед обновлением графика
                        if (candleDataArray.length > 0) {
                            // Обновляем данные свечей на графике
                            candleSeries.setData(candleDataArray);
                        }
                }
            }

        } catch (error) {
            console.error('Error parsing JSON:', error);
        }
    });

    socket.addEventListener('error', (event) => {
        console.error('WebSocket error:', event);
    });
</script>
</body>
</html>
