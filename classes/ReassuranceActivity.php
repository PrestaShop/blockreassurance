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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2019 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class ReassuranceActivity extends ObjectModel
{
    public $id_psreassurance;
    public $icone;
    public $icone_perso;
    public $title;
    public $description;
    public $status;
    public $position;
    public $id_shop;
    public $type_lien;
    public $lien;
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table'     => 'psreassurance',
        'primary'   => 'id_psreassurance',
        'fields'    => array(
            'icone'         => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'icone_perso'   => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'title'         => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
            'description'   => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 2000),
            'status'        => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'position'      => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false),
            'type_lien'     => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false),
            'lien'          => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'required' => false, 'size' => 255),
        )
    );

    public static function getAllBlock($id_lang, $id_shop)
    {
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'psreassurance` pr 
            LEFT JOIN '._DB_PREFIX_.'psreassurance_lang prl ON (pr.id_psreassurance = prl.id_psreassurance) 
            WHERE prl.id_lang = "'.(int)$id_lang.'" AND prl.id_shop = "'.(int)$id_shop.'"
            ORDER BY pr.position';

        $result = Db::getInstance()->executeS($sql);
        return $result;
    }
}
