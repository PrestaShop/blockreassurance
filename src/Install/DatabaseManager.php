<?php

namespace BlockReassurance\Install;

use BlockReassurance\Exception\CouldNotUpdateDatabaseException;
use BlockReassurance\Exception\ExceptionUtils;
use BlockReassurance\TranslationUtils;
use PrestaShopBundle\Translation\TranslatorComponent as Translator;

class DatabaseManager
{
    use ExceptionUtils;
    use TranslationUtils;

    /**
     * @var \DbCore
     */
    protected $databaseManager;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @param \DbCore $databaseManager
     * @param Translator $translator
     */
    public function __construct(\DbCore $databaseManager, Translator $translator)
    {
        $this->databaseManager = $databaseManager;
        $this->translator = $translator;
    }

    /**
     * @return bool
     */
    public function performDatabaseUpdateForInstallation()
    {
        $result = $this->databaseManager->execute('
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'reassurance` (
                `id_reassurance` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_shop` int(10) unsigned NOT NULL ,
                `file_name` VARCHAR(100) NOT NULL,
                PRIMARY KEY (`id_reassurance`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;');

        $this->throwModuleInstallationExceptionIfResultFalse($result);

        $result = $this->databaseManager->execute('
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'reassurance_lang` (
                `id_reassurance` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_lang` int(10) unsigned NOT NULL ,
                `text` VARCHAR(300) NOT NULL,
                PRIMARY KEY (`id_reassurance`, `id_lang`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;');

        $this->throwModuleInstallationExceptionIfResultFalse($result);

        return true;
    }

    /**
     * @return bool
     */
    public function performDatabaseUpdateForUninstallation()
    {
        $result = $this->databaseManager->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'reassurance`');
        $this->throwModuleInstallationExceptionIfResultFalse($result);

        $result = $this->databaseManager->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'reassurance_lang`');
        $this->throwModuleInstallationExceptionIfResultFalse($result);

        return true;
    }

    /**
     * @param int $shopId
     *
     * @return bool
     */
    public function loadFixtures($shopId)
    {
        $tabTexts = array(
            array('text' => $this->trans('Security policy (edit with Customer reassurance module)', array(), 'Modules.Blockreassurance.Shop'), 'file_name' => 'ic_verified_user_black_36dp_1x.png'),
            array('text' => $this->trans('Delivery policy (edit with Customer reassurance module)', array(), 'Modules.Blockreassurance.Shop'), 'file_name' => 'ic_local_shipping_black_36dp_1x.png'),
            array('text' => $this->trans('Return policy (edit with Customer reassurance module)', array(), 'Modules.Blockreassurance.Shop'), 'file_name' => 'ic_swap_horiz_black_36dp_1x.png'),
        );

        foreach ($tabTexts as $tab) {

            $text = $tab['text'];
            $filename = $tab['file_name'];

            $texts = array();
            foreach (\Language::getLanguages(false) as $language) {
                $languageId = $language['id_lang'];
                $texts[$languageId] = $text;
            }

            $this->createNewBlock($texts, $filename, $shopId);
        }

        return true;
    }

    /**
     * @param string[] $texts
     * @param string $filename
     * @param int $shopId
     *
     * @return \ReassuranceBlockEntity
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    protected function createNewBlock($texts, $filename, $shopId)
    {
        $reassurance = new \ReassuranceBlockEntity();

        $reassurance->text = $texts;

        $reassurance->file_name = $filename;
        $reassurance->id_shop = $shopId;

        $saveResult = $reassurance->save();

        if (false === $saveResult) {
            throw new CouldNotUpdateDatabaseException();
        }

        return $reassurance;
    }

    /**
     * {@inheritdoc}
     */
    protected function getTranslator()
    {
        return $this->translator;
    }
}