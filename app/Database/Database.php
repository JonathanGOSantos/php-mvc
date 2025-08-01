<?php

namespace App\Database;

use Exception;
use \PDO;
use \PDOException;
use \PDOStatement;

class Database
{
    /**
     * Host de conexão com o banco de dados
     * @var string
     */
    private static string $host;

    /**
     * Porta de acesso ao banco
     * @var integer
     */
    private static int $port;

    /**
     * Nome do banco de dados
     * @var string
     */
    private static string $name;

    /**
     * Usuário do banco
     * @var string
     */
    private static string $user;

    /**
     * Senha de acesso ao banco de dados
     * @var string
     */
    private static string $pass;

    /**
     * Tabela a ser manipulada
     * @var ?string
     */
    private ?string $table;

    /**
     * Instância de conexão com banco de dados
     * @var PDO
     */
    private PDO $connection;

    public static function config(string $host, string $name, string $user, string $pass, int $port): void
    {
        self::$host = $host;
        self::$name = $name;
        self::$user = $user;
        self::$pass = $pass;
        self::$port = $port;
    }

    public function __construct(?string $table = null)
    {
        $this->table = $table;
        $this->setConnection();
    }

    /**
     * Método responsável por criar uma conexão com o banco de dados
     * @return void
     */
    private function setConnection(): void
    {
        try {
            $conn = 'mysql:host=' . self::$host . ';dbname=' . self::$name . ';port=' . self::$port . ';charset=utf8mb4';
            $this->connection = new PDO($conn, self::$user, self::$pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }


    /**
     * Método responsável por executar queries dentro do banco de dados
     * @param string $query
     * @param ?array $params
     * @return PDOStatement
     */
    public function execute(string $query, ?array $params = []): PDOStatement
    {
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    /**
     * Método responsável por fazer a inserção de dados em uma tabela
     * @param array $data [ field => value ]
     * @return int ID do item inserido
     * @throws Exception
     */
    public function insert(array $data): int
    {
        $fields = array_keys($data);
        $binds = array_pad([], count($fields), '?');

        // Monta a query
        if (!isset($this->table) || $this->table == null)
            throw new Exception('Não há uma tabela definida para a realização do insert.');

        $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ')';

        // Executa o insert
        $this->execute($query, array_values($data));

        return $this->connection->lastInsertId();
    }

    /**
     * @param string|null $fields
     * @param string|null $where
     * @param string|null $order
     * @param string|null $limit
     * @return PDOStatement ->fetchAll(PDO::FETCH_CLASS, Class)
     */
    public function select(?string $fields = null, ?string $where = null, ?string $order = null, ?string $limit = null): PDOStatement
    {
        $fields = strlen($fields) ? $fields : '*';
        $where = strlen($where) ? 'WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';

        $query = 'SELECT ' . $fields . ' from ' . $this->table . ' ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }

    /**
     * Método responsável por executar atualização de algum item no banco de dados
     * @param string $where
     * @param array $data
     * @return boolean
     */
    public function update(string $where, array $data): bool
    {
        $fields = array_keys($data);

        $query = 'UPDATE ' . $this->table . ' SET ' . implode('=?,', $fields) . '=? WHERE ' . $where;
        $this->execute($query, array_values($data));

        return true;
    }

    /**
     * Método responsável por excluir dados do banco
     * @param string $where
     * @return bool
     */
    public function delete(string $where): bool
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $where;
        $this->execute($query);
        return true;
    }

    /**
     * Faz a contagem de elementos em alguma tabela
     * @param string|null $field
     * @return PDOStatement
     */
    public function count(?string $field = '*'): PDOStatement
    {
        $query = 'SELECT COUNT(' . $field . ') as rows from ' . $this->table;

        return $this->execute($query);
    }

}