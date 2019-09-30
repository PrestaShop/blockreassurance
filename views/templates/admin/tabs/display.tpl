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
