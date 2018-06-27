<?php

namespace BlockReassurance\Install;

use BlockReassurance\ConfigurationUpdater;
use BlockReassurance\Exception\ExceptionUtils;

class ModuleInstaller
{
    use ExceptionUtils;

    /**
     * @var ConfigurationUpdater
     */
    protected $configurationUpdater;

    /**
     * @var DatabaseManager
     */
    protected $databaseManager;

    /**
     * @param ConfigurationUpdater $configurationUpdater
     * @param DatabaseManager $databaseManager
     */
    public function __construct(ConfigurationUpdater $configurationUpdater, DatabaseManager $databaseManager)
    {
        $this->configurationUpdater = $configurationUpdater;
        $this->databaseManager = $databaseManager;
    }

    /**
     * @return bool installation process result, true if successfull
     */
    public function performInstallation($shopId)
    {
        $result = $this->databaseManager->performDatabaseUpdateForInstallation();
        $this->throwModuleInstallationExceptionIfResultFalse($result);

        $result = $this->configurationUpdater->updateConfigurationForInstallation();
        $this->throwModuleInstallationExceptionIfResultFalse($result);

        $result = $this->databaseManager->loadFixtures($shopId);
        $this->throwModuleInstallationExceptionIfResultFalse($result);

        return true;
    }

    /**
     * @return bool uninstallation process result, true if successfull
     */
    public function performUninstallation()
    {
        $result = $this->databaseManager->performDatabaseUpdateForUninstallation();
        $this->throwModuleInstallationExceptionIfResultFalse($result);

        $result = $this->configurationUpdater->updateConfigurationForUninstallation();
        $this->throwModuleInstallationExceptionIfResultFalse($result);

        return true;
    }
}