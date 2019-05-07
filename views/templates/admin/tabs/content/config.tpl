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

<div id="blockDisplay" class="panel panel-default col-lg-10 col-xs-10 col-lg-offset-1 col-xs-offset-1 inactive" >
    <div class="panel-heading">
        {l s='Reassurance Block' mod='psreassurance'}
    </div>
    {include file="./config_elements/reassurance_block.tpl"}
    {foreach from=$allblock item=$aBlock key=$key}
    <form class="form_{$aBlock['id_psreassurance']}" method="post" ENCTYPE="multipart/form-data">
        <div class="panel-body-{$aBlock['id_psreassurance']} show-rea-block inactive" >
            {* icon *}
            {include file="./config_elements/icon.tpl"}
            {* language *}
            {include file="./config_elements/language.tpl"}
            {foreach from=$languages item=language}
                {* title *}
                {include file="./config_elements/title.tpl"}
                {* description *}
                {include file="./config_elements/description.tpl"}
            {/foreach}
            {* redirection *}
            {include file="./config_elements/redirection.tpl"}
            {* CMS *}
            {include file="./config_elements/cms.tpl"}
            {* URL *}
            {include file="./config_elements/url.tpl"}
        </div>
    </form>
    {/foreach}
    <div class="panel-footer">
        <div class="col-lg-10 col-xs-10"><button name="refreshPage" type="submit" class="btn btn-secondary refreshPage">{l s='Return' mod='psreassurance'}</button></div>
        <div class="col-lg-1 col-xs-1">
            {* <button name="saveContentConfiguration" id="saveContentConfiguration" data-id="" type="submit" class="btn btn-primary">{l s='Save' mod='psreassurance'}</button> *}
            <input name="saveContentConfiguration" id="saveContentConfiguration" data-id="" type="submit" class="btn btn-primary" value="{l s='Save' mod='psreassurance'}">
        </div>
    </div>
</div>
