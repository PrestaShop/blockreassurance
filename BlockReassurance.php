<?php
/*
* 2007-2016 PrestaShop
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
*  @copyright  2007-2016 PrestaShop SA

*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_CAN_LOAD_FILES_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class BlockReassurance extends Module implements WidgetInterface
{
    use \BlockReassurance\Exception\ExceptionUtils;

    /**
     * @var string
     */
    private $templateFile;

    /**
     * @var \BlockReassurance\Install\ModuleInstaller
     */
    private $moduleInstaller;

    /**
     * @var \BlockReassurance\ReassuranceBlockDataProvider
     */
    private $dataProvider;

    /**
     * @var \BlockReassurance\Admin\FormHandler
     */
    private $formHandler;

    /**
     * @var \BlockReassurance\ImageURLProvider
     */
    private $urlProvider;

    public function __construct()
    {
        $this->name = 'blockreassurance';
        $this->author = 'PrestaShop';
        $this->version = '4.0.0';

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('Customer reassurance', array(), 'Modules.Blockreassurance.Admin');
        $this->description = $this->trans('Adds an information block aimed at offering helpful information to reassure customers that your store is trustworthy.', array(), 'Modules.Blockreassurance.Admin');

        $this->ps_versions_compliancy = array('min' => '1.7.4.0', 'max' => _PS_VERSION_);

        $this->templateFile = 'module:blockreassurance/views/templates/hook/blockreassurance.tpl';

        $this->initializeDependencies();
    }

    /**
     * {@inheritdoc}
     */
    public function install()
    {
        try {
            $result = parent::install();
            $this->throwModuleInstallationExceptionIfResultFalse($result);

            $result = $this->moduleInstaller->performInstallation($this->context->shop->id);
            $this->throwModuleInstallationExceptionIfResultFalse($result);

            $result = $this->registerHook('displayOrderConfirmation2');
            $this->throwModuleInstallationExceptionIfResultFalse($result);

            $result = $this->registerHook('actionUpdateLangAfter');
            $this->throwModuleInstallationExceptionIfResultFalse($result);
        } catch (\BlockReassurance\Exception\ModuleInstallationException $e) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function uninstall()
    {
        try {
            $result = $this->moduleInstaller->performUninstallation();
            $this->throwModuleInstallationExceptionIfResultFalse($result);

            $result = parent::uninstall();
            $this->throwModuleInstallationExceptionIfResultFalse($result);
        } catch (\BlockReassurance\Exception\ModuleInstallationException $e) {
            return false;
        }

        return true;
    }


    /**
     * {@inheritdoc}
     */
    public function renderWidget($hookName = null, array $configuration = [])
    {
        $cacheId = $this->getCacheId('blockreassurance');

        if (false === $this->isCached($this->templateFile, $cacheId)) {
            $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        }

        $widget = $this->fetch($this->templateFile, $cacheId);

        return $widget;
    }

    /**
     * {@inheritdoc}
     */
    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        $elements = $this->dataProvider->getBlocksList($this->context->language->id);

        foreach ($elements as &$element) {
            $element['image'] = $this->getImageURL($element['file_name']);
        }

        return array(
            'elements' => $elements,
        );
    }

    protected function initializeDependencies()
    {
        $translator = Context::getContext()->getTranslator();
        $databaseInstance = Db::getInstance();
        $linkGenerator = $this->context->link;

        $moduleConfiguration = array(
            'name' => $this->name,
            'displayName' => $this->displayName,
            'identifier' => $this->identifier,
        );

        $configurator = new \BlockReassurance\DependencyInjectionConfigurator();
        $container = $configurator->buildContainer(
            $this,
            $translator,
            $databaseInstance,
            $linkGenerator,
            $moduleConfiguration
        );
        
        $this->moduleInstaller = $container['moduleInstaller'];
        $this->urlProvider = $container['urlProvider'];
        $this->dataProvider = $container['dataProvider'];
        $this->formHandler = $container['formHandler'];
    }

    /**
     * {@inheritdoc}
     */
    public function hookActionUpdateLangAfter($params)
    {
        if (!empty($params['lang']) && $params['lang'] instanceOf Language) {
            include_once _PS_MODULE_DIR_ . $this->name . '/lang/ReassuranceLang.php';

            Language::updateMultilangFromClass(_DB_PREFIX_ . 'reassurance_lang', 'ReassuranceLang', $params['lang']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        $isPOST = (Tools::isSubmit('saveblockreassurance')
            || Tools::isSubmit('updateblockreassurance')
            || Tools::isSubmit('addblockreassurance')
            || Tools::isSubmit('deleteblockreassurance')
        );
        $isDelete = (Tools::isSubmit('deleteblockreassurance'));

        // handle POST
        if ($isPOST) {
            $html = $this->formHandler->handle($this->context->shop->id);

            $this->_clearCache('*');

            if ($isDelete) {
                $url = $this->computeAfterDeleteUrl();
                Tools::redirectAdmin($url);
            }

            return $html;
        }

        // handle GET
        $blockList = $this->dataProvider->getBlocksList((int)Configuration::get('PS_LANG_DEFAULT'));

        $helper = $this->formHandler->initializeBlockList();
        $helper->listTotal = count($blockList);

        return $helper->generateList($blockList, $this->formHandler->getFieldsList());
    }

    /**
     * {@inheritdoc}
     */
    protected function _clearCache($template, $cacheId = null, $compileId = null)
    {
        parent::_clearCache($this->templateFile);
    }

    /**
     * @param string $image
     *
     * @return string
     */
    protected function getImageURL($image)
    {
        return $this->urlProvider->getImageURL($image);
    }

    /**
     * @return string
     */
    protected function computeAfterDeleteUrl()
    {
        $parameters = array(
            'configure' => $this->name,
            'token' => \Tools::getAdminTokenLite('AdminModules')
        );

        return \AdminController::$currentIndex . http_build_query($parameters);
    }
}
