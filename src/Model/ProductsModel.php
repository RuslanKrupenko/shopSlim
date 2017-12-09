<?php
/**
 * Модель для таблицы продукции (products)
 */

namespace App\Model;

use Monolog\Logger;

class ProductsModel extends BaseModel
{
    /**
     * Получаем последние добавленные товары
     *
     * @param null $limit
     * @return array
     */
    public function getLastProducts($limit = null)
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
        $data = $this->createSmartyRsArray($rs);

        $pdo = null;
        $rs = null;

        return $data;
    }

    /**
     * Получить данные продукта по ID
     *
     * @param integer $itemId идентификатор товара
     * @return array массив - строка товара из базы
     */
    public function getProductById(int $itemId)
    {
        /**
         * @var \PDO $pdo
         */
        $pdo = $this->container["db"];
        $sql = "SELECT * FROM products WHERE id = " . $itemId;

        $rs = $pdo->query($sql);
        $data = $rs->fetch(\PDO::FETCH_ASSOC);

        $pdo = null;
        $rs = null;

        return $data;
    }

    /**
     * Получаем все продукты выбранной категории
     *
     * @param integer $carId идентификатор категории
     * @return array массив - набор продуктов
     */
    function getProductsByCat(int $catId)
    {
        /**
         * @var \PDO $pdo
         */
        $pdo = $this->container["db"];
        $sql = "SELECT * FROM products WHERE category_id = " . $catId;

        $rs = $pdo->query($sql);
        $data = $this->createSmartyRsArray($rs);

        $pdo = null;
        $rs = null;

        return $data;
    }

    /**
     * Метод возращает массив товаров из массива идентификаторов
     *
     * @param array $itemIds массив идентификаторов товаров
     * @return array массив товаров
     */
    public function getProductsFromArray($itemIds)
    {
        if (!$itemIds) {
            return null;
        }
        /**
         * @var Logger $logger
         */
        $logger = $this->container["logger"];
        /**
         * @var \PDO $pdo
         */
        $pdo = $this->container["db"];
        $strIds = implode(",", $itemIds);
        $sql = "SELECT * FROM products WHERE id in ({$strIds})";

        try {
            $rs = $pdo->query($sql);
            $data = $this->createSmartyRsArray($rs);
        } catch (\Exception $e) {
            $logger->error("Ошибка: " . $e->getMessage());
            $logger->info("Query was: " . $sql);
            return null;
        }

        $pdo = null;
        $rs = null;

        return $data;
    }
}