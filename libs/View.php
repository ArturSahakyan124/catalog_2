<?php
require_once __DIR__ . '/smarty/libs/Smarty.class.php';
use Smarty\Smarty;

class View
{
    private $smarty;

    public function __construct()
    {
        $this->smarty = new Smarty();

        $this->smarty->setTemplateDir(__DIR__ . '/../views/templates/');
        $this->smarty->setCompileDir(__DIR__ . '/../views/templates_c/');
        $this->smarty->setCacheDir(__DIR__ . '/../views/cache/');
        $this->smarty->setConfigDir(__DIR__ . '/../views/configs/');

        $this->smarty->caching = Smarty::CACHING_OFF;
        $this->smarty->debugging = false;
    }

    public function render($template, $data = [])
    {
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->display($template);
    }

    public function assign($key, $value)
    {
        $this->smarty->assign($key, $value);
    }

    public function fetch($template, $data = [])
    {
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        return $this->smarty->fetch($template);
    }

    public function getTemplateDir()
    {
        return $this->smarty->getTemplateDir()[0];
    }
}
