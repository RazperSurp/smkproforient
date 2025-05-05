<?php

class Request {
    const PLAIN_HEADERS = ['User-Agent'];

    public $headers;
    public $cookies;
    
    public $router;
    public $script;

    public $isApi;
    public $body;

    private $_rawData;

    private $_view;

    /**
     * Создание нового экземпляра класса.
     * 
     * В процессе создания экземпляра обрабатываются все служебные данные из суперглобальных переменных.
     */
    public function __construct() {
        $this->_parseService();
        $this->_parseXHR();
    }

    /**
     * Парсинг служебных переменных и перенос данных из $_COOKIE
     *
     * @return void
     */
    private function _parseService() {
        foreach (getallheaders() as $header => $value) {
            if (in_array($header, self::PLAIN_HEADERS)) $this->headers[$header] = [$value];
            else {
                $explodedValue = explode(';', $value);
                if (count($explodedValue) > 1) {
                    $this->headers[$header] = [];
                    foreach ($explodedValue as $subvalue) $this->headers[$header][] = trim($subvalue);
                } else $this->headers[$header] = trim($value);
            }
        }

        $this->cookies = $_COOKIE;
    }

    /**
     * Получение тела запроса
     *
     * @return void
     */
    private function _parseXHR() {
        $this->router = $_GET['router'];
        $this->script = $_GET['script'];

        $this->isApi = (isset($_GET['api']) && $_GET['api'] == '1');

        $this->_cleanup();

        $this->body = [
            'GET' => $_GET, 
            'POST' => $_POST, 
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') $this->_validateCsrfToken();
    }

    /**
     * Удаление гет-параметров полученных с помощью правил перенаправления в **.htaccess**
     *
     * @return void
     */
    private function _cleanup() {
        unset($_GET['router']);
        unset($_GET['script']);
        unset($_GET['api']);
    }

    /**
     * Рендер нужной страницы, либо перенаправление запроса на **Api**.
     *
     * @return void
     */
    public function process() {
        $app = Application::instance();
        $this->_view = new View();

        try {
            if ($this->isApi) $this->_rawData = Api::instance()->call();
        } catch (Exception $e) {
            $this->_view->exception = $e;
        }

        $app->response = new Response($this->_rawData);
        $app->response->resolve();
        
        if (!$this->isApi) $this->_rawData = $this->_view->render();
    }

    /**
     * Проверка переданного CSRF-токена
     */
    private function _validateCsrfToken() {
        $app = Application::instance();

        if (!$app->getParam('CSRF')['enabled'] || (isset($this->body['POST'][$app->getParam('CSRF')['fieldName']]) && $app->csrf() === $this->body['POST'][$app->getParam('CSRF')['fieldName']])) return true;
        else throw new E403('CSRF-валидация не пройдена');
    }
}

?>