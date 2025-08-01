<?php

global $obRouter;

use \App\Controller\Pages;
use \App\Http\Response;

$obRouter->get('/', [
    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);

$obRouter->get('/sobre', [
    function () {
        return new Response(200, Pages\About::getAbout());
    }
]);

// Rota de depoimentos: Visualizar
$obRouter->get('/depoimentos', [
    function ($request) {
        return new Response(200, Pages\Testimony::getTestimonies($request));
    }
]);

// Rota de depoimentos: Insert
$obRouter->post('/depoimentos', [
    function ($request) {
        return new Response(200, Pages\Testimony::insertTestimony($request));
    }
]);