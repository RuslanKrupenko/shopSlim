{* шаблон главной страницы *}

{include file="header.tpl"}

{foreach $rsProducts as $item name=products}
    <div style="float: left; padding: 0 30px 40px 0;">
        <a href="/product/{$item['id']}">
            <img src="/images/products/{$item['image']}" width="100"/>
        </a><br/>
        <a href="/product/{$item['id']}">{$item['name']}</a>
    </div>
    {if $smarty.foreach.products.iteration mod 3 == 0}
        <div style="clear: both;"></div>
    {/if}
    {foreachelse}
    <h3>Нет данных для отображения</h3>
{/foreach}

{include file="footer.tpl"}