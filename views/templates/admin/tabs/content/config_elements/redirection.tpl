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

<div class="form-group">
    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
        <div class="text-right">
            <label class="control-label">
                {l s='Redirection' d='Modules.Blockreassurance.Admin'}
            </label>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-4">
        <div class="input-group col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-12 customradiodesign">
                <div>
                    <input id="PSR_REDIRECTION_NONE_{if isset($block)}{$block['id_psreassurance']}{/if}" type="radio"
                           name="PSR_REDIRECTION_{if isset($block)}{$block['id_psreassurance']}{/if}"
                           value="{$LINK_TYPE_NONE}" {if (isset($block) && $block['type_link'] == $LINK_TYPE_NONE) || !isset($block)} checked="checked"{/if}>

                    <label for="PSR_REDIRECTION_NONE_{if isset($block)}{$block['id_psreassurance']}{/if}"
                         class="input-redirection"><span><span></span></span>{l s='None' d='Modules.Blockreassurance.Admin'}</label>
                </div>
                <div>
                    <input id="PSR_REDIRECTION_CMS_{if isset($block)}{$block['id_psreassurance']}{/if}" type="radio"
                           name="PSR_REDIRECTION_{if isset($block)}{$block['id_psreassurance']}{/if}"
                           value="{$LINK_TYPE_CMS}" {if isset($block) && $block['type_link'] == $LINK_TYPE_CMS} checked="checked"{/if}>

                    <label for="PSR_REDIRECTION_CMS_{if isset($block)}{$block['id_psreassurance']}{/if}"
                           class="input-redirection"><span><span></span></span>{l s='CMS page' d='Modules.Blockreassurance.Admin'}</label>
                </div>
                <div>
                  <input id="PSR_REDIRECTION_URL_{if isset($block)}{$block['id_psreassurance']}{/if}" type="radio"
                         name="PSR_REDIRECTION_{if isset($block)}{$block['id_psreassurance']}{/if}"
                         value="{$LINK_TYPE_URL}" {if isset($block) && $block['type_link'] == $LINK_TYPE_URL} checked="checked"{/if}>

                  <label for="PSR_REDIRECTION_URL_{if isset($block)}{$block['id_psreassurance']}{/if}"
                         class="input-redirection"><span><span></span></span>{l s='URL' d='Modules.Blockreassurance.Admin'}</label>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
