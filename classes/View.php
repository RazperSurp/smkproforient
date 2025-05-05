<?php 

class View {
    public $name;

    private $_theme;
    private $_app;

    private $_jsFiles;
    private $_cssFiles;

    public $exception;

    private $_data;

    public function __construct($name = null) {
        $this->_app = Application::instance();

        $this->_theme = 'theme/'. $this->_app->getParam('THEME') .'/'; 
        $this->name = $this->_app->getParam('APPNAME') .' | '. ($name ?? $this->_app->request->script);

        $this->_jsFiles = ['before' => $this->_app->getParam('AUTOLOAD')['JS'], 'after' => []];
        $this->_cssFiles = $this->_app->getParam('AUTOLOAD')['CSS'];
    }

    public function render() {
        if (isset($this->exception)) {
            if ($this->_app->request->isApi) {
                $rawData = require $this->_theme .'service/exception/api.php';
                return $rawData;
            } else {
                require $this->_theme .'layout/head.php';
                require $this->_theme .'layout/body.php';
            }
        }

        if (is_dir($this->_theme .'views/'. $this->_app->request->router) && is_file($this->_theme .'views/'. $this->_app->request->router .'/'. $this->_app->request->script .'.php')) {
            require $this->_theme .'layout/head.php';
            require $this->_theme .'layout/body.php';
        } else throw new E404('Такой страницы не существует');
    }
    


    public function useJs($path, $useBeforeBody = false) {
        $this->_jsFiles[($useBeforeBody ? 'before' : 'after')][] = $path;
    }
    
    public function useCss($path) {
        $this->_cssFiles[] = $path;
    }
}

?>