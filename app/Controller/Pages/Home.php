<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Home extends Page
{
    /**
     * Método responsável por retornar o conteúdo (view) da nossa página home
     * @return string
     */
    public static function getHome(): string
    {
        $obOrganization = new Organization();

        $content = View::render('pages/home', [
            'name' => $obOrganization->name,
        ]);
        return self::getPage('Home > Jonathan', $content);
    }

}