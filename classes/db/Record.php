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

    static public function model() {
        return substr(static::class, (strripos(static::class, '\\') + 1));
    }

    public function __construct($table, $id = null, $data = null) {
        
        $this->_table = $table;
        $this->_id = $id;
        $this->_oldAttributes = $data;

        unset($this->_oldAttributes['id']);

        $this->attributes = $data;
        foreach ($data as $prop => $value) $this->$prop = &$this->attributes[$prop];
    }

    public function update() {
        $fields = [];
        $sql = 'UPDATE "'. $this->_table .'" SET';

        foreach ($this->_oldAttributes as $property => $value) $fields[] = ' "'. $property .'" = \''. $this->attributes[$property] .'\'';

        $sql .= implode(', ', $fields) . ' WHERE "id" = \''. $this->_id .'\'';

        (new Query($sql, $this->_table))->query();
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

            $result = (new Query("INSERT INTO \"{$table}\" ({$columns}) VALUES ($dataMask) RETURNING \"id\"", static::table()))->queryByParams($data);
            echo '<pre>';
            print_r($result);
            exit;
        }
    }

    static function struct() {
        $sql = "SELECT isc.*, pg_catalog.col_description(format('%s.%s',isc.table_schema,isc.table_name)::regclass::oid,isc.ordinal_position) as column_description FROM information_schema.columns isc where isc.table_name = '". self::table() ."' order by isc.ordinal_position";
        $struct = ((new Query($sql))->query())['response'];

        $results = [];
        foreach ($struct as $row) {
            $results[$row->column_name] = [
                'label' => $row->column_description,
                'required' => $row->is_nullable === 'NO',
                'type' => $row->data_type,
                'length' => $row->character_maximum_length
            ];

            if ($row->column_name == 'id') $results[$row->column_name]['type'] = 'hidden';
            if ($row->data_type == 'character varying') $results[$row->column_name]['type'] = 'text';
            if ($row->data_type == 'text' && !isset($row->character_maximum_length)) $results[$row->column_name]['type'] = 'textarea';
        }

        return $results;
    }

    static function form() {
        return new \helpers\Form(static::model(), static::struct());
    }
}

?>