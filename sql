CREATE TABLE candles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    time BIGINT,
    open DECIMAL(10, 5),
    close DECIMAL(10, 5),
    low DECIMAL(10, 5),
    high DECIMAL(10, 5),
    volume DECIMAL(15, 5),
    turnover DECIMAL(20, 5)
);
