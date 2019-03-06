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

<div id="reminder_listing" class="panel panel-default col-lg-10 col-lg-offset-1 col-md-12 col-md-offset-0" >
    <div class="panel-heading">
        {l s='Block Content' mod='psreassurance'} (3)
    </div>
    <div class="panel-body first-body">
        <div class="clearfix">
            <div class="listing-table col-lg-12">
                <div class="listing-head col-lg-12">
                    <div class="col-lg-1 content-header">{l s='Position' mod='psreassurance'}</div>
                    <div class="col-lg-1 content-header">{l s='Image' mod='psreassurance'}</div>
                    <div class="col-lg-1 block-title content-header">{l s='Title' mod='psreassurance'}</div>
                    <div class="col-lg-5 content-header">{l s='Description' mod='psreassurance'}</div>
                    <div class="col-lg-1 content-header">{l s='Redirection' mod='psreassurance'}</div>
                    <div class="col-lg-2 content-header">{l s='Actions' mod='psreassurance'}</div>
                </div>
                <div class="listing-body col-lg-12">
                    {foreach from=$allblock item=$aBlock key=$key}
                    <div data-id='' class="listing-general-rol col-lg-12">
                        <div class="listing-row col-lg-12">
                            <div class="col-lg-1">
                                <i class="material-icons">drag_indicator</i>
                            </div>
                            <div class="col-lg-1">
                                <i class="material-icons psrea-color">{$aBlock['icone']}</i>
                            </div>
                            <div class="col-lg-1 block-title">
                                {$aBlock['title']}
                            </div>
                            <div class="col-lg-5">
                                {$aBlock['description']}
                            </div>
                            <div class="col-lg-1">
                                {if $aBlock['type_link'] == 0}
                                    {l s='none' mod='psreassurance'}
                                {else if $aBlock['type_link'] == 2}
                                    {l s='Url link' mod='psreassurance'}
                                {else if $aBlock['type_link'] == 1}
                                    {l s='CMS Page' mod='psreassurance'}
                                {/if}

                            </div>
                            <div class="col-lg-2 inline-flex">
                                <label class="col-lg-12" id="reminder_active_{$key}" for="reminder_active_{$key}" data-cart_psreassurance_id='{$aBlock['id_psreassurance']}'>
                                    <section class="switch-input {if $aBlock['status']}-checked{/if}">
                                        <input data-toggle="switch" class="switch-new" data-inverse="true" type="checkbox" name="reminder_active_{$key}" checked="">
                                    </section>
                                    <span class="switch_text switch-on" style="{if !$aBlock['status']}display:none;{/if}">{l s='Activated' mod='cartabandonmentpro'}</span>
                                    <span class="switch_text switch-off" style="{if $aBlock['status']}display:none;{/if}">{l s='Deactivated' mod='cartabandonmentpro'}</span>
                                </label>

                                <span class="psre-edit" data-id="{$key}"><i class="material-icons">edit</i></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div id="_more_info" class="col-lg-12 more_info ajax_return"></div>
                        </div>
                    </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
</div>

<div id="blockDisplay" class="panel panel-default col-lg-10 col-lg-offset-1 col-md-12 col-md-offset-0 inactive" >
    <div class="panel-heading">
        {l s='Reassurance Block' mod='psreassurance'}
    </div>
    {foreach from=$allblock item=$aBlock key=$key}
    <form class="form_{$key}" method="post" ENCTYPE="multipart/form-data">
    <div class="panel-body-{$key} show-rea-block inactive" >
{* icon *}
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3 first-block">
                <div class="text-right">
                    <label class="control-label">
                        {l s='Image' mod='psreassurance'}
                    </label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-4 first-block">
                <div class="input-group col-lg-4">
                    <span class="psr-picto" data-image="{$allblock[{$key}]['icone']}"><i class="material-icons psrea-color picto-edit">{$allblock[{$key}]['icone']}</i></span>
                    {if isset($slide)}
                        <img class="image-preview-lang" width="24px" height="24px" class="img-thumbnail" src="urlimage" alt="" />
                    {else}
                        <span class="psr-picto">
                            <img class="image-preview-lang" class="img-thumbnail hide" src="" alt="" width="24px" height="24px"/>
                        </span>
                    {/if}
                    <span class="modify_icon" data-id="{$key}">{l s='Modify icon' mod='psreassurance'}</span>
                    <div id="show_icon_{$key}" class="col-xs-12 col-sm-12 col-md-7 col-lg-12 show_icon inactive">
                        <div class="bootstrap">
                            <div class="page-body custom-tab">
                                <div class="page-body-tabs" id="body_tabs">
                                    <ul class="nav">
                                        <li class="active">
                                            <a href="#pspublic" data-toggle="tab"><i class="material-icons">public</i></a>
                                        </li>
                                        <li>
                                            <a href="#pack2" data-toggle="tab"><img src="{$img_path}/ITIcons/pack2_globe.svg" style="width:24px"></a>
                                        </li>
                                        <li>
                                            <a href="#pack3" data-toggle="tab"><img src="{$img_path}/Essentials/pack2_globe.svg" style="width:24px"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="bootstrap" id="psr-icon-list">
                            <div id="psrcontent" class="clearfix">
                                <div class="tab-content row" style="background-color:white;width:250px;height:335px">
                                    <div class="tab-pane active" id="pspublic">
                                        <div class="tab_cap_listing">
                                            <span class="select-icon"><i class="material-icons show_demo" data-id="{$key}">mood</i></span>
                                            <span class="select-icon"><i class="material-icons show_demo" data-id="{$key}">local_shipping</i></span>
                                            <span class="select-icon"><i class="material-icons show_demo" data-id="{$key}">loop</i></span>
                                            <span class="select-icon"><i class="material-icons show_demo" data-id="{$key}">credit_card</i></span>
                                            <span class="select-icon"><i class="material-icons show_demo" data-id="{$key}">public</i></span>
                                            <span class="select-icon"><i class="material-icons show_demo" data-id="{$key}">thumb_up</i></span>
                                            <span class="select-icon"><i class="material-icons show_demo" data-id="{$key}">card_giftcard</i></span>
                                            <span class="select-icon"><i class="material-icons show_demo" data-id="{$key}">touch_app</i></span>
                                            <span class="select-icon"><i class="material-icons show_demo" data-id="{$key}">headset_mic</i></span>
                                            <span class="select-icon"><i class="material-icons show_demo" data-id="{$key}">timer</i></span>
                                            <span class="select-icon"><i class="material-icons show_demo" data-id="{$key}">lock</i></span>
                                            <span class="select-icon"><i class="material-icons show_demo" data-id="{$key}">loyalty</i></span>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="pack2">
                                        <div class="tab_cap_listing">
                                            <span class="select-icon"><img src="{$img_path}/ITIcons/pack2_satisfaction.svg" style="width:74px;color:red;"></span>
                                            <span class="select-icon"><img src="{$img_path}/ITIcons/pack2_support.svg" style="width:74px"></span>
                                            <span class="select-icon"><img src="{$img_path}/ITIcons/pack2_phone.svg" style="width:74px"></span>
                                            <span class="select-icon"><img src="{$img_path}/ITIcons/pack2_globe.svg" style="width:74px"></span>
                                            <span class="select-icon"><img src="{$img_path}/ITIcons/pack2_trust.svg" style="width:74px"></span>
                                            <span class="select-icon"><img src="{$img_path}/ITIcons/pack2_creditcard.svg" style="width:74px"></span>
                                            <span class="select-icon"><img src="{$img_path}/ITIcons/pack2_hotline.svg" style="width:74px"></span>
                                            <span class="select-icon"><img src="{$img_path}/ITIcons/pack2_parcel.svg" style="width:74px"></span>
                                            <span class="select-icon"><img src="{$img_path}/ITIcons/pack2_return.svg" style="width:74px"></span>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="pack3">
                                        <div class="tab_cap_listing">
                                            <span class="select-icon"><img class="svg" src="{$img_path}/Essentials/pack2_return.svg" style="width:74px"></span>
                                            <span class="select-icon"><img src="{$img_path}/Essentials/pack2_clock.svg" style="width:74px"></span>
                                            <span class="select-icon"><img src="{$img_path}/Essentials/pack2_globe.svg" style="width:74px"></span>
                                            <span class="select-icon"><img src="{$img_path}/Essentials/pack2_gift.svg" style="width:74px"></span>
                                            <span class="select-icon"><img src="{$img_path}/Essentials/pack2_satisfaction.svg" style="width:74px"></span>
                                            <span class="select-icon">

                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <span class="select-none">{l s='Select none' mod='psreassurance'}</span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="input-group">
                    <input type="text" class="slide_url" value="" name="slide-image-lang" class="form-control" readonly>
                    <label class="input-group-btn">
                        <span>
                            <i class="icon-file"></i><input class="slide_image" data-preview="image-preview-lang" type="file" name="image-lang" style="display: none;">
                        </span>
                    </label>
                </div>
                <div class="help-block">
                    {l s='Choose SVG for best customization. Other accepted file formats: jpg, png, gif' mod='psreassurance'}
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
{* icon *}
{* language *}
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                {if $languages|count > 1}
                <div class="text-right">
                    <label class="control-label">
                        {l s='Languages' mod='psreassurance'}
                    </label>
                </div>
                {/if}
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-4">
                <div class="input-group col-lg-12">
                    {if $languages|count > 1}
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-12">
                        <select class="custom-select" name="psr-language">
                            {foreach from=$languages item=lang}
                                <option {if $lang.id_lang == $defaultFormLanguage}selected="selected"{/if} value="{$lang.id_lang}">{$lang.name|escape:'htmlall':'UTF-8'}</option>
                            {/foreach}
                        </select>
                    </div>
                    {/if}
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
{* language *}
        {foreach from=$languages item=language}
{* title *}
        <div class="form-group content_by_lang lang-{$language.id_lang|escape:'htmlall':'UTF-8'} {if $language.id_lang != $defaultFormLanguage}inactive{/if}" data-type="title" data-lang="{$language.id_lang|escape:'htmlall':'UTF-8'}">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                <div class="text-right">
                    <label class="control-label">
                        {l s='Title' mod='psreassurance'}
                    </label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-4">
                <div class="input-group col-lg-12">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-12">
                        <input type="text" name="title-{$language.id_lang|escape:'htmlall':'UTF-8'}" max="100" class="form-control" value="{$allblockByShop[{$language.id_lang}][$aBlock['id_psreassurance']]['title']}">
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
{* title *}

{* description *}
        <div class="form-group content_by_lang lang-{$language.id_lang|escape:'htmlall':'UTF-8'} {if $language.id_lang != $defaultFormLanguage}inactive{/if}" data-type="description" data-lang="{$language.id_lang|escape:'htmlall':'UTF-8'}">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                <div class="text-right">
                    <label class="control-label">
                        {l s='Description (optional)' mod='psreassurance'}
                    </label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-4">
                <div class="input-group col-lg-12">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-12">
                        <input type="text" name="description-{$language.id_lang|escape:'htmlall':'UTF-8'}" max="100" class="form-control" value="{$allblockByShop[{$language.id_lang}][$aBlock['id_psreassurance']]['description']}">
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
{* description *}
        {/foreach}
{* redirection *}
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
                        <input type="radio" name="PSR_REDIRECTION_{$key}" value="0" {if $aBlock['type_link'] == 0} checked="checked"{/if}>
                        <label for="PSR_REDIRECTION" class="input-redirection"><span><span></span></span>{l s='None' mod='psreassurance'}</label>
                        <input type="radio" name="PSR_REDIRECTION_{$key}" value="1" {if $aBlock['type_link'] == 1} checked="checked"{/if}>
                        <label for="PSR_REDIRECTION" class="input-redirection"><span><span></span></span>{l s='CMS page' mod='psreassurance'}</label>
                        <input type="radio" name="PSR_REDIRECTION_{$key}" value="2" {if $aBlock['type_link'] == 2} checked="checked"{/if}>
                        <label for="PSR_REDIRECTION" class="input-redirection"><span><span></span></span>{l s='URL' mod='psreassurance'}</label>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
{* redirection *}

{* CMS *}
        <div class="form-group psr-cms {if $aBlock['type_link'] != 1} inactive{/if}">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                <div class="text-right">
                    <label class="control-label">
                        {l s='CMS Page' mod='psreassurance'}
                    </label>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-4">
                <div class="input-group col-xs-12 col-sm-12 col-md-7 col-lg-12 psrea-flex">
                    <select class="custom-select" name="ID_CMS_{$key}">
                        {foreach from=$allCms item=cms}
                            <option value="{$cms['id_cms']}" {if $aBlock['id_cms'] == $cms['id_cms']} selected="selected"{/if}>{$cms['meta_title']|escape:'htmlall':'UTF-8'}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
{* CMS *}

{* URL *}
        <div class="form-group psr-url {if $aBlock['type_link'] != 2} inactive{/if}" data-type="url">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                <div class="text-right">
                    <label class="control-label">
                        {l s='URL' mod='psreassurance'}
                    </label>
                </div>
            </div>
            {foreach from=$languages item=language}
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-4 content_by_lang lang-{$language.id_lang|escape:'htmlall':'UTF-8'} {if $language.id_lang != $defaultFormLanguage}inactive{/if}" data-type="url" data-lang="{$language.id_lang|escape:'htmlall':'UTF-8'}">
                <div class="input-group col-xs-12 col-sm-12 col-md-7 col-lg-12 psrea-flex">
                    <div class="input-group-append">
                        <span class="input-group-text picto-url"><i class="material-icons">link</i></span>
                    </div>
                    <input type="text" name="URL" class="form-control" value="{$allblockByShop[{$language.id_lang}][$aBlock['id_psreassurance']]['url']}">
                </div>
            </div>
            {/foreach}
            <div class="clearfix"></div>
        </div>
{* URL *}

    </div>
    </form>
    {/foreach}
    <div class="panel-footer">
        <div class="col-lg-11"><button name="refreshPage" type="submit" class="btn btn-secondary refreshPage">{l s='Return' mod='psreassurance'}</button></div>
        <div class="col-lg-1">
            {* <button name="saveContentConfiguration" id="saveContentConfiguration" data-id="" type="submit" class="btn btn-primary">{l s='Save' mod='psreassurance'}</button> *}
            <input name="saveContentConfiguration" id="saveContentConfiguration" data-id="" type="submit" class="btn btn-primary" value="{l s='Save' mod='psreassurance'}">
        </div>
    </div>

</div>

{* <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div id="labelList">
        <div id="state_sortable">
            <div v-for="(state, index) in states" class="state" :id="state.id_state">
                <div class="panel panel-drag">
                    <div class="row">
                        <div class="col-lg-1">
                            <span><i class="icon-arrows "></i></span>
                        </div>
                        <div class="col-md-8">
                            <h4 class="pull-left">
                                #(( state.id_state )) - (( state.state ))
                            </h4>
                            <div class="btn-group-action pull-right">
                                <a v-if="state.active == 1" @click="toggleActive(state.id_state, 'disable', index)" class="btn btn-success">
                                    <i class="icon-check"></i>
                                    {l s='Enabled' mod='printlabels'}
                                </a>
                                <a v-if="state.active == 0" @click="toggleActive(state.id_state, 'enable', index)" class="btn btn-danger">
                                    <i class="icon-remove"></i>
                                    {l s='Disabled' mod='printlabels'}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> *}