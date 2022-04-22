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

<div class="panel panel-default panel-blockreassurance col-lg-12 col-xs-12">
    <div class="panel-heading">
        {l s='Specific position for product page' d='Modules.Blockreassurance.Admin'}
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 position-hook">
        <label class="col-lg-3 col-lg-offset-1 col-xs-3 col-xs-offset-1">
            <div class="help-block customradiodesign">
                <input type="radio" class="input_img js-show-all" name="PSR_HOOK_PRODUCT" value="1"
                       id="PSR_HOOK_PRODUCT" {if $psr_hook_product eq 1}checked="checked"{/if} />
                <label for="PSR_HOOK_PRODUCT"><span><span></span></span>{l s='Main column' d='Modules.Blockreassurance.Admin'}</label><br/><br/>
                <img src="{$img_path}displayReassurance_active.jpg" width="150" height="150"
                     class="psr-product-color{if $psr_hook_product eq 1} active{/if}" />
                <img src="{$img_path}displayReassurance_inactive.jpg" width="150" height="150"
                     class="psr-product-grey {if $psr_hook_product != 1} active{/if}" />
            </div>
        </label>
        <label class="col-lg-3 col-lg-offset-1 col-xs-3 col-xs-offset-1">
            <div class="help-block customradiodesign">
                <input type="radio" class="input_img" name="PSR_HOOK_PRODUCT" value="0" id="PSR_HOOK_PRODUCT_0"
                       {if $psr_hook_product eq 0}checked="checked"{/if} />
                <label for="PSR_HOOK_PRODUCT_0"><span><span></span></span>{l s='none' d='Modules.Blockreassurance.Admin'}</label><br/><br/>
                <img src="{$img_path}productPage_none.jpg" width="150" height="150" />
            </div>
        </label>
    </div>

</div>
