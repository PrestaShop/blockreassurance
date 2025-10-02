<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * @param blockreassurance $module
 *
 * @return bool|string
 */
function upgrade_module_6_0_1($module)
{
    $sql = [];

    // Add icon and custom_icon columns to psreassurance_lang table
    $sql[] = sprintf(
        'ALTER TABLE `%spsreassurance_lang` ADD COLUMN `icon` varchar(255) NULL AFTER `link`',
        _DB_PREFIX_
    );
    $sql[] = sprintf(
        'ALTER TABLE `%spsreassurance_lang` ADD COLUMN `custom_icon` varchar(255) NULL AFTER `icon`',
        _DB_PREFIX_
    );

    // Migrate existing icon and custom_icon data from psreassurance to psreassurance_lang for each language
    $sql[] = sprintf(
        'UPDATE `%spsreassurance_lang` prl
        INNER JOIN `%spsreassurance` pr ON prl.id_psreassurance = pr.id_psreassurance
        SET prl.icon = pr.icon, prl.custom_icon = pr.custom_icon',
        _DB_PREFIX_,
        _DB_PREFIX_
    );

    // Drop icon and custom_icon columns from psreassurance table
    $sql[] = sprintf(
        'ALTER TABLE `%spsreassurance` DROP COLUMN `icon`',
        _DB_PREFIX_
    );
    $sql[] = sprintf(
        'ALTER TABLE `%spsreassurance` DROP COLUMN `custom_icon`',
        _DB_PREFIX_
    );

    foreach ($sql as $query) {
        if (Db::getInstance()->execute($query) === false) {
            return Db::getInstance()->getMsgError();
        }
    }

    return true;
}
