<?php
http_response_code($this->exception->getCode());

return [
    'code' => $this->exception->getCode(),
    'message' => $this->exception->getMessage()
];
?>