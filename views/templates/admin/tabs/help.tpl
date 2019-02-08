{*
* 2007-2017 PrestaShop
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
* @author    PrestaShop SA <contact@prestashop.com>
* @copyright 2007-2019 PrestaShop SA
* @license   http://addons.prestashop.com/en/content/12-terms-and-conditions-of-use
* International Registered Trademark & Property of PrestaShop SA
*}

<div class="panel panel-default col-lg-10 col-lg-offset-1 col-md-12 col-md-offset-0">
    <div class="panel-heading">
        <i class="material-icons">info</i>
        {l s='Help for the PS reassurance module' mod='psreassurance'}
    </div>
    <div class="helpContentParent">
        <div class="helpContentLeft">
            <div class="left">
                <img src="{$logo_path|escape:'htmlall':'UTF-8'}" alt=""/>
            </div>
            <div class="right">
                <p><span class="data_label" style="color:#00aff0;"><b>{l s='This module allows you to :' mod='psreassurance'}</b></span></p>
                <br>
                <div>
                    <div class="numberCircle">1</div>
                    <div class="numberCircleText">
                        <p class="numberCircleText">
                            {l s='chat instantaneously with as many clients you want and save conversations in an archive' mod='psreassurance'}
                        </p>
                    </div>
                </div>
                <div>
                    <div class="numberCircle">2</div>
                    <div class="numberCircleText">
                        <p class="numberCircleText">
                            {l s='switch to offline mode and allow your clients to send you an email directly through the window' mod='psreassurance'}
                        </p>
                    </div>
                </div>
                <div>
                    <div class="numberCircle">3</div>
                    <div class="numberCircleText">
                        <p class="numberCircleText">
                            {l s='customize your chat window according to the colors of your store' mod='psreassurance'}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="helpContentRight">
            <div class="helpContentRight-sub">
                <b>{l s='Need help ?' mod='psreassurance'}</b><br>
                {l s='Find here the documentation of this module' mod='psreassurance'}
                <a class="btn btn-primary" href="{$guide_link|escape:'htmlall':'UTF-8'}" target="_blank" style="margin-left:20px;" href="#">
                    <i class="fa fa-book"></i> {l s='Documentation' mod='psreassurance'}</a>
                </a>
                <br><br>
                <div class="tab-pane panel" id="faq">
                    <div class="panel-heading"><i class="icon-question"></i> {l s='FAQ' mod='psreassurance'}</div>
                    {if $apifaq}
                        {foreach from=$apifaq item=categorie name='faq'}
                            <span class="faq-h1">{$categorie->title|escape:'htmlall':'UTF-8'}</span>
                            <ul>
                                {foreach from=$categorie->blocks item=QandA}
                                    {if !empty($QandA->question)}
                                        <li>
                                            <span class="faq-h2"><i class="icon-info-circle"></i> {$QandA->question|escape:'htmlall':'UTF-8'}</span>
                                            <p class="faq-text hide">
                                                {$QandA->answer|escape:'htmlall':'UTF-8'|replace:"\n":"<br />"}
                                            </p>
                                        </li>
                                    {/if}
                                {/foreach}
                            </ul>
                            {if !$smarty.foreach.faq.last}<hr/>{/if}
                        {/foreach}
                    {/if}
                </div>
                {l s='You couldn\'t find any answer to your question ?' mod='psreassurance'}
                <b><a href="http://addons.prestashop.com/contact-form.php" target="_blank">{l s='Contact us on PrestaShop Addons' mod='psreassurance'}</a></b>
            </div>
        </div>
    </div>
</div>

