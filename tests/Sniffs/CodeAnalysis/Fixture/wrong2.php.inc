<?php

class Repository
{
    public $connection;

    public function findSomething()
    {
        $queryBuilder = $this->connection
            ->createQueryBuilder()
            ->select('a.id', 'a.name')
            ->from('table', 'a');
        $this->addConditions($queryBuilder);
        return $queryBuilder->execute()->fetchAll();
    }

    private function addConditions($queryBuilder)
    {
        $queryBuilder->where('a.active = 1')->andWhere('a.email IS NOT NULL');
    }
}
