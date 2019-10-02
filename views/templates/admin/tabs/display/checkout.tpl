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

<div class="panel panel-default col-lg-12 col-xs-12">
    <div class="panel-heading">
        {l s='Specific position for cart page' d='Modules.Blockreassurance.Admin'}
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 position-hook">
        <label class="col-lg-3 col-lg-offset-1 col-xs-3 col-xs-offset-1">
            <div class="help-block customradiodesign">
                <input type="radio" class="input_img js-show-all" name="PSR_HOOK_CHECKOUT" value="1"
                       id="PSR_HOOK_CHECKOUT" {if $psr_hook_checkout eq 1}checked="checked"{/if} />
                <label for="PSR_HOOK_CHECKOUT"><span><span></span></span>{l s='Main column' d='Modules.Blockreassurance.Admin'}</label><br/><br/>
                <img src="{$img_path}displayReassurance_active.jpg" width="150" height="150"
                     class="psr-checkout-color{if $psr_hook_checkout eq 1} active{/if}" />
                <img src="{$img_path}displayReassurance_inactive.jpg" width="150" height="150"
                     class="psr-checkout-grey {if $psr_hook_checkout neq 1} active{/if}" />
            </div>
        </label>
        <label class="col-lg-3 col-lg-offset-1 col-xs-3 col-xs-offset-1">
            <div class="help-block customradiodesign">
                <input type="radio" class="input_img" name="PSR_HOOK_CHECKOUT" value="0" id="PSR_HOOK_CHECKOUT_0"
                       {if $psr_hook_checkout eq 0}checked="checked"{/if} />
                <label for="PSR_HOOK_CHECKOUT_0"><span><span></span></span>{l s='none' d='Modules.Blockreassurance.Admin'}</label><br/><br/>
                <img src="{$img_path}productPage_none.jpg" width="150" height="150" />
            </div>
        </label>
    </div>

</div>
