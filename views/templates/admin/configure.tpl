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
