<?php

class Application { 
    const DIR_CONFIG = 'config';
    const DIR_CLASSES = 'classes';
    
    public $db;
    public $request;
    public $response;

    private $_params;
    private $_csrf;

    /**
     * Создание нового экзепляра класса Application.
     * 
     * Определяем будущую структуру, подключаем классы и базу данных,
     * иначе говоря - проводим инициализацию приложения.
     */
    public function __construct() {
        $this->_configure();
        $this->_setCsrf();
        $this->_require();
        $this->_database();
        $this->_store();
        $this->_parse();
    }

    /**
     * Вызов require_once() для всех файлов в папке /config
     * 
     * Рекурсивно метод проходится по всем поддиректориям папки и подключает все
     * файлы, находящиеся внутри них.
     *
     * @return void
     */
    private function _configure($subdir = '') {
        $this->_params = [];

        foreach (scandir(self::DIR_CONFIG. $subdir) as $path) {
            if ($path != '.' && $path != '..') {
                $fullPath = self::DIR_CONFIG. $subdir . '/'. $path;
                if (is_dir($fullPath)) $this->_require($subdir .'/'. $path);
                else $this->_params = array_merge(require_once($fullPath), $this->_params);
            }
        }
    }

    /**
     * Определение структуры приложения
     * 
     * Создаётся экземпляр класса **Request**.
     *
     * @return void
     */
    private function _parse() {
        $this->request = new Request();
    }

    /**
     * Вызов require_once() для всех классов в папке /classes
     * 
     * Рекурсивно метод проходится по всем поддиректориям папки и подключает все
     * файлы, находящиеся внутри них.
     *
     * @return void
     */
    private function _require($subdir = '') {
        foreach (scandir(self::DIR_CLASSES. $subdir) as $path) {
            if ($path != '.' && $path != '..') {
                $fullPath = self::DIR_CLASSES. $subdir . '/'. $path;
                if (is_dir($fullPath)) $this->_require($subdir .'/'. $path);
                else require_once($fullPath);
            }
        }
    }

    /**
     * Сохраняем подключение к базе даных в **Application::db**
     *
     * @return void
     */
    private function _database() {
        $this->db = db\Connection::connect($this->_params['DB']);
        unset($this->_params['DB']);
    }

    /**
     * Сохранение экземпляра класса в **$_SESSION**
     * 
     * Подключаемся к БД, создаём сессию, в сессию помещаем экземпляр класса **Application**.
     *
     * @return void
     */
    private function _store() {
        $_SESSION['instance'] = $this;
    }

    /**
     * Получение экземпляра класса приложения
     * 
     * С помощью **Application::_store()** сохраняем экземпляр приложения в суперглобальную переменную
     * **$_SESSION**. Затем, с помощью данного метода получаем возможность удобно получать приложение
     * со всеми сохраненными данными в абсолютно любом блоке кода.
     *
     * @return Application|void
     */
    static public function instance() {
        if (isset($_SESSION['instance'])) return $_SESSION['instance'];
        else throw new Exception('Application didn\'t boot up!');
    }

    /**
     * Получение сохраненных параметров
     *
     * @param string $name - название параметра
     * @return mixed|null
     */
    public function getParam($name) {
        if (isset($this->_params[$name])) return $this->_params[$name];
        else return null;
    }

    private function _setCsrf() {
        $this->_csrf = password_hash($this->getParam('CSRF')['privateKey'], PASSWORD_DEFAULT);
    }

    public function csrf() {
        if (!isset($this->_csrf)) return false;
        else return $this->_csrf;
    }
}