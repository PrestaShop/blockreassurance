{*
* 2007-2019 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2019 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<div class="blockreas">
    {assign var=numCols value=$blocks|@count}
    {assign var=numColsRemaining value=($numCols % 4)}
    {foreach from=$blocks item=$block key=$key name=blocks}
        {assign var=idxCol value=($smarty.foreach.blocks.index + 1)}
        {assign var=sizeCol value=3}
        {assign var=offsetCol value=""}
        {if $idxCol > ($numCols - $numColsRemaining)}
            {if $numColsRemaining == 2}
                {if !$smarty.foreach.blocks.last}
                    {assign var=offsetCol value="offset-sm-3"}
                {/if}
            {else}
                {assign var=sizeCol value=(12 / $numColsRemaining)}
            {/if}
        {/if}
        <div class="reass-item col-sm-{$sizeCol} {$offsetCol}" style="{if $block['type_link'] !== $LINK_TYPE_NONE && !empty($block['link'])}cursor:pointer;{/if}"
                {if ($block['type_link'] !== $LINK_TYPE_NONE) && !empty($block['link'])} onclick="window.open('{$block['link']}')"{/if}>
            <div class="block-icon">
                {if $block['icon'] != 'undefined'}
                    {if $block['icon']}
                        <img class="svg invisible" src="{$block['icon']}"">
                    {elseif $block['custom_icon']}
                        <img src="{$block['custom_icon']}">
                    {/if}
                {/if}
            </div>
            <div class="block-title" style="color:{$textColor}">{$block['title']}</div>
            <p style="color:{$textColor};">{$block['description'] nofilter}</p>
        </div>
    {/foreach}
    <div class="clearfix"></div>
</div>
