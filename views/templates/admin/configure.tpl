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

<div class="bootstrap">
    <div class="page-head custom-tab">
        <div class="page-head-tabs" id="head_tabs">
            <ul class="nav">
                <li class="active">
                    <a href="#pscontent" data-toggle="tab">{l s='Content' d='Modules.Blockreassurance.Admin'}</a>
                </li>
                <li>
                    <a href="#display" data-toggle="tab">{l s='Display' d='Modules.Blockreassurance.Admin'}</a>
                </li>
                <li>
                    <a href="#appearance" data-toggle="tab">{l s='Appearance' d='Modules.Blockreassurance.Admin'}</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="bootstrap" id="psreassurance_configuration">
    <!-- Module content -->
    <div id="modulecontent" class="clearfix">
        <!-- Tab panes -->
        <div class="tab-content row">
            {if !$folderIsWritable}
                {include file="./alert_folder_writable.tpl"}
            {/if}
            <div class="tab-pane active" id="pscontent">
                <div class="tab_cap_listing">
                    {include file="./tabs/content.tpl"}
                </div>
            </div>
            <div class="tab-pane" id="display">
                <div class="tab_cap_listing">
                    {include file="./tabs/display.tpl"}
                </div>
            </div>
            <div class="tab-pane" id="appearance">
                <div class="tab_cap_listing">
                    {include file="./tabs/appearance.tpl"}
                </div>
            </div>
        </div>
    </div>
</div>
