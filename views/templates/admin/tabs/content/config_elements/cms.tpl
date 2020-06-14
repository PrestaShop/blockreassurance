{**
 * 2007-2020 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}

<div class="form-group psr-cms {if (isset($block) && $block['type_link'] != $LINK_TYPE_CMS) || !isset($block)} inactive{/if}">
    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
        <div class="text-right">
            <label class="control-label">
                {l s='CMS Page' d='Modules.Blockreassurance.Admin'}
            </label>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-4">
        <div class="input-group col-xs-12 col-sm-12 col-md-7 col-lg-12 psrea-flex">
            <select class="custom-select" name="ID_CMS_{if isset($block)}{$block['id_psreassurance']}{/if}">
                {foreach from=$allCms item=cms}
                    <option value="{$cms['id_cms']}" {if isset($block) && $block['id_cms'] == $cms['id_cms']} selected="selected"{/if}>{$cms['meta_title']|escape:'htmlall':'UTF-8'}</option>
                {/foreach}
            </select>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
