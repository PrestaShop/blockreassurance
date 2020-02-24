<?php
/**
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
 * @author PrestaShop SA <contact@prestashop.com>
 * @copyright  2007-2019 PrestaShop SA
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * @param $module
 *
 * @return bool|string
 *
 * @throws PrestaShopDatabaseException
 * @throws PrestaShopException
 */
function upgrade_module_4_0_0($module)
{
    $tab = new Tab();
    $tab->active = 1;
    $tab->class_name = 'AdminBlockListing';
    foreach (Language::getLanguages(true) as $lang) {
        $tab->name[$lang['id_lang']] = 'blockreassurance';
    }

    $tab->id_parent = -1;
    $tab->module = 'blockreassurance';
    $tab->add();

    /*
     ** Select the reassurance_lang table values
     ** ps_reassurance_lang => id_reassurance, id_lang, text
     */
    $sql = 'SELECT * FROM `' . _DB_PREFIX_ . 'reassurance_lang`';
    $reassurance_langs = Db::getInstance()->ExecuteS($sql);

    /*
     ** Select the reassurance table values
     ** ps_reassurance => id_reassurance, id_shop, filename
     */
    $sql = 'SELECT * FROM `' . _DB_PREFIX_ . 'reassurance`';
    $reassurances = Db::getInstance()->ExecuteS($sql);

    $sql = [];

    $sql[] = ' CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'psreassurance` (
            `id_psreassurance` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `icon` varchar(255) NULL,
            `custom_icon` varchar(255) NULL,
            `status` int(10) unsigned NOT NULL,
            `position` int(10) unsigned NOT NULL,
            `id_shop` int(10) unsigned NOT NULL,
            `type_link` int(10) unsigned NULL,
            `id_cms` int(10) unsigned NULL,
            `date_add` datetime NOT NULL,
            `date_upd` datetime NULL,
            PRIMARY KEY (`id_psreassurance`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;';

    $sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'psreassurance_lang` (
        `id_psreassurance` int(10) unsigned NOT NULL,
        `id_lang` int(10) unsigned NOT NULL,
        `id_shop` int(10) unsigned NOT NULL,
        `title` varchar(255) NOT NULL,
        `description` varchar(255) NOT NULL,
        `link` varchar(255) NOT NULL,
        PRIMARY KEY (`id_psreassurance`,`id_shop`,`id_lang`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;';

    /*
     ** First we make a verification that the new tables are empty
     */
    $sql[] = 'TRUNCATE TABLE `' . _DB_PREFIX_ . 'psreassurance`';
    $sql[] = 'TRUNCATE TABLE `' . _DB_PREFIX_ . 'psreassurance_lang`';

    /* This path : /modules/blockreassurance/img/".$reassurance['file_name']
     ** is used with the real path in the module
     **
     ** We do the INSERT INTO to get the old module values
     */
    if (!empty($reassurances)) {
        foreach ($reassurances as $reassurance) {
            $sql[] = 'INSERT INTO ' . _DB_PREFIX_ . 'psreassurance (id_psreassurance, icon, custom_icon, status, position, id_shop, type_link, id_cms, date_add)
                VALUES (' . $reassurance['id_reassurance'] . ", '" . $module->old_path_img . $reassurance['file_name'] . "', null, 1, " . $reassurance['id_reassurance'] . ', ' . $reassurance['id_shop'] . ', null, null, now())';
        }
    }

    if (!empty($reassurance_langs)) {
        foreach ($reassurance_langs as $reassurance_lang) {
            $sql[] = 'INSERT INTO ' . _DB_PREFIX_ . 'psreassurance_lang (id_psreassurance, id_lang, id_shop, title, description, link)
            VALUES (' . $reassurance_lang['id_reassurance'] . ', ' . $reassurance_lang['id_lang'] . ", 1, '" . $reassurance_lang['text'] . "', '', '')";
        }
    }

    /*
     ** Here we execute the SQL
     */
    foreach ($sql as $query) {
        if (Db::getInstance()->execute($query) == false) {
            return Db::getInstance()->getMsgError();
        }
    }

    /*
     ** Verification if the hooks are already registered
     */
    $result = true;
    foreach ([
                 'displayAfterBodyOpeningTag',
                 'displayNavFullWidth',
                 'displayFooterAfter',
                 'displayFooterBefore',
                 'displayReassurance',
                 'actionFrontControllerSetMedia',
             ] as $hookName) {
        if (!$module->isRegisteredInHook($hookName)) {
            $result &= $module->registerHook($hookName);
        }
    }

    /*
    ** We set the new configuration values
    */
    Configuration::updateValue('PSR_HOOK_HEADER', '0');
    Configuration::updateValue('PSR_HOOK_FOOTER', '0');
    Configuration::updateValue('PSR_HOOK_PRODUCT', '1');
    Configuration::updateValue('PSR_HOOK_CHECKOUT', '1');
    Configuration::updateValue('PSR_ICON_COLOR', '#F19D76');
    Configuration::updateValue('PSR_TEXT_COLOR', '#000000');

    unset($module);

    return $result;
}
