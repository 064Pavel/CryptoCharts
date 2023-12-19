<?php

require_once "../vendor/autoload.php";

$configFile = '../config/database.php';

if (!file_exists($configFile)) {
    exit("Config file not found: $configFile");
}

$config = require_once $configFile;


use App\Database\Database;

print "working...";

new Database($config);