<?php
namespace Models;
use Services\Db;

abstract class ActiveRecordEntity{
    protected $id;

    public function __set($name, $value){
        $nameToCamelCase = $this->underscoreToCamelCase($name);
        $this->$nameToCamelCase = $value;
    }

    private function underscoreToCamelCase(string $source){
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    private function camelCaseToUnderScore(string $source){
        return strtolower(preg_replace('/([A-Z])/', '_$1', $source));
    }

    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $propetiesName = [];
        foreach($reflector->getProperties() as $property){
            $propertyName = $property->getName();
            $propertyNameToDbFormat = $this->camelCaseToUnderScore($propertyName);
            $propertiesName[$propertyNameToDbFormat] = $this->$propertyName;
        }
        return $propertiesName;
    }

    public function save(){
        $properties = $this->mapPropertiesToDbFormat();
        if($this->id === null) $this->insert($properties);
        else $this->update($properties);
    }

    public function getId(){
        return $this->id;
    }

    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $articles = $db->query('SELECT * FROM `'.static::getTableName().'`', [], static::class);
    }

    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        $entities = $db->query('SELECT * FROM `'.static::getTableName().'` WHERE `id`=:id;', [':id'=>$id], static::class);
        return $entities ? $entities[0] : null;
    }

    public function update(array $propertyName){
       $column2param = [];
       $param2value = [];
       $index = 1;
       foreach($propertyName as $column=>$value){
            $param = ':param'.$index;
            $column2param[] = '`'.$column.'`  = '.$param;
            $param2value[$param] = $value;
            $index++; 
       }
       $sql = 'UPDATE `'.static::getTableName().'` SET'. implode(',',$column2param).' WHERE id='.$this->id;
       $db = Db::getInstance();
       $db->query($sql, $param2value, static::class);
    }

    public function insert(array $propertyName){
        $filteredProperties = array_filter($propertyName);
        $param2value = [];
        $columns = [];
        $params = [];
       foreach($filteredProperties as $column=>$value){
            $columns[] = '`'.$column.'`';
            $params[] = ':'.$column;
            $param2value[':'.$column] = $value;
       }
       $sql = 'INSERT INTO `'.static::getTableName().'` ('.implode(',',$columns).') VALUES ('.implode(',', $params).')';
       $db = Db::getInstance();
       $db->query($sql, $param2value, static::class);
    }

    public static function lastInsertId(): int
    {
        $sql = "SELECT LAST_INSERT_ID() AS `lastId`";
        $db = Db::getInstance();
        $result = $db->query($sql, [], static::class);
        return $result[0]->lastId;
    }
    public function delete(){
        $sql='DELETE FROM `'.static::getTableName().'` WHERE id='.$this->id;
        $db = Db::getInstance();
        $db->query($sql, [], static::class);
        $this->id = null;
    }

    abstract protected static function getTableName(): string;
}