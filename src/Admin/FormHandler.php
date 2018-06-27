<?php

namespace BlockReassurance\Admin;

use BlockReassurance\Exception\ExceptionUtils;
use BlockReassurance\ImageURLProvider;
use BlockReassurance\ReassuranceBlockDataProvider;
use BlockReassurance\TranslationUtils;
use PrestaShopBundle\Translation\TranslatorComponent as Translator;

class FormHandler
{
    use ExceptionUtils;
    use TranslationUtils;

    /**
     * @var ReassuranceBlockDataProvider
     */
    private $dataProvider;

    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var ImageURLProvider
     */
    private $urlProvider;

    /**
     * @var FormBuilder
     */
    private $formBuilder;

    /**
     * @param ReassuranceBlockDataProvider $dataProvider
     * @param Translator $translator
     * @param ImageURLProvider $urlProvider
     * @param FormBuilder $formBuilder
     */
    public function __construct(
        ReassuranceBlockDataProvider $dataProvider,
        Translator $translator,
        ImageURLProvider $urlProvider,
        FormBuilder $formBuilder)
    {
        $this->dataProvider = $dataProvider;
        $this->translator = $translator;
        $this->urlProvider = $urlProvider;
        $this->formBuilder = $formBuilder;
    }

    /**
     * Handle Block Reassurance admin form submission
     *
     * @param int $shopId
     *
     * @return string
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function handle($shopId)
    {
        $usecase = $this->findUsecase();
        $blockId = (int)\Tools::getValue('id_reassurance');

        $isACreate = (false === $blockId);

        switch ($usecase) {

            case 'modify-block':
                if ($isACreate) {
                    $reassuranceBlock = new \ReassuranceBlockEntity();
                } else {
                    $reassuranceBlock = new \ReassuranceBlockEntity($blockId);
                }

                $reassuranceBlock->copyFromPost();
                $reassuranceBlock->id_shop = $shopId;

                $isValid = $reassuranceBlock->validateFields(false);
                $isLangValid = $reassuranceBlock->validateFieldsLang(false);

                if ((false === $isValid) || (false === $isLangValid)) {
                    return $this->getErrorMessage();
                }

                $reassuranceBlock->save();

                $thereIsAValidFileUpload = (isset($_FILES['image']) && isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name']));

                if ($thereIsAValidFileUpload) {
                    $reassuranceBlock = $this->uploadAndResizeImageFile($reassuranceBlock);

                    if (false === $reassuranceBlock) {
                        return $this->getErrorMessage();
                    }

                    $reassuranceBlock->save();
                }

                break;

            case 'get-form':
                $helper = $this->formBuilder->initializeAdminForm();
                $fieldsForm = $this->formBuilder->getFieldsForm();

                foreach (\Language::getLanguages(false) as $lang) {
                    $langId = (int)$lang['id_lang'];

                    if ($isACreate) {
                        $helper->fields_value['text'][$langId] = \Tools::getValue('text_' . $langId, '');
                    } else {
                        $reassuranceBlock = new \ReassuranceBlockEntity($blockId);

                        $helper->fields_value['text'][$langId] = $reassuranceBlock->text[$langId];
                        $imageUrl = $this->urlProvider->getImageURL($reassuranceBlock->file_name);
                        $fieldsForm[0]['form']['input'][0]['image'] = sprintf('<img src="%s" />', $imageUrl);
                    }
                }

                if (false === $isACreate) {
                    $fieldsForm[0]['form']['input'][] = array('type' => 'hidden', 'name' => 'id_reassurance');
                    $helper->fields_value['id_reassurance'] = $blockId;
                }

                return $helper->generateForm($fieldsForm);

                break;

            case 'delete-block':
                $reassuranceBlock = new \ReassuranceBlockEntity($blockId);

                $filepath = dirname(__FILE__) . '/img/' . $reassuranceBlock->file_name;
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
                $reassuranceBlock->delete();

                break;

            default:
                throw new \RuntimeException(sprintf('Unexpected usecase %s', $usecase));
        }
    }

    /**
     * @return \HelperList
     */
    public function initializeBlockList()
    {
        return $this->formBuilder->initializeBlockList();
    }

    /**
     * @return array
     */
    public function getFieldsList()
    {
        return $this->formBuilder->getFieldsList();
    }

    /**
     * @return array
     */
    public function getFieldsForm()
    {
        return $this->formBuilder->getFieldsForm();
    }

    /**
     * @return string
     *
     * @throws \RuntimeException if unable to find which usecase that is
     */
    protected function findUsecase()
    {
        if (\Tools::isSubmit('saveblockreassurance')) {
            return 'modify-block';
        }

        if (\Tools::isSubmit('updateblockreassurance')) {
            return 'get-form';
        }

        if (\Tools::isSubmit('addblockreassurance')) {
            return 'get-form';
        }

        if (\Tools::isSubmit('deleteblockreassurance')) {
            return 'delete-block';
        }

        throw new \RuntimeException('Unexpected usecase');
    }

    /**
     * @return string
     */
    protected function getErrorMessage()
    {
        return '<div class="conf error">' . $this->trans('An error occurred while attempting to save.', array(), 'Admin.Notifications.Error') . '</div>';
    }

    /**
     * @param \ReassuranceBlockEntity $reassuranceBlock
     *
     * @return \ReassuranceBlockEntity
     */
    protected function uploadAndResizeImageFile($reassuranceBlock)
    {
        $error = \ImageManager::validateUpload($_FILES['image']);
        $this->throwModuleExceptionIfResultFalse(empty($error));

        $tmpName = tempnam(_PS_TMP_IMG_DIR_, 'PS');
        $this->throwModuleExceptionIfResultFalse($tmpName);

        $result = move_uploaded_file($_FILES['image']['tmp_name'], $tmpName);
        $this->throwModuleExceptionIfResultFalse($result);

        $imgDirectory = dirname(__FILE__) . '/../../img';
        $imgFilename = sprintf(
            'reassurance-%d-%d.jpg',
            (int)$reassuranceBlock->id,
            (int)$reassuranceBlock->id_shop
        );
        $destinationFilepath = $imgDirectory.'/'.$imgFilename;

        $result = \ImageManager::resize($tmpName, $destinationFilepath);
        $this->throwModuleExceptionIfResultFalse($result);

        unlink($tmpName);
        $reassuranceBlock->file_name = $imgFilename;

        return $reassuranceBlock;
    }

    /**
     * {@inheritdoc}
     */
    protected function getTranslator()
    {
        return $this->translator;
    }
}