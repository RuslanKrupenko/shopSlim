<?php
/**
 * Модель для таблицы категорий (categories)
 */

namespace App\Model;

use Psr\Container\ContainerInterface;

class CategoryModel extends BaseModel
{
    /**
     * Получить главные категории с привязками дочерних
     * @return array $smartyRs массив категорий
     */
    public function getAllMainCatsWithChildren()
    {
        /**
         * @var \PDO $pdo
         */
        $pdo = $this->container["db"];

        $sql = "SELECT * FROM categories WHERE parent_id = 0";
        $rs = $pdo->query($sql);

        $smartyRs = [];
        while ($row = $rs->fetch($pdo::FETCH_ASSOC)) {
            $rsChildren = $this->getChildrenForCat($row['id']);
            if ($rsChildren) {
                $row['children'] = $rsChildren;
            }
            $smartyRs[] = $row;
        }

        return $smartyRs;
    }

    /**
     * Получить дочерние категрии по идентификатору радительской категории
     *
     * @param integer $catId идентификатор радительской категории
     * @return array массив дочерних категорий
     */
    public function getChildrenForCat($catId)
    {
        /**
         * @var \PDO $pdo
         */
        $pdo = $this->container["db"];

        $sql = "SELECT * FROM categories WHERE parent_id = $catId";

        $rs = $pdo->query($sql);

        return $this->createSmartyRsArray($rs);
    }
}