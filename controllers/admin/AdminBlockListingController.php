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
    /** @var blockreassurance */
    public $module;

    /**
     * @param string $content
     *
     * @throws PrestaShopException
     */
    protected function ajaxRenderJson($content)
    {
        header('Content-Type: application/json');
        $this->ajaxRender(json_encode($content));
    }

    /**
     * Enable or disable a block
     *
     * @throws PrestaShopException
     */
    public function displayAjaxChangeBlockStatus()
    {
        $now = new DateTime();
        $psreassuranceId = (int) Tools::getValue('idpsr');
        $newStatus = ((int) Tools::getValue('status') == 1) ? 0 : 1;

        $dataToUpdate = [
            'status' => $newStatus,
            'date_upd' => $now->format('Y-m-d H:i:s'),
        ];
        $whereCondition = 'id_psreassurance = ' . $psreassuranceId;

        $updateResult = Db::getInstance()->update('psreassurance', $dataToUpdate, $whereCondition);

        // Response
        $this->ajaxRenderJson($updateResult ? 'success' : 'error');
    }

    /**
     * Delete a block
     *
     * @throws PrestaShopException
     */
    public function displayAjaxDeleteBlock()
    {
        $result = false;
        $idPSR = (int) Tools::getValue('idBlock');
        $blockPSR = Db::getInstance()->getRow('SELECT * FROM ' . _DB_PREFIX_ . 'psreassurance WHERE `id_psreassurance` = ' . (int) $idPSR);
        if (!empty($blockPSR)) {
            $result = true;
            // Remove Custom icon
            if (!empty($blockPSR['custom_icon'])) {
                $filePath = str_replace(__PS_BASE_URI__, _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR, $blockPSR['custom_icon']);
                if (file_exists($filePath)) {
                    $result = unlink($filePath);
                }
            }
            // Remove Block Translations
            if ($result) {
                $result = Db::getInstance()->delete('psreassurance_lang', 'id_psreassurance = ' . (int) $idPSR);
            }
            // Remove Block
            if ($result) {
                $result = Db::getInstance()->delete('psreassurance', 'id_psreassurance = ' . (int) $idPSR);
            }
        }

        // Response
        $this->ajaxRenderJson($result ? 'success' : 'error');
    }

    /**
     * Update how the blocks are displayed in the front-office
     *
     * @throws PrestaShopException
     */
    public function displayAjaxSavePositionByHook()
    {
        $hook = Tools::getValue('hook');
        $value = Tools::getValue('value');
        $result = false;

        if (!empty($hook) && in_array($value, [
                blockreassurance::POSITION_NONE,
                blockreassurance::POSITION_BELOW_HEADER,
                blockreassurance::POSITION_ABOVE_HEADER,
            ])
        ) {
            $result = Configuration::updateValue($hook, $value);
        }

        // Response
        $this->ajaxRenderJson($result ? 'success' : 'error');
    }

    /**
     * Update color settings to be used in front-office display
     *
     * @throws PrestaShopException
     */
    public function displayAjaxSaveColor()
    {
        $color1 = Tools::getValue('color1');
        $color2 = Tools::getValue('color2');
        $result = false;

        if (!empty($color1) && !empty($color2)) {
            $result = Configuration::updateValue('PSR_ICON_COLOR', $color1)
                && Configuration::updateValue('PSR_TEXT_COLOR', $color2);
        }

        // Response
        $this->ajaxRenderJson($result ? 'success' : 'error');
    }

    /**
     * Modify the settings of one block from BO "configure" page
     *
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function displayAjaxSaveBlockContent()
    {
        $errors = [];

        $picto = Tools::getValue('picto');
        $id_block = empty(Tools::getValue('id_block')) ? null : Tools::getValue('id_block');
        $type_link = (int) Tools::getValue('typelink');
        $id_cms = Tools::getValue('id_cms');
        $psr_languages = (array) json_decode(Tools::getValue('lang_values'));

        $blockPsr = new ReassuranceActivity($id_block);
        if (!$id_block) {
            // Last position
            $blockPsr->position = (int) Db::getInstance()->getValue('SELECT MAX(position) AS max FROM ' . _DB_PREFIX_ . 'psreassurance');
            $blockPsr->position = $blockPsr->position ? $blockPsr->position + 1 : 1;
            $blockPsr->status = false;
        }
        $blockPsr->handleBlockValues($psr_languages, $type_link, $id_cms);
        $blockPsr->icon = $picto;
        if (empty($picto)) {
            $blockPsr->custom_icon = '';
        }
        $blockPsr->date_add = date('Y-m-d H:i:s');
        $blockPsr->date_upd = date('Y-m-d H:i:s');

        if (!empty($_FILES)) {
            $customImage = $_FILES['file'];
            $fileTmpName = $customImage['tmp_name'];
            $filename = $customImage['name'];

            // validateUpload return false if no error (false -> OK)
            $authExtensions = ['gif', 'jpg', 'jpeg', 'jpe', 'png', 'svg'];
            $authMimeType = ['image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/svg', 'image/svg+xml'];
            if (version_compare(_PS_VERSION_, '1.7.7.0', '>=')) {
                // PrestaShop 1.7.7.0+
                $validUpload = ImageManager::validateUpload(
                    $customImage,
                    0,
                    $authExtensions,
                    $authMimeType
                );
            } else {
                // PrestaShop < 1.7.7
                $validUpload = false;
                $mimeType = ReassuranceActivity::getMimeType($customImage['tmp_name']);
                if ($mimeType && (
                    !in_array($mimeType, $authMimeType)
                    || !ImageManager::isCorrectImageFileExt($customImage['name'], $authExtensions)
                    || preg_match('/\%00/', $customImage['name'])
                )) {
                    $validUpload = Context::getContext()->getTranslator()->trans('Image format not recognized, allowed formats are: .gif, .jpg, .png', [], 'Admin.Notifications.Error');
                }
                if ($customImage['error']) {
                    $validUpload = Context::getContext()->getTranslator()->trans('Error while uploading image; please change your server\'s settings. (Error code: %s)', [$customImage['error']], 'Admin.Notifications.Error');
                }
            }
            if (is_bool($validUpload) && $validUpload === false) {
                move_uploaded_file($fileTmpName, $this->module->folder_file_upload . $filename);
                $blockPsr->custom_icon = $this->module->img_path_perso . '/' . $filename;
                $blockPsr->icon = '';
            } else {
                $errors[] = $validUpload;
            }
        }
        if (empty($errors)) {
            if ($id_block) {
                $blockPsr->update();
            } else {
                $blockPsr->add();
            }
        }

        // Response
        $this->ajaxRenderJson(empty($errors) ? 'success' : 'error');
    }

    /**
     * Reorder the blocks positions
     *
     * @throws PrestaShopException
     */
    public function displayAjaxUpdatePosition()
    {
        $blocks = Tools::getValue('blocks');
        $result = false;

        if (!empty($blocks) && is_array($blocks)) {
            $updateResult = true;
            foreach ($blocks as $key => $id_block) {
                // Set the position of the Reassurance block
                $position = $key + 1;

                $dataToUpdate = ['position' => (int) $position];
                $whereCondition = 'id_psreassurance = ' . (int) $id_block;
                $updateResult = (bool) Db::getInstance()->update('psreassurance', $dataToUpdate, $whereCondition);

                // If the update can't be done, we return false
                if (!$updateResult) {
                    break;
                }
            }
            $result = $updateResult ? true : false;
        }

        // Response
        $this->ajaxRenderJson($result ? 'success' : 'error');
    }
}
