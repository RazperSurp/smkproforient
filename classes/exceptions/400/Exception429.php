<?php

class E429 extends BaseException {
    protected $code = 429;
    protected $message = 'Вы отправляете запросы слишком часто';
}

?>