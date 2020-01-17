<?php

require 'vendor/autoload.php';

$api = new BitStorage\BitStorageApi();
$ticker = $api->ticker();
print_r($ticker);
