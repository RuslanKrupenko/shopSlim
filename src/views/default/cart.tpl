{* шаблон корзины *}

{include file="header.tpl"}

<h1>Корзина</h1>

{if !$rsProducts}
    В корзине пусто
{else}
    <form action="/cart/order" method="post">
        <h2>Данные заказа</h2>
        <table>
            <tr>
                <td>№</td>
                <td>Наименование</td>
                <td>Количество</td>
                <td>Цена за еденицу</td>
                <td>Сумма</td>
                <td>Действие</td>
            </tr>
            {foreach $rsProducts as $item name=products}
                <tr>
                    <td>{$smarty.foreach.products.iteration}</td>
                    <td><a href="/?controller=product&id={$item['id']}">{$item['name']}</a></td>
                    <td>
                        <input type="text" name="itemCnt_{$item['id']}" id="itemCnt_{$item['id']}" value="1"
                               onchange="conversionPrice({$item['id']});"/>
                    </td>
                    <td>
                    <span id="itemPrice_{$item['id']}" value="{$item['price']}">
                        {$item['price']}
                    </span>
                    </td>
                    <td>
                    <span id="itemRealPrice_{$item['id']}">
                        {$item['price']}
                    </span>
                    </td>
                    <td>
                        <a id="removeCart_{$item['id']}" href="" onclick="removeFromCart({$item['id']}); return false;"
                           title="Удалить из корзины">Удалить</a>
                        <a id="addCart_{$item['id']}" href="" style="display: none"
                           onclick="addToCart({$item['id']}); return false;"
                           title="Восстановить элемент">Восстановить</a>
                    </td>
                </tr>
            {/foreach}
        </table>
        <input type="submit" value="Оформить заказ"/>
    </form>
{/if}

{include file="footer.tpl"}