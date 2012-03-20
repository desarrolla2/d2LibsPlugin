<?php

class DQ extends Doctrine_Query {

    public static function create($conn = null, $class = null) {
        return new DQ($conn, $class);
    }

    public function toGroup() {
        $where = $this->_dqlParts['where'];
        if (count($where) > 0) {
            array_splice($where, count($where) - 1, 0, '(');
            $this->_dqlParts['where'] = $where;
        }
        return $this;
    }

    public function endGroup() {
        $where = $this->_dqlParts['where'];
        if (count($where) > 0) {
            $where[] = ')';
            $this->_dqlParts['where'] = $where;
        }

        return $this;
    }

}