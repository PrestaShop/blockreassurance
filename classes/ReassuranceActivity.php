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

class ReassuranceActivity extends ObjectModel
{
    public $id;
    public $icone;
    public $icone_perso;
    public $title;
    public $description;
    public $status;
    public $position;
    public $id_shop;
    public $type_link;
    public $link;
    public $id_cms;
    public $date_add;
    public $date_upd;


    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table'     => 'psreassurance',
        'primary'   => 'id_psreassurance',
        'multilang' => true,
        'multilang_shop' => true,
        'fields'    => array(
            'icone'         => array('type' => self::TYPE_STRING, 'shop' => true, 'validate' => 'isCleanHtml', 'size' => 255),
            'icone_perso'   => array('type' => self::TYPE_STRING, 'shop' => true, 'validate' => 'isCleanHtml', 'size' => 255),
            'title'         => array('type' => self::TYPE_STRING, 'shop' => true, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
            'description'   => array('type' => self::TYPE_HTML, 'shop' => true, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 2000),
            'status'        => array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool', 'required' => true),
            'position'      => array('type' => self::TYPE_INT,  'shop' => true,'validate' => 'isunsignedInt', 'required' => false),
            'type_link'     => array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isunsignedInt', 'required' => false),
            'id_cms'     => array('type' => self::TYPE_INT, 'shop' => true, 'validate' => 'isunsignedInt', 'required' => false),
            'link'          => array('type' => self::TYPE_STRING, 'shop' => true, 'lang' => true, 'validate' => 'isUrl', 'required' => false, 'size' => 255),
            'date_add' => array('type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDate'),
            'date_upd' => array('type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDate'),
        )
    );

    /**
     * getAllBlockByLang
     *
     * @param  int $id_lang
     * @param  int $id_shop
     *
     * @return array
     */
    public static function getAllBlockByLang($id_lang = 1, $id_shop = 1)
    {
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'psreassurance` pr
            LEFT JOIN '._DB_PREFIX_.'psreassurance_lang prl ON (pr.id_psreassurance = prl.id_psreassurance)
            WHERE prl.id_lang = "'.(int)$id_lang.'" AND prl.id_shop = "'.(int)$id_shop.'"
            ORDER BY pr.position';

        $result = Db::getInstance()->executeS($sql);

        return $result;
    }

    public function handleBlockValues($psr_languages, $type_link)
    {
        $languages = Language::getLanguages();
        $newValues = array();

        foreach ($psr_languages as $key => $value) {
            $newValues[$key] = array();
            $newValues[$key]['title'] = $value->title;
            $newValues[$key]['description'] = $value->description;
            $newValues[$key]['url'] = $value->url;
        }

        foreach ($languages as $language) {
            if (false === array_key_exists($language['id_lang'], $newValues)) {
                continue;
            }
            $this->title[$language['id_lang']] = $newValues[$language['id_lang']]['title'];
            $this->description[$language['id_lang']] =  $newValues[$language['id_lang']]['description'];
            if ($type_link == 2) {
                $this->link[$language['id_lang']] =  $newValues[$language['id_lang']]['url'];
            } else {
                $this->link[$language['id_lang']] = '';
            }
        }

        if (isset($id_cms) && $type_link == 1) {
            $this->id_cms = $id_cms;
            $link = Context::getContext()->link;
            foreach ($languages as $language) {
                $this->link[$language['id_lang']] = $link->getCMSLink($id_cms, null, null, $language['id_lang']);
            }
        }

        if ($type_link == 'undefined') {
            $type_link = 0;
        }
        $this->type_link = $type_link;
    }

    /**
     * getAllBlockByShop
     *
     * @param  int $id_shop
     *
     * @return array
     */
    public static function getAllBlockByShop($id_shop = 1)
    {
        $return = array();
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'psreassurance` pr
            LEFT JOIN '._DB_PREFIX_.'psreassurance_lang prl ON (pr.id_psreassurance = prl.id_psreassurance)
            WHERE prl.id_shop = "'.(int)$id_shop.'"
            GROUP BY prl.id_lang, pr.id_psreassurance
            ORDER BY pr.position';

        $result = Db::getInstance()->executeS($sql);

        foreach ($result as $key => $value) {
            $return[$value['id_lang']][$value['id_psreassurance']]['title'] = $value['title'];
            $return[$value['id_lang']][$value['id_psreassurance']]['description'] = $value['description'];
            $return[$value['id_lang']][$value['id_psreassurance']]['url'] = $value['link'];
        }

        return $return;
    }

    /**
     * getAllBlockByStatus
     *
     * @param  int $id_lang
     * @param  int $id_shop
     *
     * @return array
     */
    public static function getAllBlockByStatus($id_lang = 1, $id_shop = 1)
    {
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'psreassurance` pr
            LEFT JOIN '._DB_PREFIX_.'psreassurance_lang prl ON (pr.id_psreassurance = prl.id_psreassurance)
            WHERE 
                prl.id_lang = "'.(int)$id_lang.'" 
                AND prl.id_shop = "'.(int)$id_shop.'"
                AND pr.status = 1
            ORDER BY pr.position';

        $result = Db::getInstance()->executeS($sql);
        
        return $result;
    }
}
