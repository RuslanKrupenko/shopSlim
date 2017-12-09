<?php
/**
 * Контроллер работы с карзиной покупок
 */

namespace App\Controller;

use App\Model\CategoryModel;
use App\Model\ProductsModel;
use Slim\Http\Request;

class CartController extends BaseController
{
    /**
     * Формирование страницы корзины
     */
    public function indexAction()
    {
        $smarty = $this->getContainer()["smarty"];
        $categoryModel = new CategoryModel($this->getContainer());
        $productModel = new ProductsModel($this->getContainer());

        $itemIds = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

        $rsCategories = $categoryModel->getAllMainCatsWithChildren();
        $rsProducts = $productModel->getProductsFromArray($itemIds);

        $smarty->assign('pageTitle', 'Корзина товаров');
        $smarty->assign('rsCategories', $rsCategories);
        $smarty->assign('rsProducts', $rsProducts);

        return $this->getResponse()->getBody()->write($smarty->display("cart.tpl"));
    }

    /**
     * Добавление товара в карзину
     *
     * @param array $args
     * @return string (json) информация об операции (успех, кол-во элементов в корзине)
     */
    function addtocartAction($args)
    {
        $itemId = isset($args['id']) ? intval($args['id']) : null;
        if (!$itemId) exit();

        $resData = array();

        // если значение в корзине не найдено то добавляем
        if (isset($_SESSION['cart']) && array_search($itemId, $_SESSION['cart']) === false) {
            $_SESSION['cart'][] = $itemId;
            $resData['cntItems'] = count($_SESSION['cart']);
            $resData['success'] = 1;
        } else {
            $resData['success'] = 0;
        }

        return $this->getResponse()->withJson($resData, 200);
    }

    /**
     * Удаляет продукт из корзины с идентификатором ID
     * @param array $args массив параметров из request
     * @return json результат операции
     */
    function removefromcartAction($args)
    {
        $itemId = isset($args['id']) ? intval($args['id']) : null;
        if (!$itemId) exit();

        $resData = array();

        // проверяем существование товара в корзине
        $key = array_search($itemId, $_SESSION['cart']);
        // если сушествует, удаляем
        if ($key !== false) {
            unset($_SESSION['cart'][$key]);
            $resData['success'] = 1;
            $resData['cntItems'] = count($_SESSION['cart']);
        } else {
            $resData['success'] = 0;
        }

        return $this->getResponse()->write(json_encode($resData), 200);
    }


    /**
     * Формирование страницы заказа
     *
     * @param Request $request массив параметров
     * @return object
     */
    public function orderAction(Request $request)
    {
        $smarty = $this->getContainer()["smarty"];
        $categoryModel = new CategoryModel($this->getContainer());
        $productModel = new ProductsModel($this->getContainer());

        // получеем массив идентификаторов ID продуктов карзины
        $itemIds = isset($_SESSION['cart']) ? $_SESSION['cart'] : null;
        // если корзина пуста то редиректим в корзину
        if (!$itemIds) {
            header("Location: /cart");
            return;
        }

        // получаем из массива пост количество приобретаемых товаров
        $itemsCnt = array();
        foreach ($itemIds as $id) {
            // формируем ключ для массива post
            $postVar = "itemCnt_" . $id;
            // создаем элемент массива количество покупаемого товара
            // ключ массива - id товара, значение - кол-во покупаемого товара
            $itemsCnt[$id] = $request->getParam($postVar) ?? null;
        }

        // получаем список продуктов по массиву ID
        $rsProducts = $productModel->getProductsFromArray($itemIds);

        // добавляем каждому продукту дополнительное поле
        // "RealPrice" кол-во продуктов на цену продукта
        // "cnt" - кол-во покупаемого товара

        // &$itme - для того чтобы при изменении переменной $item менялся и
        // элемент массива $rsProducts
        $i = 0;
        foreach ($rsProducts as &$item) {
            $item['cnt'] = isset($itemsCnt[$item['id']]) ? $itemsCnt[$item['id']] : 0;
            if ($item['cnt']) {
                $item['realPrice'] = $item['cnt'] * $item['price'];
            } else {
                // если вдруг получилось так, что товар в корзине есть, а кол-во равно нулю, то
                // удаляем этот товар.
                unset($rsProducts[$i]);
            }
            $i++;
        }

        if (!$rsProducts) {
            echo "Карзина пуста";
            return;
        }

        // полученный масив покупаемых товаров кладем в сессионную переменную
        $_SESSION['saleCart'] = $rsProducts;

        $rsCategories = $categoryModel->getAllMainCatsWithChildren();

        // hideLoginBox переменная - флаг для того чтобы спрятать блоки логина и регистрации в меню слева
        if (!isset($_SESSION['user'])) {
            $smarty->assign("hideLoginBox", 1);
        }

        $smarty->assign("pageTitle", "Заказ");
        $smarty->assign("rsCategories", $rsCategories);
        $smarty->assign("rsProducts", $rsProducts);

        return $this->getResponse()->getBody()->write($smarty->display("order.tpl"));
    }
}
