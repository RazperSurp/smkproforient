<?php

namespace helpers;
class Json
{
    private static $messages = array(
        JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded',
        JSON_ERROR_STATE_MISMATCH => 'Syntax error, malformed JSON',
        JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
        JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON',
        JSON_ERROR_UTF8 => 'Invalid UTF-8 sequence',
        JSON_ERROR_RECURSION => 'Recursion detected',
        JSON_ERROR_INF_OR_NAN => 'Inf and NaN cannot be JSON encoded',
        JSON_ERROR_UNSUPPORTED_TYPE => 'Type is not supported',
    );


    public static function encode($value)
    {
        if (function_exists('ini_set')) {
            $old = ini_set('display_errors', 0);
        }

        set_error_handler(function($severity, $message) {
            restore_error_handler();
            throw new JsonException($message);
        });

        $json = json_encode($value);

        restore_error_handler();
        if (isset($old)) {
            ini_set('display_errors', $old);
        }
        if ($error = json_last_error()) {
            $message = isset(static::$messages[$error]) ? static::$messages[$error] : 'Unknown error';
            throw new JsonException($message, $error);
        }
        return $json;
    }


    public static function decode($json)
    {
        if (!preg_match('##u', $json)) { 
            throw new JsonException('Invalid UTF-8 sequence', 5);
        }

        $value = json_decode($json);

        if ($value === null && $json !== '' && $json !== 'null') {
            $error = json_last_error();
            $message = isset(static::$messages[$error]) ? static::$messages[$error] : 'Unknown error';
            throw new Exception($message, $error);
        }
        return $value;
    }
}
?>