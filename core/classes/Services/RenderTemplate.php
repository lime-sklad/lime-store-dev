<?php 
namespace Core\Classes\Services;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class RenderTemplate
{
    public static $twig;

    public function __construct()
    {
    }

    /**
     * загружает новый шаблон
     */
    public function load($tpl)
    {
        return $this->initTwig()->load($tpl);
    }
    
    /**
     * Иницилизирует твиг
     */
    public function initTwig()
    {
        $loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/core/template/');
        $twig = new Environment($loader);

        return $twig;
    } 

    /**
     * Иницилизирует твиг и выводит шаблон
     */
    public function view($template, $content)
    {
        return $this->initTwig()->render($template, $content);
    }

}