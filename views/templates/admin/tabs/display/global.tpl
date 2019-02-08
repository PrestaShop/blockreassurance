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

<div class="panel panel-default col-lg-8 col-lg-offset-1 col-md-8 col-md-offset-0" >
    <div class="panel-heading">
        {l s='Header position on all pages' mod='psreassurance'}
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 position-hook">
        <label class="psr-float">
            <div class="help-block customradiodesign">
                <input type="radio" class="input_img js-show-all" name="PSR_HOOK_HEADER" value="2" 
                {if $psr_hook_header eq 2}checked="checked"{/if}
                />
                <label for="PSR_HOOK_HEADER"><span><span></span></span>{l s='Above header' mod='psagechecker'}</label><br /><br />
                <img src="{$img_path}displayTop_active.jpg" width="150" height="150" class="psr-header-color{if $psr_hook_header eq 2} active{/if}">
                <img src="{$img_path}displayTop_inactive.jpg" width="150" height="150" class="psr-header-grey {if $psr_hook_header != 2}active{/if}">
            </div>
        </label>
        <label class="psr-float">
            <div class="help-block customradiodesign">
                <input type="radio" class="input_img" name="PSR_HOOK_HEADER" value="1" 
                {if $psr_hook_header eq 1}checked="checked"{/if}
                />
                <label for="PSR_HOOK_HEADER"><span><span></span></span>{l s='Below header' mod='psagechecker'}</label><br /><br />
                <img src="{$img_path}displayHome_active.jpg" width="150" height="150" class="psr-header-color{if $psr_hook_header eq 1} active{/if}">
                <img src="{$img_path}displayHome_inactive.jpg" width="150" height="150" class="psr-header-grey {if $psr_hook_header != 1} active{/if}">
            </div>
        </label>
        <label class="psr-float">
            <div class="help-block customradiodesign">
                <input type="radio" class="input_img" name="PSR_HOOK_HEADER" value="0" 
                {if $psr_hook_header eq 0}checked="checked"{/if}
                />
                <label for="PSR_HOOK_HEADER"><span><span></span></span>{l s='None' mod='psagechecker'}</label><br /><br />
                <img src="{$img_path}allpage_none.jpg" width="150" height="150">
            </div>
            
        </label>
    </div>

</div>

<div class="col-lg-12 col-lg-offset-1 col-md-12 col-md-offset-0">
    <div class="col-lg-2 col-md-2 " >

    </div>
    <div class="panel panel-default col-lg-8 col-lg-offset-0 col-md-8 col-md-offset-0" >
        <div class="panel-heading">
            {l s='Footer position on all pages' mod='psreassurance'}
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 position-hook">
            <label class="psr-float">
                <div class="help-block customradiodesign">
                    <input type="radio" class="input_img js-show-all" name="PSR_HOOK_FOOTER" value="2" 
                    {if $psr_hook_footer eq 2}checked="checked"{/if}
                    />
                    <label for="PSR_HOOK_FOOTER"><span><span></span></span>{l s='Above footer' mod='psagechecker'}</label><br /><br />
                    <img src="{$img_path}displayFooterBefore_active.jpg" width="150" height="150" class="psr-footer-color{if $psr_hook_footer eq 2} active{/if}">
                    <img src="{$img_path}displayFooterBefore_inactive.jpg" width="150" height="150" class="psr-footer-grey {if $psr_hook_footer != 2} active{/if}">
                </div>
            </label>
            <label class="psr-float">
                <div class="help-block customradiodesign">
                    <input type="radio" class="input_img" name="PSR_HOOK_FOOTER" value="1" 
                    {if $psr_hook_footer eq 1}checked="checked"{/if}
                    />
                     <label for="PSR_HOOK_FOOTER"><span><span></span></span>{l s='Below footer' mod='psagechecker'}</label><br /><br />
                    <img src="{$img_path}displayFooter_active.jpg" width="150" height="150" class="psr-footer-color{if $psr_hook_footer eq 1} active{/if}">
                    <img src="{$img_path}displayFooter_inactive.jpg" width="150" height="150"  class="psr-footer-grey {if $psr_hook_footer != 1} active{/if}">
                </div>
            </label>
            <label class="psr-float">
                <div class="help-block customradiodesign">
                    <input type="radio" class="input_img" name="PSR_HOOK_FOOTER" value="0" 
                    {if $psr_hook_footer eq 0}checked="checked"{/if}
                    />
                     <label for="PSR_HOOK_FOOTER"><span><span></span></span>{l s='None' mod='psagechecker'}</label><br /><br />
                    <img src="{$img_path}allpage_none.jpg" width="150" height="150">
                </div>
            </label>
        </div>

    </div>
</div>