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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2019 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

$sql = array();

$sql[] = ' CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'psreassurance` (
        `id_psreassurance` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `icone` varchar(255) NULL,
        `icone_perso` varchar(255) NULL,
        `status` int(10) unsigned NOT NULL,
        `position` int(10) unsigned NOT NULL,
        `id_shop` int(10) unsigned NOT NULL,
        `type_link` int(10) unsigned NULL,
        `id_cms` int(10) unsigned NULL,
        `date_add` datetime NOT NULL,
        `date_upd` datetime NULL,
        PRIMARY KEY (`id_psreassurance`)
        ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'psreassurance_lang` (
    `id_psreassurance` int(10) unsigned NOT NULL,
    `id_lang` int(10) unsigned NOT NULL,
    `id_shop` int(10) unsigned NOT NULL,
    `title` varchar(255) NOT NULL,
    `description` varchar(255) NOT NULL,
    `link` varchar(255) NOT NULL,
    PRIMARY KEY (`id_psreassurance`,`id_shop`,`id_lang`)
    ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;';

$sqlInsertPSReassurance = "INSERT INTO "._DB_PREFIX_."psreassurance (id_psreassurance, icone, icone_perso, status, position, id_shop, type_link, id_cms, date_add) VALUES ";

$sql[] = $sqlInsertPSReassurance . "(1, '/PrestaShop/modules/blockreassurance/views/img/reassurance/pack2/security.svg', null, 1, 1, 1, null, null, now())";
$sql[] = $sqlInsertPSReassurance . "(2, '/PrestaShop/modules/blockreassurance/views/img/reassurance/pack2/carrier.svg', null, 1, 2, 1, null, null, now())";
$sql[] = $sqlInsertPSReassurance . "(3, '/PrestaShop/modules/blockreassurance/views/img/reassurance/pack2/parcel.svg', null, 1, 3, 1, null, null, now())";

$sqlInsertPSReassuranceLang = "INSERT INTO "._DB_PREFIX_."psreassurance_lang (id_psreassurance, id_lang, id_shop, title, description, link) VALUES ";
foreach ($languages as $lang) {
    $sql[] = $sqlInsertPSReassuranceLang . "(1, ".$lang['id_lang'].", 1, 'Security Policy', '(edit with Customer reassurance module)', '')";
    $sql[] = $sqlInsertPSReassuranceLang . "(2, ".$lang['id_lang'].", 1, 'Delivery Policy', '(edit with Customer reassurance module)', '')";
    $sql[] = $sqlInsertPSReassuranceLang . "(3, ".$lang['id_lang'].", 1, 'Return Policy', '(edit with Customer reassurance module)', '')";
}

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}

return true;
