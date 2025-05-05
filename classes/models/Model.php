<?php

namespace models;

use db\{Query, Record};

abstract class Model extends Record {
    public static function one(array $conditions = [], array $columns = []) {
        $query = new Query();
        return $results = $query->select(self::table())
            ->columns($columns)
            ->where($conditions)
            ->order(['id' => Query::SORT_ASC])
            ->one();
    }

    public static function all(array $conditions = [], array $columns = []) {
        $query = new Query();

        return $results = $query->select(self::table())
            ->columns($columns)
            ->where($conditions)
            ->order(['id' => Query::SORT_ASC])
            ->all();
    }

    public static function deleted(array $conditions = [], array $columns = []) {
        $query = new Query();
        return $results = $query->select(self::table())
            ->columns($columns)
            ->where($conditions);
    }
}

?>