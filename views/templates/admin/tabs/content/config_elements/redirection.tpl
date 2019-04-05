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

<div class="form-group">
    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
        <div class="text-right">
            <label class="control-label">
                {l s='Redirection' mod='psreassurance'}
            </label>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-4">
        <div class="input-group col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-12 customradiodesign">
                <input id="PSR_REDIRECTION_NONE_{$aBlock['id_psreassurance']}" type="radio" name="PSR_REDIRECTION_{$aBlock['id_psreassurance']}" value="0" {if $aBlock['type_link'] == 0} checked="checked"{/if}>
                <label for="PSR_REDIRECTION_NONE_{$aBlock['id_psreassurance']}" class="input-redirection"><span><span></span></span>{l s='None' mod='psreassurance'}</label>
                <input id="PSR_REDIRECTION_CMS_{$aBlock['id_psreassurance']}" type="radio" name="PSR_REDIRECTION_{$aBlock['id_psreassurance']}" value="1" {if $aBlock['type_link'] == 1} checked="checked"{/if}>
                <label for="PSR_REDIRECTION_CMS_{$aBlock['id_psreassurance']}" class="input-redirection"><span><span></span></span>{l s='CMS page' mod='psreassurance'}</label>
                <input id="PSR_REDIRECTION_URL_{$aBlock['id_psreassurance']}" type="radio" name="PSR_REDIRECTION_{$aBlock['id_psreassurance']}" value="2" {if $aBlock['type_link'] == 2} checked="checked"{/if}>
                <label for="PSR_REDIRECTION_URL_{$aBlock['id_psreassurance']}" class="input-redirection"><span><span></span></span>{l s='URL' mod='psreassurance'}</label>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>