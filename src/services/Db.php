<?php

namespace MVC\services;

use MVC\exception\DbException;

class Db
{
    /** @var \PDO */
    private $pdo;

    /**
     * @var \PDO
     */
    private static $instance;

    private function __construct()
    {
        $dbOptions = (require __DIR__ . '../../settings.php')['db'];

        try {
            $this->pdo = new \PDO(
                'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'] . ';port=' . $dbOptions['port'],
                $dbOptions['user'],
                $dbOptions['password']
            );
            $this->pdo->exec('SET NAMES UTF8');
        } catch (\PDOException $e) {
            throw new DbException('Error db connecting: ' . $e->getMessage());
        }

    }

    public static function getInstance(): self
    {
        if(self::$instance == null)
            self::$instance = new self();

        return self::$instance;
    }

    public function query(string $sql, $params = [], string $className = 'stdClass'): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            var_dump($sth->errorInfo());
            return null;
        }

        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public function getLastInsertId()
    {
        return (int)$this->pdo->lastInsertId();
    }
}
