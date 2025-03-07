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
use PrestaShop\Module\BlockReassurance\Entity\Psreassurance;

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
                $filePath = _PS_ROOT_DIR_ . $this->module->img_path_perso . '/' . basename($blockPSR['custom_icon']);
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

        if ($this->isAuthorizedHookConfigurationKey($hook) && $this->isAuthorizedPositionValue($value)) {
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
        $id_block = empty(Tools::getValue('id_block')) ? 0 : (int) Tools::getValue('id_block');
        $type_link = (int) Tools::getValue('typelink');
        $id_cms = (int) Tools::getValue('id_cms');
        $psr_languages = (array) json_decode(Tools::getValue('lang_values'));
        $authExtensions = ['gif', 'jpg', 'jpeg', 'jpe', 'png', 'svg', 'avif'];
        $authMimeType = ['image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/svg', 'image/svg+xml', 'image/avif'];

        if (!empty($picto) && !in_array(pathinfo($picto, PATHINFO_EXTENSION), $authExtensions)) {
            $errors[] = Context::getContext()->getTranslator()->trans('Image format not recognized, allowed formats are: .gif, .jpg, .png, .svg, .avif', [], 'Admin.Notifications.Error');

            return $this->ajaxRenderJson(empty($errors) ? 'success' : 'error');
        }

        $reassuranceRepository = $this->context->controller->getContainer()->get('block_reassurance_repository');
        $reassuranceFormHandler = $this->context->controller->getContainer()->get('block_reassurance_form_data_handler');

        if ($id_block) {
            $blockPsr = $reassuranceRepository->find($id_block);
        } else {
            $blockPsr = new Psreassurance();
            // Last position
            $blockPsr->setPosition((int) Db::getInstance()->getValue('SELECT MAX(position) AS max FROM ' . _DB_PREFIX_ . 'psreassurance'));
            $blockPsr->setPosition($blockPsr->getPosition() ? $blockPsr->getPosition() + 1 : 1);
            $blockPsr->setStatus(0);
        }

        if (strpos($picto, $this->module->img_path_perso) !== false) {
            if ($picto != '') {
                $picto = basename($picto);
            }
            $blockPsr->setIcon('');
            $blockPsr->setCustomIcon($picto);
        } else {
            if ($picto != '') {
                $parts = explode('/', $picto);
                $parts = array_slice($parts , -3);
                $picto = implode('/', $parts);
            }
            $blockPsr->setIcon($picto);
            $blockPsr->setCustomIcon('');
        }

        if (!empty($_FILES)) {
            $customImage = $_FILES['file'];
            $fileTmpName = $customImage['tmp_name'];
            $filename = $customImage['name'];

            $validUpload = ImageManager::validateUpload(
                $customImage,
                0,
                $authExtensions,
                $authMimeType
            );

            if (is_bool($validUpload) && $validUpload === false) {
                // Remove Custom icon
                if ($blockPsr->getCustomIcon() != '') {
                    $filePath = blockreassurance::$static_folder_file_upload . '/' . basename($blockPsr->getCustomIcon());
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
                move_uploaded_file($fileTmpName, $this->module->folder_file_upload . $filename);
                $blockPsr->setCustomIcon($filename);
                $blockPsr->setIcon('');
            } else {
                $errors[] = $validUpload;
            }
        }

        if (empty($errors)) {
            $blockPsr->setDateUpd(new \DateTime('now', new \DateTimeZone('UTC')));
            if ($id_block) {
                $reassuranceFormHandler->updateLangs($blockPsr, $psr_languages, $type_link, $id_cms);
            } else {
                $blockPsr->setDateAdd(new \DateTime('now', new \DateTimeZone('UTC')));
                $reassuranceFormHandler->createLangs($blockPsr, $psr_languages, $type_link, $id_cms);
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

    /**
     * @param string $hook
     *
     * @return bool
     */
    private function isAuthorizedHookConfigurationKey($hook)
    {
        return
            !empty($hook)
            && in_array($hook, [
                blockreassurance::PSR_HOOK_HEADER,
                blockreassurance::PSR_HOOK_FOOTER,
                blockreassurance::PSR_HOOK_PRODUCT,
                blockreassurance::PSR_HOOK_CHECKOUT,
            ], true)
        ;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    private function isAuthorizedPositionValue($value)
    {
        return in_array((int) $value, [
            blockreassurance::POSITION_NONE,
            blockreassurance::POSITION_BELOW_HEADER,
            blockreassurance::POSITION_ABOVE_HEADER,
        ], true);
    }
}
