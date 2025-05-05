<?php

namespace helpers;

use Application;

class Form {
    static public function open($url, $attributes = []) {
        $app = Application::instance();
        $stringifiedAttributes = '';

        foreach ($attributes as $attribute => $value) $stringifiedAttributes .= $attribute .'="'. $value .'" ';
        
        echo '<form rh-cmpnt="form" data-url="'. $url .'" '. $stringifiedAttributes .'>';
        echo '<input type="hidden" name="'. $app->getParam('CSRF')['fieldName'] .'" value="'. $app->csrf() .'">';

    }

    static public function close() {
        echo '</form>';
    }
}

?>