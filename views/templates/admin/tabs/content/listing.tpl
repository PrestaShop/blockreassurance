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

<div id="reminder_listing" class="panel panel-default col-lg-10 col-lg-offset-1 col-xs-12 col-xs-offset-0">
    <div class="panel-heading">
        {l s='Block Content' d='Modules.Blockreassurance.Admin'}
      <span class="psre-add"><i class="material-icons">add_circle</i></span>
    </div>
    <div class="panel-body first-body">
        <div class="clearfix">
            <div class="listing-table col-xs-12">
                <div class="listing-head row">
                    <div class="col-xs-1 content-header">{l s='Position' d='Modules.Blockreassurance.Admin'}</div>
                    <div class="col-xs-1 content-header">{l s='Image' d='Modules.Blockreassurance.Admin'}</div>
                    <div class="col-xs-2 content-header">{l s='Title' d='Modules.Blockreassurance.Admin'}</div>
                    <div class="col-xs-4 content-header">{l s='Description' d='Modules.Blockreassurance.Admin'}</div>
                    <div class="col-xs-2 content-header">{l s='Redirection' d='Modules.Blockreassurance.Admin'}</div>
                    <div class="col-xs-2 content-header">{l s='Actions' d='Modules.Blockreassurance.Admin'}</div>
                </div>
                <div class="listing-body col-lg-12  col-xs-12">
                    {foreach from=$allblock item=$block key=$key}
                        <div data-id='' class="listing-general-rol row"
                             data-block='{$block.id_psreassurance}'>
                            <div class="listing-row row">
                                <div class="col-xs-1">
                                    <i class="material-icons">drag_indicator</i>
                                </div>
                                <div class="col-xs-1">
                                    {if $block['icon'] != 'undefined'}
                                        <img class="svg"
                                             src="{if $block['icon']}{$block['icon']}{else if $block['custom_icon']}{$block['custom_icon']}{/if}"
                                        />
                                    {else}
                                        {l s='none' d='Modules.Blockreassurance.Admin'}
                                    {/if}
                                </div>
                                <div class="col-xs-2">
                                    {$block['title']}
                                </div>
                                <div class="col-xs-4">
                                    {$block['description']}
                                </div>
                                <div class="col-xs-2">
                                    {if $block['type_link'] == $LINK_TYPE_NONE}
                                        {l s='None' d='Modules.Blockreassurance.Admin'}
                                    {elseif $block['type_link'] == $LINK_TYPE_URL}
                                        {l s='Url link' d='Modules.Blockreassurance.Admin'}
                                    {elseif $block['type_link'] == $LINK_TYPE_CMS}
                                        {l s='CMS Page' d='Modules.Blockreassurance.Admin'}
                                    {/if}
                                </div>
                                <div class="col-xs-2 inline-flex">
                                    <label class="col-lg-12 col-xs-12"
                                           id="reminder_active_{$block['id_psreassurance']}"
                                           for="reminder_active_{$block['id_psreassurance']}"
                                           data-cart_psreassurance_id='{$block['id_psreassurance']}'>
                                        <section class="switch-input {if $block['status']}-checked{/if}">
                                            <input data-toggle="switch" class="switch-new" data-inverse="true"
                                                   type="checkbox" name="reminder_active_{$block['id_psreassurance']}"
                                                   checked="">
                                        </section>
                                        <span class="switch_text switch-on" style="{if !$block['status']}display:none;{/if}">{l s='Activated' d='Modules.Blockreassurance.Admin'}</span>
                                        <span class="switch_text switch-off" style="{if $block['status']}display:none;{/if}">{l s='Deactivated' d='Modules.Blockreassurance.Admin'}</span>
                                    </label>

                                    <span class="psre-edit" data-id="{$block['id_psreassurance']}"><i
                                                class="material-icons">edit</i></span>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xs-12">
                                <div id="_more_info" class="col-lg-12 more_info ajax_return"></div>
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
        <div class="msgRecommendation">
            {l s='We recommend 3 blocks at maximum.' d='Modules.Blockreassurance.Admin'}
        </div>
    </div>
</div>
