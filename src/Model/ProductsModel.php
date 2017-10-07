<?php
/**
 * Модель для таблицы продукции (products)
 */

namespace App\Model;

class ProductsModel extends BaseModel
{
    /**
     * Получаем последние добавленные товары
     *
     * @param null $limit
     * @return array
     */
    function getLastProducts($limit = null)
    {
        /**
         * @var \PDO $pdo
         */
        $pdo = $this->container['db'];

        $sql = "SELECT * FROM products ORDER BY id DESC";

        if ($limit) {
            $sql .= " LIMIT " . $limit;
        }

        $rs = $pdo->query($sql);
        return $this->createSmartyRsArray($rs);
    }
}