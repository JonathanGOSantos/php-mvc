<?php

namespace App\Database;

class Pagination
{
    /**
     * Número máximo de registros por página
     * @var int
     */
    private int $limit;

    /**
     * Quantidade total de resultados do banco
     * @var int
     */
    private int $results;

    /**
     * Quantidade de Páginas
     * @var int
     */
    private int $pages;

    /**
     * Página atual
     * @var int
     */
    private int $currentPage;

    /**
     * Construtor da classe
     * @param int $results
     * @param int $currentPage
     * @param int $limit
     */
    public function __construct(int $results, int $currentPage = 1, int $limit = 10)
    {
        $this->results = $results;
        $this->limit = $limit;
        $this->currentPage = (is_numeric($currentPage) && $currentPage > 0) ? $currentPage : 1;
        $this->calculate();
    }

    /**
     * Método responsável por calcular a paginação
     * @return void
     */
    private function calculate(): void
    {
        $this->pages = $this->results > 0 ? ceil($this->results / $this->limit) : 1;

        $this->currentPage = $this->currentPage <= $this->pages ? $this->currentPage : $this->pages;
    }

    /**
     * Método responsável por retornar a clausula limit do sql
     * @return string
     */
    public function getLimit(): string
    {
        $offset = ($this->limit * ($this->currentPage - 1));
        return $offset.','.$this->limit;
    }

    public function getPages(): array
    {
        if($this->pages == 1) return [];

        $pages = [];

        for ($i = 1; $i <= $this->pages; $i++) {
            $pages[] = [
                'page' => $i,
                'current' => $this->currentPage == $i,
            ];
        }

        return $pages;
    }
}