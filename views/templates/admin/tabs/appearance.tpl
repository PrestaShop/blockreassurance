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

<div class="panel panel-default col-lg-10 col-lg-offset-1 col-md-12 col-md-offset-0" >
    <div class="panel-heading">
        {l s='Customize Module Design' mod='psreassurance'}
    </div>

    <div class="panel-body">
        <div class="clearfix">

            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                    <div class="text-right">
                        <label class="control-label">
                            {l s='Icon color' mod='psreassurance'}
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-2">
                    <div class="ps_colorpicker1"></div>
                    <input type="hidden" class="psr_icon_color" name="PSR_ICON_COLOR" value="{if isset($psr_icon_color)}{$psr_icon_color|escape:'htmlall':'UTF-8'}{/if}" id="color_1" style="background-color:{if isset($psr_icon_color)}{$psr_icon_color|escape:'htmlall':'UTF-8'}{/if}; color: back;">
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                    <div class="text-right">
                        <label class="control-label">
                            {l s='Text color' mod='psreassurance'}
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-2">
                    <div class="ps_colorpicker2"></div>
                    <input type="hidden" class="psr_text_color" name="PSR_TEXT_COLOR" value="{if isset($psr_text_color)}{$psr_text_color|escape:'htmlall':'UTF-8'}{/if}" id="color_2" style="background-color:{if isset($psr_text_color)}{$psr_text_color|escape:'htmlall':'UTF-8'}{/if}; color: back;">
                </div>
            </div>

        </div>
    </div>

    <div class="panel-footer">
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-offset-11">
            <button name="saveConfiguration" id="saveConfiguration" type="submit" class="btn btn-primary">{l s='Save' mod='psreassurance'}</button>
        </div>
    </div>

</div>