<?php

namespace db;

class Query {
    public const TYPE_SELECT = 'SELECT';
    public const TYPE_UPDATE = 'UPDATE';
    public const TYPE_DELETE = 'DELETE';
    public const TYPE_INSERT = 'INSERT';

    public const JOIN_INNER = 'INNER JOIN';
    public const JOIN_OUTER = 'OUTER JOIN';
    public const JOIN_CROSS = 'CROSS JOIN';

    public const SORT_DESC = 0;
    public const SORT_ASC = 1;

    private $_one;

    private $_rawSql;
    private $_conditions;
    private $_target;
    private $_joins;
    private $_app;

    private $_resource;
    private $_results;

    private $_e;

    private $_struct;

    public function __construct($sql = null, $target = null) {
        $this->_app = \Application::instance();
        $this->_rawSql = $sql;
    }

    public function query() {
        try {
            $this->_resource = pg_query($this->_app->db, $this->_rawSql);
        } catch (\Exception $e) {
            $this->_e = pg_last_error();
        }

        $this->_parse();

        return ['success' => isset($this->_results), 'response' => $this->_results ?? $this->_e];
    }
    
    public function queryByParams($params) {
        try {
            $this->_resource = pg_query_params($this->_app->db, $this->_rawSql, $params);
        } catch (\Exception $e) {
            $this->_e = pg_last_error();
        }

        $this->_parse();

        return ['success' => isset($this->_results), 'response' => $this->_results ?? $this->_e];
    }

    private function _parse() {
        $this->_results = [];

        while ($row = pg_fetch_assoc($this->_resource)) {
            $this->_results[] = new Record($this->_target, $row['id'] ?? null, $row);
        }

        if ($this->_one) $this->_results = $row;
    }

    public function one() {
        $this->limit(1);
        $this->_rawSql = $this->_stringifyQuery();
        
        return $this->query();
    }

    public function all() {
        unset($this->_struct['limit']);
        $this->_rawSql = $this->_stringifyQuery();
        
        return $this->query();
    }

    private function _stringifyQuery() {
        foreach ($this->_struct as $prop => &$value) if (is_array($value)) $value = array_filter($value);
        $this->_struct = array_filter($this->_struct);

        return $this->_struct['type']  . ' '
            . ($this->_struct['columns'] ?? '*') 
            . ' FROM ' 
            . $this->_struct['table'] .' '
            . implode(' ', $this->_struct['joins'] ?? []) .' '
            . (isset($this->_struct['conditions']) && count($this->_struct['conditions']) > 0 ? 'WHERE '. implode(', ', $this->_struct['conditions']) : ' ')
            . (isset($this->_struct['group']) && count($this->_struct['group']) > 0 ? 'GROUP BY '. implode(', ', $this->_struct['group']). ' ' : ' ')
            . (isset($this->_struct['having']) && count($this->_struct['having']) > 0 ? 'HAVING '. implode(', ', $this->_struct['having']). ' ' : ' ')
            . (isset($this->_struct['order']) && count($this->_struct['order']) > 0 ? 'ORDER BY '. implode(', ', $this->_struct['order']). ' ' : ' ')
            . (isset($this->_struct['limit']) ? 'LIMIT '. $this->_struct['limit']. ' ' : ' ')
            . (isset($this->_struct['offset']) ? 'OFFSET '. $this->_struct['offset'] . ' ': ' ');
    }

    public function select($table) {
        $this->_struct['type'] = 'SELECT';
        $this->_struct['table'] = '"'. $table .'"';

        $this->_target = $table;
        
        return $this;
    }

    public function columns($columns = []) {
        $this->_struct['columns'] = $this->_struct['columns'] ?? [];
        if ((count($columns) > 0)) {
            switch ($this->_struct['type']) {
                case self::TYPE_SELECT:
                    foreach ($columns as $name => $alias) $this->_struct['columns'][] = '"'. $name .'" AS '. $alias;
                    break;
                case self::TYPE_UPDATE:
                    foreach ($columns as $name => $value) $this->_struct['columns'][] = '"'. $name .'" = '. $value;
                    break;
                case self::TYPE_INSERT:
                    $this->_struct['columns'] = [
                        'names' => '"'. implode('", "', array_keys($columns)) .'"',
                        'values' => '\''. implode('\', \'', $columns) .'\''
                    ];
                    break;
            }
        } else if (count($columns) === 0 && $this->_struct['type'] === self::TYPE_SELECT) {
            $this->_struct['columns'] = '*';
        }

        return $this;
    }

    public function where($conditions = []) {
        $this->_struct['conditions'] = $this->_struct['conditions'] ?? [];
        $this->_struct['conditions'][] = $this->_stringifyConditions($conditions);

        return $this;
    }

    public function group($fields = []) {
        $this->_struct['group'] = $this->_struct['group'] ?? [];
        $this->_struct['group'][] = '"'. implode('", "', $fields) .'"';

        return $this;
    }

    public function having($conditions = []) {
        $this->_struct['having'] = $this->_struct['having'] ?? [];
        $this->_struct['having'][] = $this->_stringifyConditions($conditions);

        return $this;
    }

    public function join($type, $target, $from, $to, $conditions = null, $alias = null) {
        $this->_struct['joins'] = $this->_struct['joins'] ?? [];
        $this->_struct['joins'][] = $type .' "'. $target .'"'. (isset($alias) ? ' AS '. $alias : '') .' ON "'. $from .'" = "'. $to .(isset($conditions) ? ' AND '. $this->_stringifyConditions($conditions) : '');

        return $this;
    }

    public function joins($joinsArray) {
        foreach ($joinsArray as $join) $this->join($join['type'], $join['target'], $join['from'], $join['to'], $join['alias'], $join['conditions']);

        return $this;
    }

    public function limit($integer) {
        $this->_struct['limit'] = $integer;
    }

    public function offset($integer) {
        $this->_struct['offset'] = $integer;
    }

    public function order($order) {
        $this->_struct['order'] = $this->_struct['order'] ?? [];
        foreach ($order as $field => $order) {
            $this->_struct['order'][] = '"'. $field .'" '. ($order === self::SORT_DESC ? 'desc' : 'asc');
        }

        return $this;
    }

    private function _stringifyConditions($conditions) {
        $result = [];
        foreach ($conditions as $field => $condition) {
            $result[] = '"'. $field .'" '. $condition['operator'] .' '. $this->_parseWhereFieldValue($condition['value']);
        }
        
        return implode(' AND ', $result);
    }

    private function _parseWhereFieldValue($value) {
        $result = '';

        if (is_array($value) || gettype($value) === 'object') $result = '(\''. implode('\', \'', (array)$value) .'\')';
        else if (!isset($value)) $result = 'NULL';
        else $result = "'$value'";

        return $result;
    }

    public function rawSql() {
        return $this->_rawSql;
    }
}

?>