<?php

class E404 extends BaseException {
    protected $code = 404;
    protected $message = 'Запрошенный ресурс не найден';
}

?>