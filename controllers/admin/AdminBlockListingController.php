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

class AdminBlockListingController extends ModuleAdminController
{
    /**
     * Update the status of a block
     * @throws PrestaShopException
     */
    public function ajaxProcessChangeBlockStatus()
    {
        $now = new DateTime();
        $psreassuranceId = (int)Tools::getValue('idpsr');
        $newStatus = ((int)Tools::getValue('status') == 1) ? 0 : 1;

        $dataToUpdate = [
            'status' => $newStatus,
            'date_upd' => $now->format('Y-m-d H:i:s'),
        ];
        $whereCondition = 'id_psreassurance = ' . $psreassuranceId;

        $updateResult = Db::getInstance()->update('psreassurance', $dataToUpdate, $whereCondition);

        $this->ajaxDie(json_encode($updateResult ? 'success' : 'error'));
    }

    /**
     * Update position of a block
     *
     * @throws PrestaShopException
     */
    public function ajaxProcessSavePositionByHook()
    {
        $hook = Tools::getValue('hook');
        $value = Tools::getValue('value');

        if (empty($hook) || empty($value)) {
            $this->ajaxDie(json_encode('error'));
        }

        $updateResult = Configuration::updateValue($hook, $value);

        $this->ajaxDie(json_encode($updateResult ? 'success' : 'error'));
    }

    /**
     * Update colors of a block
     *
     * @throws PrestaShopException
     */
    public function ajaxProcessSaveColor()
    {
        $color1 = Tools::getValue('color1');
        $color2 = Tools::getValue('color2');

        if (empty($color1) || empty($color2)) {
            $this->ajaxDie(json_encode('error'));
        }

        $updateResult = Configuration::updateValue('PSR_ICON_COLOR', $color1)
            && Configuration::updateValue('PSR_TEXT_COLOR', $color2);

        $this->ajaxDie(json_encode($updateResult ? 'success' : 'error'));
    }

    /**
     * Update content of a block
     *
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function ajaxProcessSaveBlockContent()
    {
        $errors = [];

        $picto = Tools::getValue('picto');
        $id_block = Tools::getValue('id_block');
        $type_link = (int)Tools::getValue('typelink');
        $id_cms = Tools::getValue('id_cms');
        $psr_languages = (array)json_decode(Tools::getValue('lang_values'));

        $blockPsr = new ReassuranceActivity($id_block);
        $blockPsr->handleBlockValues($psr_languages, $type_link, $id_cms);

        $blockPsr->icone = $picto;
        if (empty($picto)) {
            $blockPsr->icone_perso = '';
        }

        $blockPsr->date_add = date("Y-m-d H:i:s");
        $blockPsr->date_update = date("Y-m-d H:i:s");

        if (isset($_FILES) && !empty($_FILES)) {
            $customImage = $_FILES['file'];
            $fileTmpName = $customImage['tmp_name'];
            $filename = $customImage['name'];

            // validateUpload return false if no error (false -> OK)
            $validUpload = ImageManager::validateUpload($customImage);
            if (is_bool($validUpload) && $validUpload === false) {
                move_uploaded_file($fileTmpName, $this->module->folder_file_upload . $filename);
                $blockPsr->icone_perso = $this->module->img_path_perso . '/' . $filename;
                $blockPsr->icone = '';
            } else {
                $errors[] = $validUpload;
                $this->ajaxDie(json_encode($errors));
            }
        }
        $blockPsr->update();

        $this->ajaxDie(json_encode('success'));
    }

    /**
     * Update the position of the reassurance blocks
     *
     * @return bool
     */
    public function ajaxProcessUpdatePosition()
    {
        $blocks = Tools::getValue('blocks');
        if (empty($blocks)) {
            return false;
        }

        foreach ($blocks as $key => $id_block) {
            // Set the position of the Reassurance block
            $position = $key + 1;

            $dataToUpdate = [
                'position' => (int)$position,
            ];

            $whereCondition = 'id_psreassurance = ' . (int)$id_block;

            $updateResult = (bool)Db::getInstance()->update('psreassurance', $dataToUpdate, $whereCondition);

            // If the update can't be done, we return false
            if (!$updateResult) {
                return false;
            }
        }
        
        return true;
    }
}
