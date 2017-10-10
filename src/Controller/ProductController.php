<?php
/**
 * Контроллер загрузки страницы товара
 */

namespace App\Controller;

use App\Model\ProductsModel;
use App\Model\CategoryModel;

class ProductController extends BaseController
{
    /**
     * Формирование страницы продукта
     * @param array $args массив параметров из request
     */
    public function indexAction(array $args)
    {
        $itemId = $args["id"];
        $productsModel = new ProductsModel($this->getContainer());
        $categoryModel = new CategoryModel($this->getContainer());
        $smarty = $this->getContainer()["smarty"];

        if (!$itemId) exit();

        // получить данные продукта
        $rsProduct = $productsModel->getProductById($itemId);

        // получить все категории
        $rsCategories = $categoryModel->getAllMainCatsWithChildren();

        $smarty->assign('itemInCart', 0);
        if (in_array($itemId, $_SESSION['cart'])) {
            $smarty->assign('itemInCart', 1);
        }

        $smarty->assign('pageTitle', 'Страница товара');
        $smarty->assign('rsProduct', $rsProduct);
        $smarty->assign('rsCategories', $rsCategories);

        return $this->getResponse()->getBody()->write($smarty->display("product.tpl"));
    }
}