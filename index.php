<?php
require __DIR__.'/includes/app.php';

use App\Http\Router;

// Inicia o roteador (Router)
$obRouter = new Router(URL);
// Inclui as rotas de páginas
include __DIR__.'/routes/pages.php';
// Envia a resposta da rota
$obRouter->run()->sendResponse();