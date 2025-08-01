<?php

namespace App\Model\Entity;

use \App\Database\Database;
use \Exception;
use \PDOStatement;

class Testimony
{
    /**
     * ID do depoimento
     * @var int
     */
    public int $id;

    /**
     * Nome do usuário que fez o depoimento
     * @var string
     */
    public string $nome;

    /**
     * Mensagem do depoimento
     * @var string
     */
    public string $mensagem;

    /**
     * Data da publicação do depoimento
     * @var string
     */
    public string $data;

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return bool
     */
    public function cadastrar(): bool
    {
        // Define a data
        $this->data = date('Y-m-d H:i:s');

        // Faz a inserção no banco de dados
        $this->id = (new Database('depoimentos'))->insert([
            'nome' => $this->nome,
            'mensagem' => $this->mensagem,
            'data' => $this->data
        ]);

        // Retorna verdadeiro
        return true;
    }

    public static function getTestimonies(?string $fields = null, ?string $where = null, ?string $order = null, ?string $limit = null): PDOStatement
    {
        return (new Database('depoimentos'))->select($fields, $where, $order, $limit);
    }
}