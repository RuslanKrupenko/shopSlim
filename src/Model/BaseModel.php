<?php

namespace App\Model;

use Psr\Container\ContainerInterface;
use PDO;

abstract class BaseModel
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Преобразование результата работы выборки данных в ассоциативный массив
     *
     * @param \PDOStatement $rs результат работы select
     * @return array $smartyRs массив элементов
     */
    public function createSmartyRsArray($rs)
    {
        if (!$rs) return false;

        $smartyRs = [];
        while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
            $smartyRs[] = $row;
        }
        return $smartyRs;
    }
}


