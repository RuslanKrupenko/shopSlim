<?php
/**
 * Контроллер работы с юзерами
 */

namespace App\Controller;

use App\Model\UserModel;
use App\Model\CategoryModel;
use Slim\Http\Request;

class UserController extends BaseController
{
// подключаем модели
//require_once "../models/OrdersModel.php";
//require_once "../models/PurchaseModel.php";

    /**
     * Ajax регистрация пользователей
     * Инициализация сессионной переменной ($_SESSION['user'])
     *
     * @return json массив данных нового пользователя
     */
    public function registerAction(Request $request)
    {
        $userModel = new UserModel($this->getContainer());

        $email = $request->getParam('email') ? trim($request->getParam('email')) : null;
        $pwd1 = $request->getParam('pwd1') ? $request->getParam('pwd1') : null;
        $pwd2 = $request->getParam('pwd2') ? $request->getParam('pwd2') : null;

        $phone = $request->getParam('phone') ? $request->getParam('phone') : null;
        $addres = $request->getParam('address') ? $request->getParam('address') : null;
        $name = $request->getParam('name') ? trim($request->getParam('name')) : null;

        $resData = null;
        $resData = $userModel->checkRegisterParams($email, $pwd1, $pwd2);

        if (!$resData && $userModel->checkUserEmail($email)) {
            $resData['success'] = 0;
            $resData['message'] = "Пользователь с таким email {$email} уже зарегестрирован!";
        }

        if (!$resData) {
            $pwdMD5 = md5($pwd1);

            $userData = $userModel->registerNewUser($email, $pwdMD5, $name, $phone, $addres);
            if ($userData['success']) {
                $resData['message'] = "Пользователь успешно зарегестрирован";
                $resData['success'] = 1;

                $userData = $userData[0];
                $resData['userName'] = $userData['name'] ? $userData['name'] : $userData['email'];
                $resData['email'] = $userData['email'];

                $_SESSION['user'] = $userData;
                $_SESSION['user']['displayName'] = $userData['name'] ? $userData['name'] : $userData['email'];
            } else {
                $resData['success'] = 0;
                $resData['message'] = "Ошибка регистрации";
            }
        }

        return $this->getResponse()->write(json_encode($resData), 200);
    }
}