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
class ReassuranceActivity extends ObjectModel
{
    const TYPE_LINK_NONE = 0;
    const TYPE_LINK_CMS_PAGE = 1;
    const TYPE_LINK_URL = 2;

    public $id;
    public $icon;
    public $custom_icon;
    public $title;
    public $description;
    public $status;
    public $position;
    public $type_link;
    public $link;
    public $id_cms;
    public $date_add;
    public $date_upd;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'psreassurance',
        'primary' => 'id_psreassurance',
        'multilang' => true,
        'fields' => [
            'icon' => ['type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255],
            'custom_icon' => ['type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255],
            'status' => ['type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true],
            'position' => ['type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false],
            'type_link' => ['type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false],
            'id_cms' => ['type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false],
            'date_add' => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
            'date_upd' => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
            // lang fields
            'title' => ['type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255],
            'description' => ['type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 2000],
            'link' => ['type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'required' => false, 'size' => 255],
        ],
    ];

    /**
     * @param array $psr_languages
     * @param int $type_link
     * @param int $id_cms
     */
    public function handleBlockValues($psr_languages, $type_link, $id_cms)
    {
        $languages = Language::getLanguages();
        $newValues = [];

        foreach ($psr_languages as $key => $value) {
            $newValues[$key] = [
                'title' => $value->title,
                'description' => $value->description,
                'url' => $value->url,
            ];
        }

        foreach ($languages as $language) {
            if (false === array_key_exists($language['id_lang'], $newValues)) {
                continue;
            }

            $this->title[$language['id_lang']] = $newValues[$language['id_lang']]['title'];
            $this->description[$language['id_lang']] = $newValues[$language['id_lang']]['description'];
            $this->link[$language['id_lang']] = '';
            if ($type_link === self::TYPE_LINK_URL) {
                $this->link[$language['id_lang']] = $newValues[$language['id_lang']]['url'];
            }
        }

        if (!empty($id_cms) && $type_link === self::TYPE_LINK_CMS_PAGE) {
            $this->id_cms = $id_cms;
            $link = Context::getContext()->link;

            foreach ($languages as $language) {
                $this->link[$language['id_lang']] = $link->getCMSLink(
                    $id_cms,
                    null,
                    null,
                    $language['id_lang']
                );
            }
        }

        if ($type_link == 'undefined') {
            $type_link = self::TYPE_LINK_NONE;
        }

        $this->type_link = $type_link;
    }

    /**
     * @return array
     *
     * @throws PrestaShopDatabaseException
     */
    public static function getAllBlock()
    {
        $result = [];

        $sql = 'SELECT * FROM `' . _DB_PREFIX_ . 'psreassurance` pr
            LEFT JOIN ' . _DB_PREFIX_ . 'psreassurance_lang prl ON (pr.id_psreassurance = prl.id_psreassurance)
            ORDER BY pr.position';

        $dbResult = Db::getInstance()->executeS($sql);

        foreach ($dbResult as $key => $value) {
            if (!isset($result[$value['id_psreassurance']])) {
                $result[$value['id_psreassurance']] = $value;
                $result[$value['id_psreassurance']]['title'] = [];
                $result[$value['id_psreassurance']]['description'] = [];
                $result[$value['id_psreassurance']]['url'] = [];
            }
            $result[$value['id_psreassurance']]['title'][$value['id_lang']] = $value['title'];
            $result[$value['id_psreassurance']]['description'][$value['id_lang']] = $value['description'];
            $result[$value['id_psreassurance']]['url'][$value['id_lang']] = $value['link'];
        }

        return $result;
    }

    /**
     * @param int $id_lang
     *
     * @return array
     *
     * @throws PrestaShopDatabaseException
     */
    public static function getAllBlockByStatus($id_lang = 1)
    {
        $sql = 'SELECT * FROM `' . _DB_PREFIX_ . 'psreassurance` pr
            LEFT JOIN ' . _DB_PREFIX_ . 'psreassurance_lang prl ON (pr.id_psreassurance = prl.id_psreassurance)
            WHERE prl.id_lang = "' . (int) $id_lang . '"
                AND pr.status = 1
            ORDER BY pr.position';

        $result = Db::getInstance()->executeS($sql);

        $xmlMimes = ['image/svg', 'image/svg+xml'];
        foreach ($result as &$item) {
            $item['is_svg'] = !empty($item['custom_icon'])
                && (in_array(self::getMimeType(_PS_ROOT_DIR_ . $item['custom_icon']), $xmlMimes));
        }

        return $result;
    }

    /**
     * @return string|bool
     */
    public static function getMimeType(string $filename)
    {
        $mimeType = false;
        // Try with GD
        if (function_exists('getimagesize')) {
            $imageInfo = @getimagesize($filename);
            if ($imageInfo) {
                $mimeType = $imageInfo['mime'];
            }
        }
        // Try with FileInfo
        if (!$mimeType && function_exists('finfo_open')) {
            $const = defined('FILEINFO_MIME_TYPE') ? FILEINFO_MIME_TYPE : FILEINFO_MIME;
            $finfo = finfo_open($const);
            $mimeType = finfo_file($finfo, $filename);
            finfo_close($finfo);
        }
        // Try with Mime
        if (!$mimeType && function_exists('mime_content_type')) {
            $mimeType = mime_content_type($filename);
        }
        // Try with exec command and file binary
        if (!$mimeType && function_exists('exec')) {
            $mimeType = trim(exec('file -b --mime-type ' . escapeshellarg($filename)));
            if (!$mimeType) {
                $mimeType = trim(exec('file --mime ' . escapeshellarg($filename)));
            }
            if (!$mimeType) {
                $mimeType = trim(exec('file -bi ' . escapeshellarg($filename)));
            }
        }

        return $mimeType;
    }
}
