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

<div id="reminder_listing" class="panel panel-default panel-blockreassurance col-lg-10 col-lg-offset-1 col-xs-12 col-xs-offset-0">
    <div class="panel-heading">
        {l s='Block Content' d='Modules.Blockreassurance.Admin'}
      <span class="psre-add"><i class="material-icons">add_circle</i></span>
    </div>
    <div class="panel-body first-body">
        <div class="clearfix">
            <div class="listing-table col-xs-12">
                <div class="listing-head row">
                    <div class="col-lg-1 col-md-1 col-sm-1 hidden-xs content-header">{$fields_captions.position}</div>
                    <div class="col-lg-1 col-md-1 col-sm-1 hidden-xs content-header">{$fields_captions.image}</div>
                    <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs content-header">{$fields_captions.title}</div>
                    <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs content-header">{$fields_captions.description}</div>
                    <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs content-header">{$fields_captions.redirection}</div>
                    <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs content-header">{$fields_captions.actions}</div>
                </div>
                <div id="list-blockreassurance" class="listing-body col-lg-12 col-xs-12">
                    {foreach from=$allblock item=$block key=$key}
                        <div class="listing-general-rol row" data-block="{$block.id_psreassurance}">
                            <div class="listing-row row">
                                <div class="hidden-lg hidden-md hidden-sm col-xs-4">
                                    {$fields_captions.position}
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-8">
                                    <a class="toolbar-button" href="#">
                                        <i class="material-icons">drag_handle</i>
                                    </a>
                                </div>
                                <div class="hidden-lg hidden-md hidden-sm col-xs-4">
                                    {$fields_captions.image}
                                </div>                                
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-8">
                                    {if $block['icon'] != 'undefined'}
                                        <img class="svg"
                                             src="{if $block['icon']}{$block['icon']}{else if $block['custom_icon']}{$block['custom_icon']}{/if}"
                                        />
                                    {else}
                                        {l s='none' d='Modules.Blockreassurance.Admin'}
                                    {/if}
                                </div>
                                <div class="hidden-lg hidden-md hidden-sm col-xs-4">
                                    {$fields_captions.title}
                                </div>                                
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-8">
                                    {$block['title'][{$defaultFormLanguage}]}
                                </div>
                                <div class="hidden-lg hidden-md hidden-sm col-xs-4">
                                    {$fields_captions.description}
                                </div>                                
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-8">
                                    {$block['description'][{$defaultFormLanguage}]}
                                </div>
                                <div class="hidden-lg hidden-md hidden-sm col-xs-4">
                                    {$fields_captions.redirection}
                                </div>                                
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-8">
                                    {if $block['type_link'] == $LINK_TYPE_NONE}
                                        {l s='None' d='Modules.Blockreassurance.Admin'}
                                    {elseif $block['type_link'] == $LINK_TYPE_URL}
                                        {l s='Url link' d='Modules.Blockreassurance.Admin'}
                                    {elseif $block['type_link'] == $LINK_TYPE_CMS}
                                        {l s='CMS Page' d='Modules.Blockreassurance.Admin'}
                                    {/if}
                                </div>
                                <div class="hidden-lg hidden-md hidden-sm col-xs-4">
                                    {$fields_captions.actions}
                                </div>                                
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-8 inline-flex">
                                    <label class="col-lg-12 col-xs-12 status-toggle"
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
                                    <div class="btn-group">
                                        <button class="btn btn-link dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu" x-placement="bottom-start">
                                            <span class="dropdown-item psre-edit" data-id="{$block['id_psreassurance']}"><i class="material-icons">mode_edit</i> {l s='Edit' d='Admin.Actions'}</span>
                                            <span class="dropdown-item psre-delete" data-id="{$block['id_psreassurance']}"><i class="material-icons">delete</i> {l s='Delete' d='Admin.Actions'}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-xs-12">
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
