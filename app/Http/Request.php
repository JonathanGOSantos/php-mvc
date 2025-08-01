<?php

namespace App\Http;

class Request
{
    /**
     * Instância de Router
     * @var Router
     */
    private Router $router;

    /**
     * Método HTTP da requisição
     * @var string
     */
   private string $httpMethod;

    /**
     * URI da página
     * @var string
     */
   private string $uri;

    /**
     * Parâmetros da URL ($_GET)
     * @var array
     */
   private array $queryParams;

    /**
     * Variáveis recebidas no POST da página ($_POST)
     * @var array
     */
   private array $postVars;

    /**
     * Cabeçalho da requisição
     * @var array
     */
   private array $headers;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
    }

    /**
     * Método responsável por definir a URI
     * @return void
     */
    private function setUri(): void
    {
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
        $xUri = explode('?', $this->uri);
        $this->uri = $xUri[0] ?? '';
    }

    /**
     * Método responsável por retornar a instância de Router
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * Método responsável por retornar o método HTTP da requisição
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * Método responsável por retornar o URI da requisição
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Método responsável por retornar os headers da requisição
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Método responsável por retornar os parâmetros da URL da requisição
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * Méto do responsável retornar as variáveis POST da requisição
     * @return array
     */
    public function getPostVars(): array
    {
        return $this->postVars;
    }
}