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

<div class="tag-default">
    {foreach from=$blocks item=$block key=$key}
        <div class="resize" {if $block['type_link'] != 0 && $block['link'] != ''} onclick="window.open('{$block['link']}')"{/if} style="{if $block['type_link'] != 0 && $block['link'] != ''}cursor:pointer;{/if}">
            <span style="float:left;width:35px;display:inline-block;height:35px;padding-top:5px;margin-right:5px;">{if $block['icone'] != 'undefined'}<img class="svg" src="{if $block['icone']}{$block['icone']}{else if $block['icone_perso']}{$block['icone_perso']}{/if}" style="width:35px;">{/if}&nbsp;</span>
            <span style="color:{$textColor};font-weight:bold">{$block['title']}<span>
            <p style="color:{$textColor};">{$block['description']}</p>
        </div>
    {/foreach}
    <div class="clearfix"></div>
</div>