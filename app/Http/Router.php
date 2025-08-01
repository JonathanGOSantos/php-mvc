<?php

namespace App\Http;
use \Closure;
use \Exception;
use \ReflectionFunction;
class Router
{
    /**
     * URL completa do projeto (raiz)
     * @var string
     */
    private string $url;

    /**
     * Prefixo de todas as rotas
     * @var string
     */
    private string $prefix;

    /**
     * Índice de rotas
     * @var array
     */
    private array $routes;

    /**
     * Instancia de request
     * @var Request
     */
    private Request $request;

    /**
     * Método responsável por iniciar a classe
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->request = new Request($this);
        $this->url = $url;
        $this->setPrefix();
    }

    /**
     * Método responsável por definir o prefixo das rotas
     * @return void
     */
    private function setPrefix(): void
    {
        $parseUrl = parse_url($this->url);
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     * Método responsável por adicionar uma rota na classe
     * @param string $method
     * @param string $route
     * @param array|null $params
     * @return void
     */
    private function addRoute(string $method, string $route, ?array $params): void
    {
        foreach($params as $key => $value) {
            if($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
            }
        }
        // Variáveis da rota
        $params['variables'] = [];

        // Padrão de validação das variáveis das rotas
        $patternVariable = '/{(.*?)}/';
        if(preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        // Padrão de validação da URL
        $patternRoute = '/^'.str_replace('/', '\/', $route).'$/';

        $this->routes[$patternRoute][$method] = $params;
    }

    /**
     * Método responsável por definir uma rota de GET
     * @param string $route
     * @param array $params
     * @return void
     */
    public function get(string $route, array $params): void
    {
        $this->addRoute('GET', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de POST
     * @param string $route
     * @param array $params
     * @return void
     */
    public function post(string $route, array $params): void
    {
        $this->addRoute('POST', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de PUT
     * @param string $route
     * @param array $params
     * @return void
     */
    public function put(string $route, array $params): void
    {
        $this->addRoute('PUT', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de DELETE
     * @param string $route
     * @param array $params
     * @return void
     */
    public function delete(string $route, array $params): void
    {
        $this->addRoute('DELETE', $route, $params);
    }


    /**
     * Método responsável por retornar a URI desconsiderando o prefixo
     * @return string
     */
    private function getUri(): string
    {
        $uri = $this->request->getUri();
        // Fatia a URI com o prefixo
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
        return end($xUri);
    }

    /**
     * Método responsável por retornar os dados da rota atual
     * @return array
     * @throws Exception
     */
    private function getRoute(): array
    {
        $uri = $this->getUri();
        $httpMethod = $this->request->getHttpMethod();
        foreach ($this->routes as $patternRoute=>$methods) {
            if (preg_match($patternRoute, $uri, $matches)) {
                if (!$methods[$httpMethod]) {
                    throw new Exception('Método não permitido', 405);
                }
                unset($matches[0]);

                // Variáveis processadas
                $keys = $methods[$httpMethod]['variables'];
                $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                $methods[$httpMethod]['variables']['request'] = $this->request;


                return $methods[$httpMethod];
            }
        }
        throw new Exception('URL não encontrada', 404);
    }
    /**
     * Método responsável por executar a rota atual
     * @return Response
     */
    public function run(): Response
    {
        try {
            $route = $this->getRoute();

            if (!isset($route['controller'])) {
                throw new Exception('A URL não pode ser processada', 500);
            }

            $args = [];

            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }

            return call_user_func_array($route['controller'], $args);
        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Método responsável por retornar a URL atual
     * @return string
     */
    public function getCurrentUrl(): string
    {
        return $this->url . $this->getUri();
    }
}