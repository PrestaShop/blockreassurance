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
        {l s='Header position on all pages' d='Modules.Blockreassurance.Admin'}
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 position-hook">
        <label class="col-lg-3 col-lg-offset-1 col-xs-3 col-xs-offset-1">
            <div class="help-block customradiodesign">
                <input type="radio" class="input_img js-show-all" name="PSR_HOOK_HEADER" value="2" id="PSR_HOOK_HEADER"
                       {if $psr_hook_header eq 2}checked="checked"{/if} />
                <label for="PSR_HOOK_HEADER"><span><span></span></span>{l s='Above header' d='Modules.Blockreassurance.Admin'}</label><br/><br/>
                <img src="{$img_path}displayTop_active.jpg" width="150" height="150"
                     class="psr-header-color{if $psr_hook_header eq 2} active{/if}" />
                <img src="{$img_path}displayTop_inactive.jpg" width="150" height="150"
                     class="psr-header-grey {if $psr_hook_header != 2}active{/if}" />
            </div>
        </label>
        <label class="col-lg-3 col-lg-offset-1 col-xs-3 col-xs-offset-1">
            <div class="help-block customradiodesign">
                <input type="radio" class="input_img" name="PSR_HOOK_HEADER" value="1" id="PSR_HOOK_HEADER_0"
                       {if $psr_hook_header eq 1}checked="checked"{/if} />
                <label for="PSR_HOOK_HEADER_0"><span><span></span></span>{l s='Below header' d='Modules.Blockreassurance.Admin'}</label><br/><br/>
                <img src="{$img_path}displayHome_active.jpg" width="150" height="150"
                     class="psr-header-color{if $psr_hook_header eq 1} active{/if}" />
                <img src="{$img_path}displayHome_inactive.jpg" width="150" height="150"
                     class="psr-header-grey {if $psr_hook_header != 1} active{/if}" />
            </div>
        </label>
        <label class="col-lg-3 col-lg-offset-1 col-xs-3 col-xs-offset-1">
            <div class="help-block customradiodesign">
                <input type="radio" class="input_img" name="PSR_HOOK_HEADER" value="0" id="PSR_HOOK_HEADER_1"
                       {if $psr_hook_header eq 0}checked="checked"{/if} />
                <label for="PSR_HOOK_HEADER_1"><span><span></span></span>{l s='None' d='Modules.Blockreassurance.Admin'}</label><br/><br/>
                <img src="{$img_path}allpage_none.jpg" width="150" height="150" />
            </div>

        </label>
    </div>

</div>

<div class="panel panel-default panel-blockreassurance col-lg-12 col-xs-12">
    <div class="panel-heading">
        {l s='Footer position on all pages' d='Modules.Blockreassurance.Admin'}
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 position-hook">
        <label class="col-lg-3 col-lg-offset-1 col-xs-3 col-xs-offset-1">
            <div class="help-block customradiodesign">
                <input type="radio" class="input_img js-show-all" name="PSR_HOOK_FOOTER" value="2" id="PSR_HOOK_FOOTER"
                       {if $psr_hook_footer eq 2}checked="checked"{/if} />
                <label for="PSR_HOOK_FOOTER"><span><span></span></span>{l s='Above footer' d='Modules.Blockreassurance.Admin'}</label><br/><br/>
                <img src="{$img_path}displayFooterBefore_active.jpg" width="150" height="150"
                     class="psr-footer-color{if $psr_hook_footer eq 2} active{/if}" />
                <img src="{$img_path}displayFooterBefore_inactive.jpg" width="150" height="150"
                     class="psr-footer-grey {if $psr_hook_footer != 2} active{/if}" />
            </div>
        </label>
        <label class="col-lg-3 col-lg-offset-1 col-xs-3 col-xs-offset-1">
            <div class="help-block customradiodesign">
                <input type="radio" class="input_img" name="PSR_HOOK_FOOTER" value="1" id="PSR_HOOK_FOOTER_0"
                       {if $psr_hook_footer eq 1}checked="checked"{/if} />
                <label for="PSR_HOOK_FOOTER_0"><span><span></span></span>{l s='Below footer' d='Modules.Blockreassurance.Admin'}</label><br/><br/>
                <img src="{$img_path}displayFooter_active.jpg" width="150" height="150"
                     class="psr-footer-color{if $psr_hook_footer eq 1} active{/if}" />
                <img src="{$img_path}displayFooter_inactive.jpg" width="150" height="150"
                     class="psr-footer-grey {if $psr_hook_footer != 1} active{/if}" />
            </div>
        </label>
        <label class="col-lg-3 col-lg-offset-1 col-xs-3 col-xs-offset-1">
            <div class="help-block customradiodesign">
                <input type="radio" class="input_img" name="PSR_HOOK_FOOTER" value="0" id="PSR_HOOK_FOOTER_1"
                       {if $psr_hook_footer eq 0}checked="checked"{/if} />
                <label for="PSR_HOOK_FOOTER_1"><span><span></span></span>{l s='None' d='Modules.Blockreassurance.Admin'}</label><br/><br/>
                <img src="{$img_path}allpage_none.jpg" width="150" height="150" />
            </div>
        </label>
    </div>
</div>
