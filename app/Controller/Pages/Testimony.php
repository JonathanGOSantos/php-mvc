<?php

namespace App\Controller\Pages;

use \App\Http\Request;
use \App\Utils\View;
use \App\Database\Pagination;
use \App\Model\Entity\Testimony as EntityTestimony;

class Testimony extends Page
{
    /**
     * Método responsável por retornar o conteúdo (view) de depoimentos
     * @param Request $request
     * @return string
     */
    public static function getTestimonies(Request $request): string
    {
        $content = View::render('pages/testimonies', [
            'items' => self::getTestimonyItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ]);
        return self::getPage('Depoimentos > Jonathan', $content);
    }

    /**
     * Método responsável por cadastrar um depoimento
     * @param Request $request
     * @return string
     */
    public static function insertTestimony(Request $request): string
    {
        $postVars = $request->getPostVars();

        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();

        return self::getTestimonies($request);
    }

    /**
     * Método responsável por obter a renderização dos itens de depoimentos para a página.
     * @param Request $request
     * @param Pagination|null $obPagination
     * @return string
     */
    private static function getTestimonyItems(Request $request, ?Pagination &$obPagination): string
    {
        $items = '';

        // Total de registros
        $totalDepoimentos = EntityTestimony::getTestimonies(fields: 'COUNT(*) as qtd')->fetchObject()->qtd;
        $queryParams = $request->getQueryParams();
        
        $paginaAtual = $queryParams['pagina'] ?? 1;

        $obPagination = new Pagination($totalDepoimentos, $paginaAtual, 3);

        $results = EntityTestimony::getTestimonies(order: 'id DESC', limit: $obPagination->getLimit());

        while ($obTestimony = $results->fetchObject(EntityTestimony::class)) {
            $items .= View::render('pages/testimony/item', [
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => date('d/m/Y H:i:s', strtotime($obTestimony->data)),
            ]);
        }

        return $items;
    }
}