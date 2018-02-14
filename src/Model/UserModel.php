<?php
/**
 * Модель для работы с таблицей пользователей (users)
 */

namespace App\Model;

class UserModel extends BaseModel
{
    /**
     * Регистрация нового пользователя
     *
     * @param string $email емаил пользователя
     * @param string $pwdMD5 пароль пользователя
     * @param string $name Имя пользователя
     * @param string $phone номер телефона
     * @param string $address адрес
     * @return array массив данных о пользователе
     */
    function registerNewUser($email, $pwdMD5, $name, $phone, $address)
    {
        /**
         * @var \PDO $pdo
         */
        $pdo = $this->container["db"];

        $email = htmlspecialchars($email);
        $name = htmlspecialchars($name);
        $phone = htmlspecialchars($phone);
        $address = htmlspecialchars($address);

        $sql = "INSERT INTO users (`email`, `pwd`, `name`, `phone`, `adress`)
            VALUES (?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        $rs = $stmt->execute([$email, $pwdMD5, $name, $phone, $address]);

        if ($rs) {
            $id = $pdo->lastInsertId();
            $sql = "SELECT * FROM users WHERE id = $id";
            $rs = $pdo->query($sql);
            $rs = $this->createSmartyRsArray($rs);

            if (isset($rs[0])) {
                $rs['success'] = 1;
            } else {
                $rs['success'] = 0;
            }
        } else {
            $rs['success'] = 0;
        }

        return $rs;
    }

    /**
     * @param string $email емаил пользователя
     * @param string $pwd1 пароль пользователя
     * @param string $pwd2 повторный ввод пароля
     * @return array результат
     */
    public function checkRegisterParams($email, $pwd1, $pwd2)
    {
        $res = null;

        if (!$email) {
            $res['success'] = 0;
            $res['message'] = "Введите email";
        }

        if (!$pwd1) {
            $res['success'] = 0;
            $res['message'] = "Введите пароль";
        }

        if (!$pwd2) {
            $res['success'] = 0;
            $res['message'] = "Введите повтор пароля";
        }

        if ($pwd1 != $pwd2) {
            $res['success'] = 0;
            $res['message'] = "Пароли не совпадают";
        }

        return $res;
    }

    /**
     * Проверяет емеил на уникальность в базе
     *
     * @param string $email емеил пользователя
     * @return array - массив строка с почтой либо пустой массив
     */
    public function checkUserEmail($email)
    {
        /**
         * @var \PDO $pdo
         */
        $pdo = $this->container["db"];

        $email = htmlspecialchars($pdo->quote($email));

        $sql = "SELECT * FROM users WHERE email = $email"; //TODO подумать как сделать через подготовленный запрос, проблема с передачей в функцию результата
        $rs = $pdo->query($sql);
        $rs = $this->createSmartyRsArray($rs);

        return $rs;
    }
}