<?php

namespace db;

class Record {
    private $_table;
    private $_id;
    private $_oldAttributes = [];

    public $attributes = [];

    static public function table() {
        $name = array_filter(preg_split('/(?=[A-Z])/', substr(static::class, (strrpos(static::class, '\\') + 1))));
        foreach ($name as &$piece) $piece = strtolower($piece);

        return implode('_', $name);
    }

    public function __construct($table, $id, $data) {
        $this->_table = $table;
        $this->_id = $id;
        $this->_oldAttributes = $data;

        $this->attributes = $data;
    }

    public function update() {
        $sql = 'UPDATE "'. $this->_table .'" SET';
        foreach ($this->_oldAttributes as $property => $value) $sql .= ' "'. $property .'" = \''. $this->attributes[$property] .'\'';
        $sql .= ' WHERE "id" = \''. $this->_id .'\'';

        (new Query($sql))->query();
    }

    static function insert($data) {
        if (array_is_list($data)) {
            $result = [];
            foreach ($data as $row) $results[] = self::insert($row);
        } else {
            echo "insert!\n";
            $table = self::table();
            $columns = '"'. implode('", "', array_keys($data)) .'"';            
            
            $paramMarks = '';
            $dataMask = array_values($data);
            
            foreach ($dataMask as $i => &$value) {
                $value = '$'. $i + 1;
            }

            $dataMask = implode(', ', $dataMask);

            $result = (new Query("INSERT INTO \"{$table}\" ({$columns}) VALUES ($dataMask) RETURNING \"id\""))->queryByParams($data);
            echo '<pre>';
            print_r($result);
            exit;
        }
    }
}

?>