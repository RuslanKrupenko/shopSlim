<?php

namespace App\Controller;

use App\Model\CategoryModel;
use App\Model\ProductsModel;

class IndexController extends BaseController
{
    /**
     * Формироваине главной страницы сайта
     * @param object $smarty шаблонизатор
     */
    public function indexAction()
    {
        $smarty = $this->getContainer()["smarty"];

        $categoryModel = new CategoryModel($this->getContainer());
        $productsModel = new ProductsModel($this->getContainer());

        $rsCategories = $categoryModel->getAllMainCatsWithChildren();
        $rsProducts = $productsModel->getLastProducts(16);

        $smarty->assign('pageTitle', 'Главная страница сайта');
        $smarty->assign('rsCategories', $rsCategories);
        $smarty->assign('rsProducts', $rsProducts);

        return $this->getResponse()->getBody()->write($smarty->display("index.tpl"));
    }
}
