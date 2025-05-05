<?php

require_once('classes/exceptions/ExceptionInterface.php');
abstract class BaseException extends \Exception implements ExceptionInterface {
    protected $message = 'Unknown exception';
    private $string;
    protected $code = 0;
    protected string $file;
    protected int $line;
    private $trace;

    public function __construct($message = null, $code = 0) {
        $this->message = $message ?? $this->message;
        parent::__construct($this->message, $this->code);
    }
    
    public function __toString() { 
        return get_class($this) ." '{$this->message}' in {$this->file}({$this->line})\n" . "{$this->getTraceAsString()}";
    }
}

?>