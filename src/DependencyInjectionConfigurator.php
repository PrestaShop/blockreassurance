<?php

namespace BlockReassurance;

use PrestaShopBundle\Translation\TranslatorComponent as Translator;

class DependencyInjectionConfigurator
{
    /**
     * @param \Module $module
     * @param Translator $translator
     * @param \DbCore $databaseInstance
     * @param $linkGenerator
     * @param array $moduleConfiguration
     *
     * @return array
     */
    public function buildContainer(
        \Module $module,
        Translator $translator,
        \DbCore $databaseInstance,
        $linkGenerator,
        array $moduleConfiguration
    )
    {
        $container = array();

        $container['dataProvider'] = new \BlockReassurance\ReassuranceBlockDataProvider($databaseInstance);

        $container['databaseManager'] = new \BlockReassurance\Install\DatabaseManager(
            $databaseInstance,
            $translator
        );
        $container['configurationUpdater'] = new \BlockReassurance\ConfigurationUpdater();

        $container['moduleInstaller'] = new \BlockReassurance\Install\ModuleInstaller(
            $container['configurationUpdater'],
            $container['databaseManager']
        );

        $container['urlProvider'] = new \BlockReassurance\ImageURLProvider(
            $linkGenerator,
            $moduleConfiguration['name']
        );

        $container['formBuilder'] = new \BlockReassurance\Admin\FormBuilder(
            $translator,
            $module,
            $moduleConfiguration['name'],
            $moduleConfiguration['displayName'],
            $moduleConfiguration['identifier']
        );

        $container['formHandler'] = new \BlockReassurance\Admin\FormHandler(
            $container['dataProvider'],
            $translator,
            $container['urlProvider'],
            $container['formBuilder']
        );

        return $container;
    }
}