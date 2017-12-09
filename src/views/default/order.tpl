{* страница заказа *}

<h2>Данные заказа</h2>
<form id="formOrder" action="/?controller=cart&action=saveorder" method="post">
    <table>
        <tr>
            <td>№</td>
            <td>Наименование</td>
            <td>Количество</td>
            <td>Цена за еденицу</td>
            <td>Стоимость</td>
        </tr>
        {foreach $rsProducts as $item name=products}
            <tr>
                <td>{$smarty.foreach.products.iteration}</td>
                <td><a href="/product/{$item['id']}">{$item['name']}</a></td>
                <td>
                    <span id="itemCnt_"{$item['id']}>
                        <input type="hidden" name="itemCnt_"{$item['id']} value="{$item['cnt']}"/>
                        {$item['cnt']}
                    </span>
                </td>
                <td>
                    <span id="itemPrice_{$item['id']}">
                        <input type="hidden" name="itemPrice_"{$item['id']} value="{$item['price']}"/>
                        {$item['price']}
                    </span>
                </td>
                <td>
                    <span id="itemRealPrice_"{$item['id']}>
                        <input type="hidden" name="itemRealPrice_"{$item['id']} value="{$item['realPrice']}"/>
                        {$item['realPrice']}
                    </span>
                </td>
            </tr>
        {/foreach}
    </table>

    {if isset($arUser)}
        {$buttonClass = ""}
        <h2>Данные заказчика</h2>
        <div id="orderUserInfoBox" {$buttonClass}>
            {$name = $arUser['name']}
            {$phone = $arUser['phone']}
            {$address = $arUser['adress']}
            <table>
                <tr>
                    <td>Имя</td>
                    <td><input type="text" id="name" name="name" value="{$name}"></td>
                </tr>
                <tr>
                    <td>Телефон</td>
                    <td><input type="text" id="phone" name="phone" value="{$phone}"></td>
                </tr>
                <tr>
                    <td>Адрес</td>
                    <td><textarea id="address" name="address">{$address}</textarea></td>
                </tr>
            </table>
        </div>
    {else}
        <div id="loginBox">
            <div id="menuCaption">Авторизация</div>
            <table>
                <tr>
                    <td>Логин</td>
                    <td><input type="text" id="loginEmail" name="loginEmail" value=""/></td>
                </tr>
                <tr>
                    <td>Пароль</td>
                    <td><input type="password" id="loginPwd" name="loginPwd" value=""/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="button" onclick="login();" value="Войти"></td>
                </tr>
            </table>
        </div>
        <div id="registerBox">или <br/>
            <div class="menuCaption">Регитсрация нового пользователя:</div>
            email* :<br/>
            <input type="text" id="email" name="email" value=""/><br/>
            пароль* :<br/>
            <input type="password" id="pwd1" name="pwd1" value=""/><br/>
            повторить пароль* :<br/>
            <input type="password" id="pwd2" name="pwd2" value=""/><br/>

            имя* :<input type="text" id="name" name="name" value=""/><br/>
            телефон* :<input type="text" id="phone" name="phone" value=""/><br/>
            алрес* :<textarea id="address" name="address"></textarea><br/>

            <input type="button" onclick="registerNewUser();" value="зарегестрироваться"/>
        </div>
        {$buttonClass = "class='hideme'"}
    {/if}

    <input type="button" {$buttonClass} id="btnSaveOrder" value="Оформить Заказ" onclick="saveOrder();"/>
</form>