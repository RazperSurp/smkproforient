<?php

namespace models;

use Application;
use db\{Query, Record};

abstract class Model extends Record {
    public static function one(array $conditions = [], array $columns = []) {
        $query = new Query();
        $results = $query->select(self::table())
            ->columns($columns)
            ->where($conditions)
            ->order(['id' => Query::SORT_ASC])
            ->one();

        return $results['response'][0];
    }

    public static function all(array $conditions = [], array $columns = []) {
        $query = new Query();

        $results = $query->select(self::table())
            ->columns($columns)
            ->where($conditions)
            ->order(['id' => Query::SORT_ASC])
            ->all();
            
        return $results['response'];
    }

    public static function deleted(array $conditions = [], array $columns = []) {
        $query = new Query();
        $results = $query->select(self::table())
            ->columns($columns)
            ->where($conditions);

        return $results['response'];
    }

    public static function select() {
        $conditions = [];
        foreach (Application::instance()->request->body['GET'] as $field => $value) {
            $conditions[$field] = ['value' => $value, 'operator' => '='];
        }

        return self::all($conditions);
    }

    public static function patch() {
        $formData = Application::instance()->request->body['POST'][static::model()];
        $model = self::one(['id' => ['value' => $formData['id'], 'operator' => '=']]);
        foreach ($formData as $prop => $value) $model->$prop = $value;
        
        $model->update();
    }
}

?>