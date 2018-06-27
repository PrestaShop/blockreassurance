<?php

namespace BlockReassurance\Admin;

use BlockReassurance\TranslationUtils;
use PrestaShopBundle\Translation\TranslatorComponent as Translator;

class FormBuilder
{
    use TranslationUtils;

    /**
     * @var Translator
     */
    protected $translator;

    /** @var array */
    protected $fieldsList;
    /** @var array */
    protected $fieldsForm;

    /** @var \Module */
    protected $module;
    /** @var array string */
    protected $moduleName;
    /** @var array string */
    protected $moduleDisplayName;
    /** @var array string */
    protected $moduleIdentifier;

    /**
     * @param $translator
     * @param $module
     * @param $name
     * @param $displayName
     * @param $identifier
     */
    public function __construct($translator, $module, $name, $displayName, $identifier)
    {
        $this->translator = $translator;
        $this->module = $module;
        $this->moduleName = $name;
        $this->moduleDisplayName = $displayName;
        $this->moduleIdentifier = $identifier;
    }

    /**
     * @return \HelperList
     */
    public function initializeBlockList()
    {
        $this->fieldsList = array(
            'id_reassurance' => array(
                'title' => $this->trans('ID', array(), 'Admin.Global'),
                'width' => 120,
                'type' => 'text',
                'search' => false,
                'orderby' => false
            ),
            'text' => array(
                'title' => $this->trans('Text', array(), 'Admin.Global'),
                'width' => 140,
                'type' => 'text',
                'search' => false,
                'orderby' => false
            ),
        );

        if (\Shop::isFeatureActive()) {
            $this->fieldsList['id_shop'] = array(
                'title' => $this->trans('ID Shop', array(), 'Modules.Blockreassurance.Admin'),
                'align' => 'center',
                'width' => 25,
                'type' => 'int'
            );
        }

        $helper = new \HelperList();

        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_reassurance';
        $helper->actions = array('edit', 'delete');
        $helper->show_toolbar = true;
        $helper->imageType = 'jpg';
        $helper->toolbar_btn['new'] = array(
            'href' => \AdminController::$currentIndex . '&configure=' . $this->moduleName . '&add' . $this->moduleName . '&token=' . \Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->trans('Add new', array(), 'Admin.Actions')
        );

        $helper->title = $this->moduleDisplayName;
        $helper->table = $this->moduleName;
        $helper->token = \Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = \AdminController::$currentIndex . '&configure=' . $this->moduleName;

        return $helper;
    }

    /**
     * @return \HelperForm
     */
    public function initializeAdminForm()
    {
        $default_lang = (int)\Configuration::get('PS_LANG_DEFAULT');

        $this->fieldsForm[0]['form'] = array(
            'legend' => array(
                'title' => $this->trans('New reassurance block', array(), 'Modules.Blockreassurance.Admin'),
            ),
            'input' => array(
                array(
                    'type' => 'file',
                    'label' => $this->trans('Image', array(), 'Admin.Global'),
                    'name' => 'image',
                    'value' => true,
                    'display_image' => true,
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->trans('Text', array(), 'Admin.Global'),
                    'lang' => true,
                    'name' => 'text',
                    'cols' => 40,
                    'rows' => 10
                )
            ),
            'submit' => array(
                'title' => $this->trans('Save', array(), 'Admin.Actions'),
            )
        );

        $helper = new \HelperForm();

        $helper->module = $this->module;
        $helper->name_controller = 'blockreassurance';
        $helper->identifier = $this->moduleIdentifier;
        $helper->token = \Tools::getAdminTokenLite('AdminModules');

        foreach (\Language::getLanguages(false) as $lang) {
            $helper->languages[] = array(
                'id_lang' => $lang['id_lang'],
                'iso_code' => $lang['iso_code'],
                'name' => $lang['name'],
                'is_default' => ($default_lang == $lang['id_lang'] ? 1 : 0)
            );
        }

        $helper->currentIndex = \AdminController::$currentIndex . '&configure=' . $this->moduleName;
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;
        $helper->toolbar_scroll = true;
        $helper->title = $this->moduleDisplayName;
        $helper->submit_action = 'saveblockreassurance';
        $helper->toolbar_btn = array(
            'save' =>
                array(
                    'desc' => $this->trans('Save', array(), 'Admin.Actions'),
                    'href' => \AdminController::$currentIndex . '&configure=' . $this->moduleName . '&save' . $this->moduleName . '&token=' . \Tools::getAdminTokenLite('AdminModules'),
                ),
            'back' =>
                array(
                    'href' => \AdminController::$currentIndex . '&configure=' . $this->moduleName . '&token=' .\Tools::getAdminTokenLite('AdminModules'),
                    'desc' => $this->trans('Back to list', array(), 'Admin.Actions'),
                )
        );

        return $helper;
    }

    /**
     * @return array
     */
    public function getFieldsList()
    {
        return $this->fieldsList;
    }

    /**
     * @return array
     */
    public function getFieldsForm()
    {
        return $this->fieldsForm;
    }

    /**
     * {@inheritdoc}
     */
    protected function getTranslator()
    {
        return $this->translator;
    }
}