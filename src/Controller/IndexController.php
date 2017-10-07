<?php

namespace App\Controller;

use App\Model\CategoryModel;
use App\Model\ProductsModel;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $categoryModel = new CategoryModel($this->getContainer());
        $productsModel = new ProductsModel($this->getContainer());

        $rsCategories = $categoryModel->getAllMainCatsWithChildren();
        $rsProducts = $productsModel->getLastProducts(16);

        print_r("<pre>");
        print_r($rsProducts);
        print_r("</pre>");
    }
}
