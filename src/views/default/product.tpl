{* страница продукта *}

{include file="header.tpl"}

<h3>{$rsProduct['name']}</h3>

<img width="575" src="/images/products/{$rsProduct['image']}">
Стоимость: {$rsProduct['price']}


<a id="removeCart_{$rsProduct['id']}" {if $itemInCart == 0}style="display: none" {/if} href="" alt="Удалить из корзины"
   onclick="removeFromCart({$rsProduct['id']});return false">
    Удалить из корзины
</a>
<a id="addCart_{$rsProduct['id']}" {if $itemInCart == 1}style="display: none" {/if} href="" alt="Добавить в корзину"
   onclick="addToCart({$rsProduct['id']});return false">
    Добавить в корзину
</a>

<p>Описание: <br/>{$rsProduct['description']}</p>

{include file="footer.tpl"}