<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>График</title>
    <script src="https://unpkg.com/lightweight-charts@3.2.0/dist/lightweight-charts.standalone.production.js"></script>
</head>
<body>
<h1>График</h1>
<div id="candleChart"></div>

<script>
    const chart = LightweightCharts.createChart(document.getElementById('candleChart'), { width: 800, height: 600 });
    const candlestickSeries = chart.addCandlestickSeries();

    function fetchDataAndRender() {
        fetch('http://localhost:8080/api/data')
            .then(response => response.json())
            .then(data => {
                const formattedData = data.map(item => ({
                    time: new Date(item.time).toLocaleDateString(),
                    open: parseFloat(item.open),
                    high: parseFloat(item.high),
                    low: parseFloat(item.low),
                    close: parseFloat(item.close),
                }));

                candlestickSeries.setData(formattedData);
            })
            .catch(error => {
                console.error('Ошибка при получении данных:', error);
            });
    }

    fetchDataAndRender();

    setInterval(fetchDataAndRender, 1000);
</script>
</body>
</html>

