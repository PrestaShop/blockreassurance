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

$sql[] = "INSERT INTO "._DB_PREFIX_."psreassurance (id_psreassurance, icone, icone_perso, status, position, id_shop, type_link, id_cms, date_add)
        VALUES (1, 'credit_card', null, 1, 1, 1, null, null, now())";
$sql[] = "INSERT INTO "._DB_PREFIX_."psreassurance (id_psreassurance, icone, icone_perso, status, position, id_shop, type_link, id_cms, date_add)
        VALUES (2, 'local_shipping', null, 1, 2, 1, null, null, now())";
$sql[] = "INSERT INTO "._DB_PREFIX_."psreassurance (id_psreassurance, icone, icone_perso, status, position, id_shop, type_link, id_cms, date_add)
        VALUES (3, 'loop', null, 1, 3, 1, null, null, now())";

foreach ($languages as $lang) {
    $sql[] = "INSERT INTO "._DB_PREFIX_."psreassurance_lang (id_psreassurance, id_lang, id_shop, title, description, link)
            VALUES (1, ".$lang['id_lang'].", 1, 'Secure payment', 'Payment methods accepted: Visa, Mastercard, American Express, Paypal', 0)";
    $sql[] = "INSERT INTO "._DB_PREFIX_."psreassurance_lang (id_psreassurance, id_lang, id_shop, title, description, link)
            VALUES (2, ".$lang['id_lang'].", 1, 'Free delivery', 'From 60 € of purchase, we deliver to you in Colissimo or Point Relais', 0)";
    $sql[] = "INSERT INTO "._DB_PREFIX_."psreassurance_lang (id_psreassurance, id_lang, id_shop, title, description, link)
            VALUES (3, ".$lang['id_lang'].", 1, 'Free returns', 'Very simple and free return in store', 0)";
}

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}

return true;
