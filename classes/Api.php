<?php

class Api extends Application  {
    private $_app;

    public function __construct() {
        $this->_app = Application::instance();
        foreach ($this->_app as $property => $value) $this->$property = $value;

        $this->store();
    }  

    /**
     * Сохранение экземпляра класса в **$_SESSION**
     * 
     * В ранее созданную сессию помещаем экземпляр класса **Api**, буквально тем же образом, как и в
     * **Application::store()**
     *
     * @return void
     */
    private function store() {
        $_SESSION['api'] = $this;
    }

    /**
     * Получение экземпляра класса приложения
     * 
     * см. **Application::instance()**
     *
     * @return Api|void
     */
    static public function instance() {
        if (isset($_SESSION['api'])) return $_SESSION['api'];
        else throw new Exception('Api didn\'t boot up!');
    }

    /**
     * Вызов метода.
     * 
     * Название класса хранится в свойстве **Request::router**. Название метода - в **Request::script**.
     *
     * @return void
     */
    public function call() {
        $classname = '\models\\'. $this->_app->request->router;
        $method = $this->_app->request->script;

        if (class_exists($classname)) {
            if (method_exists($classname, $method)) {
                return $classname::$method();
            } else throw new E404('Заданного метода не существует.');
        } else throw new E404('Заданного интерфейса не существует.');
    }
}