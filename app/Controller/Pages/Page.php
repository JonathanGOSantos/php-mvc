<?php

namespace App\Controller\Pages;

use \App\Database\Pagination;
use \App\Http\Request;
use \App\Utils\View;

class Page
{

    private static function getHeader(): string
    {
        return View::render('pages/header');
    }

    private static function getFooter(): string
    {
        return View::render('pages/footer');
    }

    /**
     * Método responsável por retornar o conteúdo (view) da nossa página genérica
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function getPage(string $title, string $content): string
    {
        return View::render('pages/page', [
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter()
        ]);
    }

    /**
     * Método responsável por renderizar o layout de paginação
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    public static function getPagination(Request $request, Pagination $obPagination): string
    {
        $pages = $obPagination->getPages();

        if (count($pages) <= 1) return '';
        $links = '';

        $url = $request->getRouter()->getCurrentUrl();
        $queryParams = $request->getQueryParams();
        

        foreach ($pages as $page) {
            $queryParams['pagina'] = $page['page'];

            $link = $url.'?'.http_build_query($queryParams);

            $links .= View::render('pages/pagination/link', [
                'page' => $page['page'],
                'link' => $link,
                'active' => $page['current'] ? 'active' : ''
            ]);
        }

        return View::render('pages/pagination/box', [
            'links' => $links,
        ]);
    }
}