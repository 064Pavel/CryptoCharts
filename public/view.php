<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>График</title>
    <script src="https://unpkg.com/lightweight-charts@3.2.0/dist/lightweight-charts.standalone.production.js"></script>
</head>
<body>
<h1>График</h1>
<div id="candleChart"></div>

<script>
    const chart = LightweightCharts.createChart(document.getElementById('candleChart'), { width: 800, height: 600 });
    const candleSeries = chart.addCandlestickSeries();

    function createChart(data) {
        if (data && data.length > 0) {
            try {
                candleSeries.setData(data);
            } catch (error) {
                console.error('Ошибка при установке данных на график:', error);
            }
        } else {
            console.error('Ошибка при установке данных на график: Пустой массив данных или данные равны null', data);
        }
    }

    function fetchDataAndRender() {
        fetch('http://localhost/api/data')
            .then(response => response.json())
            .then(data => {
                if (data && Array.isArray(data) && data.length > 0) {
                    const formattedData = data.map(item => {
                        const parsedItem = {
                            time: item.time,
                            open: parseFloat(item.open),
                            high: parseFloat(item.high),
                            low: parseFloat(item.low),
                            close: parseFloat(item.close),
                        };

                        Object.entries(parsedItem).forEach(([key, value]) => {
                            if (isNaN(value)) {
                                console.error(`Ошибка: Значение ${key} (${value}) не является числом.`);
                            }
                        });

                        return parsedItem;
                    });

                    formattedData.sort((a, b) => a.time - b.time);

                    try {
                        candleSeries.setData([]);
                        createChart(formattedData);
                        // console.log('Отформатированные данные:', formattedData);
                    } catch (error) {
                        console.error('Ошибка при обработке данных для графика:', error);
                    }
                } else {
                    console.error('Ошибка при получении данных: Неверная структура данных', data);
                }
            })
            .catch(error => {
                console.error('Ошибка при получении данных:', error);
            });
    }

    document.addEventListener('DOMContentLoaded', () => {
        fetchDataAndRender();
        setInterval(fetchDataAndRender, 1000 * 60);
    });
</script>
</body>
</html>
