<?php
/**
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
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * @param blockreassurance $module
 *
 * @return bool|string
 */
function upgrade_module_6_0_0($module)
{
    $sql = 'SELECT * FROM ' . _DB_PREFIX_ . 'psreassurance';

    $rows = Db::getInstance()->executeS($sql);

    foreach ($rows as $row) {

        $data = [];

        if ($row['icon']) {

            $parts = explode('/', $row['icon']);
            $parts = array_slice($parts , -3);

            $data = [
                'icon' => implode('/', $parts)
            ];
        } elseif ($row['custom_icon']) {
            $data = [
                'custom_icon' => basename($row['custom_icon'])
            ];
        }

        if ($data) {
            Db::getInstance()->update('psreassurance', $data, '`id_psreassurance` = ' . (int) $row['id_psreassurance']);
        }
    }

    return true;
}
