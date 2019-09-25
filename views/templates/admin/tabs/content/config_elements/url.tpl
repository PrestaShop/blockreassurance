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

<div class="form-group psr-url {if (isset($block) && $block['type_link'] != $LINK_TYPE_URL) || !isset($block)} inactive{/if}" data-type="url">
    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
        <div class="text-right">
            <label class="control-label">
                {l s='URL' d='Modules.Blockreassurance.Admin'}
            </label>
        </div>
    </div>

    {foreach from=$languages item=language}
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-4 content_by_lang lang-{$language.id_lang|escape:'htmlall':'UTF-8'} {if $language.id_lang != $defaultFormLanguage}inactive{/if}"
             data-type="url" data-lang="{$language.id_lang|escape:'htmlall':'UTF-8'}">
            <div class="input-group col-xs-12 col-sm-12 col-md-7 col-lg-12 psrea-flex">
                <div class="input-group-append">
                    <span class="input-group-text picto-url"><i class="material-icons">link</i></span>
                </div>
                <input class="block_url form-control" type="text" name="URL"
                       value="{if isset($block)}{$allblockByShop[{$language.id_lang}][$block['id_psreassurance']]['url']}{/if}">
            </div>
        </div>
    {/foreach}
    <div class="clearfix"></div>
</div>
