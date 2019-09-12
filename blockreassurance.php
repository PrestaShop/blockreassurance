<?php
/*
* 2007-2016 PrestaShop
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
*  @copyright  2007-2016 PrestaShop SA

*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_CAN_LOAD_FILES_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

include_once _PS_MODULE_DIR_.'blockreassurance/reassuranceClass.php';

class Blockreassurance extends Module implements WidgetInterface
{
    private $templateFile;

    public function __construct()
    {
        $this->name = 'blockreassurance';
        $this->author = 'PrestaShop';
        $this->version = '3.0.1';

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('Customer reassurance', array(), 'Modules.Blockreassurance.Admin');
        $this->description = $this->trans('Adds an information block aimed at offering helpful information to reassure customers that your store is trustworthy.', array(), 'Modules.Blockreassurance.Admin');

        $this->ps_versions_compliancy = array('min' => '1.7.2.0', 'max' => _PS_VERSION_);

        $this->templateFile = 'module:blockreassurance/views/templates/hook/blockreassurance.tpl';
    }

    public function install()
    {
        return parent::install()
            && $this->installDB()
            && Configuration::updateValue('BLOCKREASSURANCE_NBBLOCKS', 5)
            && $this->installFixtures()
            && $this->registerHook('displayOrderConfirmation2')
            && $this->registerHook('actionUpdateLangAfter')
        ;
    }

    public function installDB()
    {
        $return = true;
        $return &= Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'reassurance` (
                `id_reassurance` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_shop` int(10) unsigned NOT NULL ,
                `file_name` VARCHAR(100) NOT NULL,
                PRIMARY KEY (`id_reassurance`)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');

        $return &= Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'reassurance_lang` (
                `id_reassurance` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_lang` int(10) unsigned NOT NULL ,
                `text` VARCHAR(300) NOT NULL,
                PRIMARY KEY (`id_reassurance`, `id_lang`)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');

        return $return;
    }

    public function uninstall()
    {
        return Configuration::deleteByName('BLOCKREASSURANCE_NBBLOCKS') &&
            $this->uninstallDB() &&
            parent::uninstall();
    }

    public function uninstallDB()
    {
        return Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'reassurance`') && Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'reassurance_lang`');
    }

    public function addToDB()
    {
        if (isset($_POST['nbblocks'])) {
            for ($i = 1; $i <= (int)$_POST['nbblocks']; $i++) {
                $filename = explode('.', $_FILES['info'.$i.'_file']['name']);
                if (isset($_FILES['info'.$i.'_file']) && isset($_FILES['info'.$i.'_file']['tmp_name']) && !empty($_FILES['info'.$i.'_file']['tmp_name'])) {
                    if ($error = ImageManager::validateUpload($_FILES['info'.$i.'_file'])) {
                        return false;
                    } elseif (!($tmpName = tempnam(_PS_TMP_IMG_DIR_, 'PS')) || !move_uploaded_file($_FILES['info'.$i.'_file']['tmp_name'], $tmpName)) {
                        return false;
                    } elseif (!ImageManager::resize($tmpName, dirname(__FILE__).'/img/'.$filename[0].'.jpg')) {
                        return false;
                    }
                    unlink($tmpName);
                }
                Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'reassurance` (`filename`,`text`)
                                            VALUES ("'.((isset($filename[0]) && $filename[0] != '') ? pSQL($filename[0]) : '').
                    '", "'.((isset($_POST['info'.$i.'_text']) && $_POST['info'.$i.'_text'] != '') ? pSQL($_POST['info'.$i.'_text']) : '').'")');
            }
            return true;
        } else {
            return false;
        }
    }

    public function removeFromDB()
    {
        $dir = opendir(dirname(__FILE__).'/img');
        while (false !== ($file = readdir($dir))) {
            $path = dirname(__FILE__).'/img/'.$file;
            if ($file != '..' && $file != '.' && !is_dir($file)) {
                unlink($path);
            }
        }
        closedir($dir);

        return Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'reassurance`');
    }

    public function hookActionUpdateLangAfter($params)
    {
        if (!empty($params['lang']) && $params['lang'] instanceOf Language) {
            include_once _PS_MODULE_DIR_ . $this->name . '/lang/ReassuranceLang.php';

            Language::updateMultilangFromClass(_DB_PREFIX_ . 'reassurance_lang', 'ReassuranceLang', $params['lang']);
        }
    }

    public function getContent()
    {
        $html = '';
        $id_reassurance = (int)Tools::getValue('id_reassurance');

        if (Tools::isSubmit('saveblockreassurance')) {
            if ($id_reassurance = Tools::getValue('id_reassurance')) {
                $reassurance = new reassuranceClass((int)$id_reassurance);
            } else {
                $reassurance = new reassuranceClass();
            }

            $reassurance->copyFromPost();
            $reassurance->id_shop = $this->context->shop->id;

            if ($reassurance->validateFields(false) && $reassurance->validateFieldsLang(false)) {
                $reassurance->save();

                if (isset($_FILES['image']) && isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])) {
                    if ($error = ImageManager::validateUpload($_FILES['image'])) {
                        return false;
                    } elseif (!($tmpName = tempnam(_PS_TMP_IMG_DIR_, 'PS')) || !move_uploaded_file($_FILES['image']['tmp_name'], $tmpName)) {
                        return false;
                    } elseif (!ImageManager::resize($tmpName, dirname(__FILE__).'/img/reassurance-'.(int)$reassurance->id.'-'.(int)$reassurance->id_shop.'.jpg')) {
                        return false;
                    }

                    unlink($tmpName);
                    $reassurance->file_name = 'reassurance-'.(int)$reassurance->id.'-'.(int)$reassurance->id_shop.'.jpg';
                    $reassurance->save();
                }
                $this->_clearCache('*');
            } else {
                $html .= '<div class="conf error">'.$this->trans('An error occurred while attempting to save.', array(), 'Admin.Notifications.Error').'</div>';
            }
        }

        if (Tools::isSubmit('updateblockreassurance') || Tools::isSubmit('addblockreassurance')) {
            $helper = $this->initForm();
            foreach (Language::getLanguages(false) as $lang) {
                if ($id_reassurance) {
                    $reassurance = new reassuranceClass((int)$id_reassurance);
                    $helper->fields_value['text'][(int)$lang['id_lang']] = $reassurance->text[(int)$lang['id_lang']];
                    $image = dirname(__FILE__).DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.$reassurance->file_name;
                    $this->fields_form[0]['form']['input'][0]['image'] = '<img src="'.$this->getImageURL($reassurance->file_name).'" />';
                } else {
                    $helper->fields_value['text'][(int)$lang['id_lang']] = Tools::getValue('text_'.(int)$lang['id_lang'], '');
                }
            }
            if ($id_reassurance = Tools::getValue('id_reassurance')) {
                $this->fields_form[0]['form']['input'][] = array('type' => 'hidden', 'name' => 'id_reassurance');
                $helper->fields_value['id_reassurance'] = (int)$id_reassurance;
            }

            return $html.$helper->generateForm($this->fields_form);
        } elseif (Tools::isSubmit('deleteblockreassurance')) {
            $reassurance = new reassuranceClass((int)$id_reassurance);
            if (file_exists(dirname(__FILE__).'/img/'.$reassurance->file_name)) {
                unlink(dirname(__FILE__).'/img/'.$reassurance->file_name);
            }
            $reassurance->delete();
            $this->_clearCache('*');
            Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
        } else {
            $content = $this->getListContent((int)Configuration::get('PS_LANG_DEFAULT'));
            $helper = $this->initList();
            $helper->listTotal = count($content);
            return $html.$helper->generateList($content, $this->fields_list);
        }

        if (isset($_POST['submitModule'])) {
            Configuration::updateValue('BLOCKREASSURANCE_NBBLOCKS', ((isset($_POST['nbblocks']) && $_POST['nbblocks'] != '') ? (int)$_POST['nbblocks'] : ''));
            if ($this->removeFromDB() && $this->addToDB()) {
                $this->_clearCache('blockreassurance.tpl');
                $output = '<div class="conf confirm">'.$this->trans('The block configuration has been updated.', array(), 'Modules.Blockreassurance.Admin').'</div>';
            } else {
                $output = '<div class="conf error"><img src="../img/admin/disabled.gif"/>'.$this->trans('An error occurred while attempting to save.', array(), 'Admin.Notifications.Error').'</div>';
            }
        }
    }

    protected function getListContent($id_lang)
    {
        return  Db::getInstance()->executeS('
            SELECT r.`id_reassurance`, r.`id_shop`, r.`file_name`, rl.`text`
            FROM `'._DB_PREFIX_.'reassurance` r
            LEFT JOIN `'._DB_PREFIX_.'reassurance_lang` rl ON (r.`id_reassurance` = rl.`id_reassurance`)
            WHERE `id_lang` = '.(int)$id_lang.' '.Shop::addSqlRestrictionOnLang());
    }

    protected function initForm()
    {
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        $this->fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->trans('New reassurance block', array(), 'Modules.Blockreassurance.Admin'),
            ),
            'input' => array(
                array(
                    'type' => 'file',
                    'label' => $this->trans('Image', array(), 'Admin.Global'),
                    'name' => 'image',
                    'value' => true,
                    'display_image' => true,
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->trans('Text', array(), 'Admin.Global'),
                    'lang' => true,
                    'name' => 'text',
                    'cols' => 40,
                    'rows' => 10
                )
            ),
            'submit' => array(
                'title' => $this->trans('Save', array(), 'Admin.Actions'),
            )
        );

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = 'blockreassurance';
        $helper->identifier = $this->identifier;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        foreach (Language::getLanguages(false) as $lang) {
            $helper->languages[] = array(
                'id_lang' => $lang['id_lang'],
                'iso_code' => $lang['iso_code'],
                'name' => $lang['name'],
                'is_default' => ($default_lang == $lang['id_lang'] ? 1 : 0)
            );
        }

        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;
        $helper->toolbar_scroll = true;
        $helper->title = $this->displayName;
        $helper->submit_action = 'saveblockreassurance';
        $helper->toolbar_btn =  array(
            'save' =>
            array(
                'desc' => $this->trans('Save', array(), 'Admin.Actions'),
                'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
            ),
            'back' =>
            array(
                'href' => AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->trans('Back to list', array(), 'Admin.Actions'),
            )
        );
        return $helper;
    }

    protected function initList()
    {
        $this->fields_list = array(
            'id_reassurance' => array(
                'title' => $this->trans('ID', array(), 'Admin.Global'),
                'width' => 120,
                'type' => 'text',
                'search' => false,
                'orderby' => false
            ),
            'text' => array(
                'title' => $this->trans('Text', array(), 'Admin.Global'),
                'width' => 140,
                'type' => 'text',
                'search' => false,
                'orderby' => false
            ),
        );

        if (Shop::isFeatureActive()) {
            $this->fields_list['id_shop'] = array(
                'title' => $this->trans('ID Shop', array(), 'Modules.Blockreassurance.Admin'),
                'align' => 'center',
                'width' => 25,
                'type' => 'int'
            );
        }

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_reassurance';
        $helper->actions = array('edit', 'delete');
        $helper->show_toolbar = true;
        $helper->imageType = 'jpg';
        $helper->toolbar_btn['new'] =  array(
            'href' => AdminController::$currentIndex.'&configure='.$this->name.'&add'.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->trans('Add new', array(), 'Admin.Actions')
        );

        $helper->title = $this->displayName;
        $helper->table = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        return $helper;
    }

    protected function _clearCache($template, $cacheId = null, $compileId = null)
    {
        parent::_clearCache($this->templateFile);
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if (!$this->isCached($this->templateFile, $this->getCacheId('blockreassurance'))) {
            $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        }

        return $this->fetch($this->templateFile, $this->getCacheId('blockreassurance'));
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        $elements = $this->getListContent($this->context->language->id);

        foreach ($elements as &$element) {
            $element['image'] = $this->getImageURL($element['file_name']);
        }

        return array(
            'elements' => $elements,
        );
    }

    public function installFixtures()
    {
        $return = true;
        $tab_texts = array(
            array('text' => $this->trans('Security policy (edit with Customer reassurance module)', array(), 'Modules.Blockreassurance.Shop'), 'file_name' => 'ic_verified_user_black_36dp_1x.png'),
            array('text' => $this->trans('Delivery policy (edit with Customer reassurance module)', array(), 'Modules.Blockreassurance.Shop'), 'file_name' => 'ic_local_shipping_black_36dp_1x.png'),
            array('text' => $this->trans('Return policy (edit with Customer reassurance module)', array(), 'Modules.Blockreassurance.Shop'), 'file_name' => 'ic_swap_horiz_black_36dp_1x.png'),
        );

        foreach ($tab_texts as $tab) {
            $reassurance = new reassuranceClass();
            foreach (Language::getLanguages(false) as $lang) {
                $reassurance->text[$lang['id_lang']] = $tab['text'];
            }
            $reassurance->file_name = $tab['file_name'];
            $reassurance->id_shop = $this->context->shop->id;
            $return &= $reassurance->save();
        }
        return $return;
    }

    private function getImageURL($image)
    {
        return $this->context->link->getMediaLink(__PS_BASE_URI__.'modules/'.$this->name.'/img/'.$image);
    }
}
