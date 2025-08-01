<?php

namespace App\Http;

class Response
{
    /**
     * Código do status HTTP
     * @var int
     */
    private int $httpCode;

    /**
     * Cabeçalho do Response
     * @var array
     */
    private array $headers = [];

    /**
     * Tipo de conteúdo retornado
     * @var string
     */
    private string $contentType;

    /**
     * Conteúdo do Response
     * @var mixed
     */
    private mixed $content;

    /**
     * @param int $httpCode
     * @param mixed $content
     * @param string $contentType
     */
    public function __construct(int $httpCode, mixed $content, string $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    /**
     * Método responsável por alterar o content type do response
     * @param string $contentType
     * @return void
     */
    public function setContentType(string $contentType): void
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Método responsável por adicionar um registro no cabeçalho de response
     * @param string $name
     * @param string $value
     * @return void
     */
    public function addHeader(string $name, string $value): void
    {
        $this->headers[$name] = $value;
    }

    /**
     * Método responsável por enviar os headers para o navegador
     * @return void
     */
    private function sendHeaders(): void
    {
        http_response_code($this->httpCode);
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
    }

    /**
     * Método responsável por enviar a resposta para o usuário
     * @return void
     */
    public function sendResponse(): void
    {
        $this->sendHeaders();
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
        }
    }
}