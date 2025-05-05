<?php

namespace helpers;

use Application;

class Form {
    private $_fields;
    private $_name;
    private $_app;
    private $_notWrapFields = false;

    public function __construct($name, array $struct, array $attributes = [], $url = null) {
        $this->_app = Application::instance();
        if (isset($attributes['notWrapFields']) && $attributes['notWrapFields']) $this->_notWrapFields = true;

        self::open(($url ?? '/api/'. $name .'/update'), $attributes);
        foreach ($struct as $index => $row) $this->_parseStruct($name, $row, $index);
        self::close();
    }   

    static public function open($url, $attributes = []) {
        $app = Application::instance();
        $stringifiedAttributes = '';

        foreach ($attributes as $attribute => $value) $stringifiedAttributes .= $attribute .'="'. $value .'" ';
        
        echo '<form rh-cmpnt="form" data-url="'. $url .'" '. $stringifiedAttributes .'>';
        echo '<input type="hidden" name="'. $app->getParam('CSRF')['fieldName'] .'" value="'. $app->csrf() .'">';

    }

    static public function close() {
        echo '<div class="form-group"> <button type="submit"> cockojambo </button> </div>';
        echo '</form>';
    }

    private function _parseStruct($name, $row, $index = null) {
        echo '<div class="form-group">';
        if (array_is_list($row)) { foreach ($row as $fieldIndex => $field) $this->_renderField($name, $fieldIndex, $field); }
        else $this->_renderField($name, $index, $row);
        echo '</div>';
    }

    private function _renderField($name, $index, $field) {
        if (!$this->_notWrapFields) echo '<div class="field-wrapper">';
        echo '<label> '. ($field['label'] ?? $index) .' </label>';
        switch ($field['type']) {
            case 'textarea':
                echo '<textarea name="'.$name .'['. $index .']"'. (isset($field['required']) ? 'required' : '') .'> </textarea>';
                break;
            default:
                echo '<input name="'. $name .'['. $index .']" type="'. $field['type'] .'" '. (isset($field['length']) ? 'maxlength="'. $field['length'] .'"' : '') . (isset($field['required']) ? 'required' : '') .'>';
                break;
        }
        if (!$this->_notWrapFields) echo '</div>';
    }
}

?>