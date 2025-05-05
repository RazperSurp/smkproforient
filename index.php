<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once('classes/exceptions/BaseException.php');
    require_once('classes/Application.php');
    require_once('classes/db/Record.php');
    require_once('classes/models/Model.php');

    new Application();
    new Api();

    Application::instance()->request->process();

    
?>