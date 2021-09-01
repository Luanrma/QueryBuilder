<?php

namespace App\Model;

use App\Connection\Connection;
use BadMethodCallException;

class QueryBuilder {
    
    private $conn;
    private $sql;

    private $table;
    private $fillable;
    
    private $query;
    private $conditions;
    private $arguments = [];
    private $params = [];
    private $binds = [];
    private $values = [];
    
    public function __construct(object $object = null)
    {
        $this->conn = (new Connection())->getConnection();
        if($object){
            $this->table = $object->getTable();
            $this->fillable = $object->getFillable();   
        }  
        // $this->table = $this->object->table;
        // $this->fillable = $this->object->fillable;
    }

    public function __call($function, $args) {
        $args = implode(', ', $args);
        print "Call to $function() with args '$args' failed!\n";
    }

    public function select(array $collumns = ['*']): self
    {
        $this->query = "SELECT ". implode(', ',$collumns) ." FROM " . $this->table; 
        return $this;
    }

    public function insert(array $insertValues): self
    {
        $this->query = 'INSERT INTO ' . $this->table;
        $collumns = [];
        $values = [];
        
        foreach($insertValues as $key => $value) {
            array_push($collumns, $key);
            array_push($values, $value);
        }

        $this->query .= ' (' . join(', ', $collumns) .')';
        $this->query .= ' VALUES (' . join(', ', $values) .')';
        return $this;
    }

    public function update(array $collumns)
    {   
        $fields = '';
        foreach($collumns as $key => $value) {
            $this->arguments .= ' ' .$key . ' = ' . $value. ', ';
        }
        $this->query = "UPDATE " . $this->table . " SET" . rtrim($this->arguments, ', ');
        $this->query .= $this->conditions;
    }

    public function where(array ...$arguments): self
    {   
        $this->setBindParam(...$arguments);

        foreach ($arguments as $argument) {  
            $argument[2] = ':' . $argument[0];

            $this->conditions .= $this->conditions == '' 
                ? ' WHERE ' . implode(' ', $argument) 
                : ' AND ' . implode(' ', $argument);
        }
        return $this;
    }

    public function orWhere(array ...$arguments): self
    {   
        $this->setBindParam(...$arguments);

        foreach ($arguments as $argument) {  
            $argument[2] = ':' . $argument[0];

            $this->conditions .= ' OR ' . implode(' ', $argument);
        }
        return $this;
    }

    public function get()
    {
        $this->prepareQuery();
        $result = $this->sql->fetchAll($this->conn::FETCH_ASSOC);
        return $result;
    }

    public function first()
    {
        return $this->query .= $this->conditions . ' LIMIT 1';
    }

    private function setBindParam(array ...$arguments)
    {
        foreach ($arguments as $argument) {
            array_push($this->binds, ':'.$argument[0]);
            array_push($this->values, $argument[2]);
        }
    }

    private function getBindParam(object $sql)
    {
        $count = 0;
        foreach($this->binds as $a) {
            $sql->bindParam($this->binds[$count], $this->values[$count]);
            $count++;
        }
    }

    private function prepareQuery()
    {
        $this->query .= $this->conditions;
        $this->sql = $this->conn->prepare($this->query);
        $this->getBindParam($this->sql);
        $this->sql->execute();
    }
}