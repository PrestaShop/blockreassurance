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
<div class="container container-blockreassurance">
    <div class="blockreassurance">
        {assign var=numCols value=$blocks|@count}
        {assign var=numColsRemaining_md value=($numCols % 4)}
        {assign var=numColsRemaining_sm value=($numCols % 2)}
        <div class="row">
        {foreach from=$blocks item=$block key=$key name=blocks}
            {assign var=idxCol value=($smarty.foreach.blocks.index + 1)}
            {assign var=sizeCol_md value=3}
            {assign var=offsetCol_md value="offset-md-0"}
            {assign var=sizeCol_sm value=6}
            {assign var=offsetCol_sm value="offset-sm-0"}
            {if $idxCol > ($numCols - $numColsRemaining_md)}
                {if $numColsRemaining_md == 2}
                    {if !$smarty.foreach.blocks.last}
                        {assign var=offsetCol_md value="offset-md-3"}
                    {/if}
                {else}
                    {assign var=sizeCol_md value=(12 / $numColsRemaining_md)}
                {/if}
            {/if}
            {if $idxCol > ($numCols - $numColsRemaining_sm)}
                {if $numColsRemaining_md == 1}
                    {assign var=offsetCol_sm value="offset-sm-3"}
                {else}
                    {assign var=sizeCol_sm value=(12 / $numColsRemaining_md)}
                {/if}
            {/if}
            <div class="col-md-{$sizeCol_md} {$offsetCol_md} col-sm-{$sizeCol_sm} {$offsetCol_sm} col-xs-12"
                {if $block['type_link'] !== $LINK_TYPE_NONE && !empty($block['link'])} style="cursor:pointer;" onclick="window.open('{$block['link']}')"{/if}>
                <div class="block-icon">
                    {if $block['icon'] != 'undefined'}
                        {if $block['icon']}
                            <img class="svg invisible" src="{$block['icon']}">
                        {elseif $block['custom_icon']}
                            <img src="{$block['custom_icon']}">
                        {/if}
                    {/if}
                </div>
                <div class="block-title" style="color:{$textColor}">{$block['title']}</div>
                <p style="color:{$textColor};">{$block['description'] nofilter}</p>
            </div>
            {if $idxCol % 4 == 0}</div><div class="row">{/if}
        {/foreach}
        </div>
    </div>
</div>
