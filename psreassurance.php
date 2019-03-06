<?php
/*
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2019 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

require_once _PS_MODULE_DIR_.'/psreassurance/classes/ReassuranceActivity.php';
if (!defined('_PS_VERSION_')) {
    exit;
}

class psreassurance extends Module
{
    public function __construct()
    {
        // Settings
        $this->name = 'psreassurance';
        $this->tab = 'seo';
        $this->version = '1.0.0';
        $this->author = 'PrestaShop';
        $this->need_instance = 0;
        $this->module_key = '938b96386d4d79aa7cb891439cb0ef11';
        $this->author_address = '0x64aa3c1e4034d07015f639b0e171b0d7b27d01aa';
        // Controllers
        //$this->controller_name = '';
        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('Psreassurance', array(), 'Modules.PsReassurance.Admin');
        $this->description = $this->trans('Adds an information block aimed at offering helpful information to reassure customers that your store is trustworthy.', array(), 'Modules.PsReassurance.Admin');

        // Settings paths
        $this->js_path = $this->_path.'views/js/';
        $this->css_path = $this->_path.'views/css/';
        $this->img_path = $this->_path.'views/img/';
        $this->img_path_perso = $this->_path.'img_perso';
        $this->docs_path = $this->_path.'docs/';
        $this->logo_path = $this->_path.'logo.png';
        $this->module_path = $this->_path;

        // Confirm uninstall
        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall this module?', array(), 'Modules.PsReassurance.Admin');
        $this->ps_url = Tools::getCurrentUrlProtocolPrefix().htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__;
    }

    /**
     * install()
     *
     * @param none
     * @return bool
     */
    public function install()
    {
        Configuration::updateValue('PSR_HOOK_HEADER', '0');
        Configuration::updateValue('PSR_HOOK_FOOTER', '0');
        Configuration::updateValue('PSR_HOOK_PRODUCT', '0');
        Configuration::updateValue('PSR_HOOK_CHECKOUT', '0');
        Configuration::updateValue('PSR_ICON_COLOR', '#F19D76');
        Configuration::updateValue('PSR_TEXT_COLOR', '#000000');

        $languages = Language::getLanguages(false);
        include(dirname(__FILE__).'/sql/install.php');

        // register hook used by the module
        if (parent::install() &&
        $this->registerHook('displayHeader') &&
        $this->registerHook('displayNavFullWidth') &&
        $this->registerHook('displayFooterAfter') &&
        $this->registerHook('displayHome') &&
        $this->registerHook('displayReassurance')
        ) {
            return true;
        } else {
            $this->_errors[] = $this->trans('There was an error during the installation. Please contact us through Addons website', array(), 'Modules.PsReassurance.Admin');
            return false;
        }
    }

    /**
     * uninstall()
     *
     * @param none
     * @return bool
     */
    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');

        Configuration::deleteByName('PSR_HOOK_HEADER');
        Configuration::deleteByName('PSR_HOOK_FOOTER');
        Configuration::deleteByName('PSR_HOOK_PRODUCT');
        Configuration::deleteByName('PSR_HOOK_CHECKOUT');
        Configuration::deleteByName('PSR_ICON_COLOR');
        Configuration::deleteByName('PSR_TEXT_COLOR');

        if (parent::uninstall()) {
            return true;
        } else {
            $this->_errors[] = $this->trans('There was an error during the desinstallation. Please contact us through Addons website');
            return false;
        }
    }

    /**
     * load dependencies
     */
    public function loadAsset()
    {
        $this->addJsDefList();
        $controller = Context::getContext()->controller;

        $aCss = array(
            $this->css_path.'style.css',
            $this->css_path.'faq.css',
            $this->css_path.'menu.css',
        );

        $aJs = array(
            $this->js_path.'back.js',
            $this->js_path.'menu.js',
            $this->js_path.'vue.min.js',
        );

        $aCss[] = '//fonts.googleapis.com/icon?family=Material+Icons';

        $this->context->controller->addCSS($aCss, 'all');
        $this->context->controller->addJS($aJs);
        $controller->addJqueryPlugin('colorpicker');
    }

    /**
     * getContent
     *
     *
     * @return template
    */
    public function getContent()
    {
        $this->loadAsset();
        $id_lang = $this->context->language->id;
        // get current page
        if (empty(Tools::getValue('page'))) {
             $currentPage = 'global';
        } else {
            $currentPage = Tools::getValue('page');
        }

        $moduleAdminLink = Context::getContext()->link->getAdminLink('AdminModules', true).'&configure='.$this->name.'&module_name='.$this->name;

        $allCms = CMS::listCms($id_lang);

        $this->context->smarty->assign(array(
            'psr_hook_header' => Configuration::get('PSR_HOOK_HEADER'),
            'psr_hook_footer' => Configuration::get('PSR_HOOK_FOOTER'),
            'psr_hook_product' => Configuration::get('PSR_HOOK_PRODUCT'),
            'psr_hook_checkout' => Configuration::get('PSR_HOOK_CHECKOUT'),
            'psr_text_color' => Configuration::get('PSR_TEXT_COLOR'),
            'psr_icon_color' => Configuration::get('PSR_ICON_COLOR'),
            'logo_path' => $this->logo_path,
            'guide_link' => $this->ps_url.'modules/'.$this->name.'/docs/doc_psreassurance_'.$this->context->language->iso_code.'.pdf',
            'languages' => Language::getLanguages(),
            'allblock' => ReassuranceActivity::getAllBlockByLang($id_lang, 1),
            'allblockByShop' => ReassuranceActivity::getAllBlockByShop(),
            'currentPage' => $currentPage,
            'moduleAdminLink' => $moduleAdminLink,
            'img_path' => $this->img_path,
            'allCms' => $allCms,
            'defaultFormLanguage' => (int) $this->context->employee->id_lang,

        ));

        return $this->display(__FILE__, 'views/templates/admin/configure.tpl');
    }

    /**
     * addJsDefList
     *
     * @return void
     */
    protected function addJsDefList()
    {
        Media::addJsDef(array(
            'psr_controller_block_url' => $this->context->link->getAdminLink('AdminBlockListing'),
            'psr_controller_block' => 'AdminBlockListing',

            'block_updated' => $this->trans('The block have been updated', array(), 'Modules.PsReassurance.Admin'),
            'active_error' => $this->trans('An error occured', array(), 'Modules.PsReassurance.Admin'),
            'psre_success' => $this->trans('Success. Your configurations has been updated ', array(), 'Modules.PsReassurance.Admin'),
        ));
    }

    public function hookdisplayHeader($params)
    {
        $id_lang = $this->context->language->id;
        $actif = Configuration::get('PSR_HOOK_HEADER');
        if ($actif == 2) {
            $this->context->smarty->assign(array(
                'blocks' => ReassuranceActivity::getAllBlockByStatus($id_lang, 1),
                'iconeColor' => Configuration::get('PSR_ICON_COLOR'),
                'textColor' => Configuration::get('PSR_TEXT_COLOR'),
            ));
            return $this->display(__FILE__, 'views/templates/hook/displayBlock.tpl');
        }
    }

    public function hookdisplayNavFullWidth($params)
    {
        $id_lang = $this->context->language->id;
        $actif = Configuration::get('PSR_HOOK_HEADER');
        if ($actif == 1) {
            $this->context->smarty->assign(array(
                'blocks' => ReassuranceActivity::getAllBlockByStatus($id_lang, 1),
                'iconeColor' => Configuration::get('PSR_ICON_COLOR'),
                'textColor' => Configuration::get('PSR_TEXT_COLOR'),
            ));
            return $this->display(__FILE__, 'views/templates/hook/displayBlock.tpl');
        }
    }

    public function hookdisplayFooterAfter($params)
    {
        $id_lang = $this->context->language->id;
        $actif = Configuration::get('PSR_HOOK_FOOTER');
        if ($actif == 1) {
            $this->context->smarty->assign(array(
                'blocks' => ReassuranceActivity::getAllBlockByStatus($id_lang, 1),
                'iconeColor' => Configuration::get('PSR_ICON_COLOR'),
                'textColor' => Configuration::get('PSR_TEXT_COLOR'),
            ));
            return $this->display(__FILE__, 'views/templates/hook/displayBlockWhite.tpl');
        }
    }

    public function hookdisplayHome($params)
    {
        $id_lang = $this->context->language->id;
        $actif = Configuration::get('PSR_HOOK_FOOTER');
        if ($actif == 2) {
            $this->context->smarty->assign(array(
                'blocks' => ReassuranceActivity::getAllBlockByStatus($id_lang, 1),
                'iconeColor' => Configuration::get('PSR_ICON_COLOR'),
                'textColor' => Configuration::get('PSR_TEXT_COLOR'),
            ));
            return $this->display(__FILE__, 'views/templates/hook/displayBlock.tpl');
        }
    }

    public function hookdisplayReassurance($params)
    {
        $actifCheckout = Configuration::get('PSR_HOOK_CHECKOUT');
        $actifProduct = Configuration::get('PSR_HOOK_PRODUCT');
        $controller = Tools::getValue('controller');
        $id_lang = $this->context->language->id;

        if ($actifCheckout == 1 && $controller== 'cart') {
            $this->context->smarty->assign(array(
                'blocks' => ReassuranceActivity::getAllBlockByStatus($id_lang, 1),
                'iconeColor' => Configuration::get('PSR_ICON_COLOR'),
                'textColor' => Configuration::get('PSR_TEXT_COLOR'),
            ));
            return $this->display(__FILE__, 'views/templates/hook/displayBlockProduct.tpl');
        }

        if ($actifProduct == 1 && $controller== 'product') {
            $this->context->smarty->assign(array(
                'blocks' => ReassuranceActivity::getAllBlockByStatus($id_lang, 1),
                'iconeColor' => Configuration::get('PSR_ICON_COLOR'),
                'textColor' => Configuration::get('PSR_TEXT_COLOR'),
            ));
            return $this->display(__FILE__, 'views/templates/hook/displayBlockProduct.tpl');
        }
    }
}
