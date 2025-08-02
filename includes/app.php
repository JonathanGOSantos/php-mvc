<?php
require __DIR__ . '/../vendor/autoload.php';

use \App\Database\Database;
use \App\Environment\Environment;
use \App\Utils\View;
use \App\Http\Middleware\Queue as MiddlewareQueue;

// Carrega variáveis de ambiente
Environment::load(__DIR__ . '/../');

// Define as configurações de banco de dados
Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT')
);

// Define a constante de URL
define('URL', getenv('URL'));

// Inicia as variáveis padrão das Views
View::init(['URL' => URL]);

MiddlewareQueue::setMap([
    'maintenance' => \App\Http\Middleware\Maintenance::class,
]);

MiddlewareQueue::setDefault([
    'maintenance'
]);