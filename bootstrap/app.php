<?php

$dotenv = new \Dotenv\Dotenv(__DIR__.'//../');
$dotenv->load();
$dotenv->required([
    'DB_HOST',
    'DB_DATABASE',
    'DB_USERNAME',
    'DB_PASSWORD',
    'DB_DRIVER'
]);
