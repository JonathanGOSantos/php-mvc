<?php

namespace App\Utils;

class View
{
    /**
     * Variáveis padrão da View
     * @var array
     */
    public static array $vars;

    /**
     * Método responsável por definir os dados iniciais da classe
     * @param array $vars
     * @return void
     */
    public static function init(array $vars): void
    {
        self::$vars = $vars;
    }

    /**
     * Método responsável por retornar o conteúdo de uma view
     * @param string $view
     * @return string
     */
    private static function getContentView(string $view): string
    {
        $file = __DIR__.'/../../resources/views/'.$view.'.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    /**
     * Método responsável por retornar o conteúdo renderizado de uma view
     * @param string $view
     * @param ?array $vars (string|int|float)
     * @return string
     */
    public static function render(string $view, ?array $vars = []): string
    {
        $contentView = self::getContentView($view);

        $vars = array_merge(self::$vars, $vars);

        foreach (array_keys($vars) as $key) {
            $contentView = str_replace('{{'.$key.'}}', $vars[$key], $contentView);
        }

        return $contentView;
    }
}