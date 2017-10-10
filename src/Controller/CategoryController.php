<?php
/**
 * Контроллер страницы категории (category/1/)
 */

namespace App\Controller;

use App\Model\CategoryModel;
use App\Model\ProductsModel;

class CategoryController extends BaseController
{
    /**
     * Метод формирования страницы категорий
     * @param array $args массив параметров request
     */
    public function indexAction(array $args)
    {
        $smarty = $this->getContainer()["smarty"];
        $categoryModel = new CategoryModel($this->getContainer());
        $productsModel = new ProductsModel($this->getContainer());
        $catId = isset($args['id']) ? $args['id'] : null;
        if ($catId == null) {
            exit();
        }

        $rsChildCats = null;
        $rsProducts = null;
        $rsCategory = $categoryModel->getCatById($catId);

        /**
         * если главная категория, то показываем подкатегории.
         * Иначе показываем товар
         */
        if ($rsCategory['parent_id'] == 0) {
            $rsChildCats = $categoryModel->getChildrenForCat($catId);
        } else {
            $rsProducts = $productsModel->getProductsByCat($catId);
        }

        $rsCategories = $categoryModel->getAllMainCatsWithChildren();

        $smarty->assign('pageTitle', 'Товары категории ' . $rsCategory['name']);
        $smarty->assign('rsCategory', $rsCategory);
        $smarty->assign('rsChildCats', $rsChildCats);
        $smarty->assign('rsProducts', $rsProducts);
        $smarty->assign('rsCategories', $rsCategories);

        return $this->getResponse()->getBody()->write($smarty->display("category.tpl"));
    }
}