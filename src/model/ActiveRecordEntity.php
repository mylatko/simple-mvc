<?php

namespace MVC\model;

use MVC\services\Db;

abstract class ActiveRecordEntity
{
    /** @var int */
    protected $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        //$classProperty = lcfirst(str_replace('_', '', ucwords($name, '_')));
        $this->$name = $value;
    }

    /**
     * @return array|null
     */
    public static function findAll():? array
    {
        $db = DB::getInstance();
        return $db->query('SELECT * FROM ' . static::getTableName() . ';', [], static::class);
    }

    /**
     * @param int $id
     * @return static|null
     */
    public static function getById(int $id):? self
    {
        $db = Db::getInstance();
        $result = $db->query(
            'SELECT * FROM ' . static::getTableName() . ' WHERE id=:id;',
            [':id' => $id],
            static::class
        );

        return $result ? $result[0] : null;
    }

    protected abstract static function getTableName(): string;

    /**
     * Save row: update or insert
     */
    public function save(): void
    {
        if($this->id != null)
            $this->update();
        else
            $this->insert();
    }

    /**
     * Insert new row to db
     */
    private function insert()
    {
//        echo "insert<br>";
        $properties = array_filter($this->getMappedProperties());
//        echo "<pre>";var_dump(array_filter($this->getMappedProperties()));
        $columns = [];
        $params = [];
        $values = [];
        foreach ($properties as $propertyName=>$propertyValue) {
            $columns[] = "`" . $propertyName . "`";
            $params[] = ":" . $propertyName;
            $values[":" . $propertyName] = $propertyValue;
        }
//        var_dump($values);
        $sql = "INSERT INTO `" . static::getTableName() . "` (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $params) . ");";

        $db = DB::getInstance();
        $db->query($sql, $values, static::class);

        $this->id = $db->getLastInsertId();
        $this->populateDate();
//        var_dump($db->getLastInsertId());
    }

    /**
     * Set date to created row
     */
    private function populateDate()
    {
        $result = self::getById($this->id);

        if ($result)
            $this->date = $result->date;
    }

    private function getMappedProperties()
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];
        foreach($properties as $property)
        {
            $propertyName = $property->getName();
            $mappedProperties[$propertyName] = $this->$propertyName;
        }

        return $mappedProperties;
    }

    /**
     * Update existing row by id
     */
    private function update()
    {
//        echo "update<br>";
        $mappedProperties = $this->getMappedProperties();
//        echo "<pre>";var_Dump($mappedProperties);
        $properties2param = [];
        $param2value = [];
        $index = 1;
        foreach($mappedProperties as $name=>$value) {
            $properties2param[] = $name . "=:param" . $index;
            $param2value["param" . $index] = $value;
            $index ++;
        }
        $sql = "UPDATE `" . static::getTableName() . "` SET " . implode(", ", $properties2param) . " WHERE id = " . $this->id;
        $db = DB::getInstance();
        $db->query($sql, $param2value, static::class);
//        echo $sql."<br>";
//        echo "<pre>";var_Dump($param2value);
    }

    /**
     *
     */
    public function delete()
    {
        $sql = "DELETE FROM `" . static::getTableName() . "` WHERE id = " . $this->id;

        $db = DB::getInstance();
        $db->query($sql);

        $this->id = null;
    }
}
