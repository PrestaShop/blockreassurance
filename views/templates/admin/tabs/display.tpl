{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 *}
<div id="modulecontent module_display" class="clearfix">
    <div id="menu" class="col-lg-2 col-xs-2">
        <div class="list-group" v-on:click.prevent>
            <a href="#" class="list-group-item" v-bind:class="{ 'active': isActive('global') }" v-on:click="makeActive('global')">
                <i class="fa fa-cog"></i> {l s='Global settings' d='Modules.Blockreassurance.Admin'}
            </a>
            <a href="#" class="list-group-item" v-bind:class="{ 'active': isActive('product') }" v-on:click="makeActive('product')">
                <i class="fa fa-book"></i> {l s='Product pages' d='Modules.Blockreassurance.Admin'}
            </a>
            <a href="#" class="list-group-item" v-bind:class="{ 'active': isActive('checkout') }" v-on:click="makeActive('checkout')">
                <i class="fa fa-clock-o"></i> {l s='Checkout pages' d='Modules.Blockreassurance.Admin'}
            </a>
        </div>
    </div>
    <div class="col-lg-9 col-xs-9">
        {* list your admin tpl *}
        <div id="global" class="psr_menu addons-hide">
            {include file="./display/global.tpl"}
        </div>

        <div id="product" class="psr_menu addons-hide">
            {include file="./display/product.tpl"}
        </div>

        <div id="checkout" class="psr_menu addons-hide">
            {include file="./display/checkout.tpl"}
        </div>
    </div>

</div>

{literal}
<script type="text/javascript">
  var currentPage = "{/literal}{$currentPage|escape:'htmlall':'UTF-8'}{literal}";
  var moduleAdminLink = "{/literal}{$moduleAdminLink|escape:'htmlall':'UTF-8'}{literal}";
</script>
{/literal}
