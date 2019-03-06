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

class AdminBlockListingController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ajaxProcessChangeBlockStatus()
    {
        $dt = new DateTime();
        $PsreassuranceId = (int) Tools::getValue('idpsr');
        $Status = (int) Tools::getValue('status');
        if ($Status ==1) {
            $Status = 0;
        } else {
            $Status = 1;
        }

        $UpdatedDatas = array(
            'status' => $Status,
            'date_upd' => $dt->format('Y-m-d H:i:s'),
        );
        $sWhere = 'id_psreassurance = '.$PsreassuranceId;

        $bStatusChanged = Db::getInstance()->update('psreassurance', $UpdatedDatas, $sWhere);

        $this->ajaxDie($bStatusChanged);
    }

    public function ajaxProcessSavePositionByHook()
    {
        $hook = Tools::getValue('hook');
        $value = Tools::getValue('value');

        Configuration::updateValue($hook, $value);

        $this->ajaxDie(json_encode('success'));
    }

    public function ajaxProcessSaveColor()
    {
        $color1 = Tools::getValue('color1');
        $color2 = Tools::getValue('color2');

        Configuration::updateValue('PSR_ICON_COLOR', $color1);
        Configuration::updateValue('PSR_TEXT_COLOR', $color2);

        $this->ajaxDie(json_encode('success'));
    }

    public function ajaxProcessSaveBlockContent()
    {
        $errors = array();

        $picto = Tools::getValue('picto');
        $id_block = Tools::getValue('id_block');
        $psr_languages = (array) json_decode(Tools::getValue('lang_values'));
        $type_link = Tools::getValue('typelink');
        $id_cms = Tools::getValue('id_cms');

        if (!empty($errors) && count($errors)) {
            echo json_encode(array(
                'errors' => $errors,
            ));
            return;
        }
        $id_block++;
        $blockPsr = new ReassuranceActivity($id_block);
        $languages = Language::getLanguages();
        foreach ($languages as $language) {
            $blockPsr->title[$language['id_lang']] = $psr_languages[$language['id_lang']]->title;
            $blockPsr->description[$language['id_lang']] = $psr_languages[$language['id_lang']]->description;
            if ($type_link == 2) {
                $blockPsr->link[$language['id_lang']] = $psr_languages[$language['id_lang']]->url;
            } else {
                $blockPsr->link[$language['id_lang']] = '';
            }
        }

        if (isset($id_cms) && $type_link == 1) {
            $blockPsr->id_cms = $id_cms;
            $link = Context::getContext()->link;
            foreach ($languages as $language) {
                $blockPsr->link[$language['id_lang']] = $link->getCMSLink($id_cms, null, null, $language['id_lang']);
            }
        }

        $blockPsr->icone = $picto;
        $blockPsr->type_link = $type_link;
        
        $blockPsr->date_add = date("Y-m-d H:i:s");
        $blockPsr->date_update = date("Y-m-d H:i:s");

        
        // if (isset($_FILES) && $_FILES != '') {
        //     $picto_perso = $_FILES;
        //     $picto_perso = $_FILES['file'];
        //     $fileTmpName = $picto_perso['tmp_name'];
        //     $filename = $picto_perso['name'];
        //     // validateUpload return false if no error (false -> OK)
        //     // if (!ImageManager::validateUpload($picto_perso)) {
        //     //     move_uploaded_file($fileTmpName, $this->module->img_path_perso.$filename);
        //     //     $blockPsr->icone_perso = '/modules/psreassurance/img_perso/'.$filename;
        //     // } else {
        //     //     $errors[] = ImageManager::validateUpload($picto_perso).' ('.$isoCode.')';
        //     // }
        // }
        

        $blockPsr->update();

        $this->ajaxDie(json_encode('success'));
    }
}
