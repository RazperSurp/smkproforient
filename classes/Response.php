<?php

class Response {
    const FORMAT_JSON = 1;
    const FORMAT_XML = 2;
    const FORMAT_HTML = 3;
    const FORMAT_RAW = 4;
    
    private $_rawData;
    
    public $format;
    public $formattedData;

    private $_headers;
    private $_cookies;

    public $code;

    public function __construct($returningData) {
        $this->_headers = [];
        $this->_cookies = [];
        $this->_rawData = $returningData;

        $this->_setFormat();
    }

    private function _setFormat() {
        if (Application::instance()->request->isApi) $this->format = self::FORMAT_JSON;
        else $this->format = self::FORMAT_HTML;
    }

    private function _formatData() {
        switch ($this->format) {
            case self::FORMAT_JSON:
                $this->_formatAsJson();
                break;
            case self::FORMAT_XML:
                $this->_formatAsXml();
                break;
            case self::FORMAT_HTML:
                $this->_formatAsHtml();
                break;
            case self::FORMAT_RAW:
                $this->_formatAsRaw();
                break;
        }
    }

    private function _formatAsJson() {
        $this->setContentType('application/json');

        try {
            $this->formattedData = helpers\Json::encode($this->_rawData);
        } catch (\Throwable $e) {
            $this->formattedData = json_encode(['results' => $this->_rawData]);
        }
    }

    private function _formatAsXml() {
        $this->setContentType('text/xml');

        try {
            $this->formattedData = xmlrpc_encode($this->_rawData);
        } catch (\Throwable $e) {
            $this->formattedData = xmlrpc_encode(['results' => $this->_rawData]);
        }
    }

    private function _formatAsHtml() {
        $this->setContentType('text/html');
        $this->formattedData = $this->_rawData;
    }

    private function _formatAsRaw() {
        $this->setContentType('text/plain');
        $this->formattedData = $this->_rawData;
    }

    /**
     * Установка заголовка **Content-Type**. Синтаксический сахар.
     *
     * @param string $type - тип контента
     * @param string $charset - кодировка
     * 
     * @return void
     */
    public function setContentType($type, $charset = 'UTF-8') {
        $this->setHeader(['name' => 'Content-Type', 'value' => 'Content-Type: '. $type .'; charset='. $charset]);
    }

    /**
     * Отправка заголовка пользовтаелю
     *
     * Передавать аргумент **$header** в метод **Response::setHeader()** необходимо в формате, указанном ниже.
     * Разберём структуру на примере следующего заголовка: **Content-Disposition: attachment; filename="downloaded.pdf"**
     * ```
     *  $header = [ // заголовок 
     *      [ // часть заголовка первая (напр. **Content-Disposition: attachment**)
     *          'name' => 'Content-Disposition',
     *          'value' => 'attachment'
     *      ], [ // часть заголовка первая (напр. **filename="downloaded.pdf"**)
     *          'name' => 'filename',
     *          'value' => '"downloaded.pdf"'
     *      ]
     *  ]
     * ```
     * 
     * В случае, если заголовок включает в себя всего одну часть, достаточно будет передать ассоциативный массив
     * всего с одним уровнем вложенности. Разберём на примере **Cache-Control: no-cache, must-revalidate**:
     * 
     * ```
     *  $header = [ // заголовок
     *      'name' => 'Cache-Control',
     *      'value' => 'no-cache, must-revalidate'
     *  ]
     * ```
     * 
     * @param array $header - итерируемый массив, включающий в себя ассоциативные массивы с информацией по одному заголовку.
     * 
     * @return void
     */
    public function setHeader($header) {
        $stringifiedHeader = '';
        if (!array_is_list($header)) $stringifiedHeader = $header['name'] .': '. $header['value'];
        else {
            $stringifiedHeader = [];
            foreach ($header as $part) $stringifiedHeader[] = $header['name'] .': '. $header['value'];

            $stringifiedHeader = implode('; ', $stringifiedHeader);
        }

        $this->_headers[] = $stringifiedHeader;
    }

    /**
     * Применение всех подготовленных заголовков.
     *
     * @return void
     */
    public function _applyHeaders() {
        foreach ($this->_headers as $header) header($header);
    }

    public function resolve() {
        $this->_formatData();
        $this->_applyHeaders();

        if (Application::instance()->request->isApi) print_r($this->formattedData);

        return $this->formattedData;
    }
}

?>