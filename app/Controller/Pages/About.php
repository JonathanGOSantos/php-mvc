<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class About extends Page
{
    /**
     * Método responsável por retornar o conteúdo (view) da nossa página home
     * @return string
     */
    public static function getAbout(): string
    {
        $obOrganization = new Organization();

        $content = View::render('pages/about', [
            'name' => $obOrganization->name,
            'description' => $obOrganization->description,
            'site' => $obOrganization->site,
        ]);
        return self::getPage('Sobre > Jonathan', $content);
    }

}