<?php

namespace App\Model;

use App\Connection\Connection;

class Model {

    protected $table;
    protected $fillable;

    private $queryBuilder;

    public function __construct()
    {
        //$this->queryBuilder = new QueryBuilder($this->table, $this->fillable);
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setFillable($fillable)
    {
        $this->fillable = $fillable;
    }

    public function getFillable()
    {
        return $this->fillable;
    }

    // public function __get($queryBuilder)
    // {
    //     return $this->queryBuilder;
    // }
}
