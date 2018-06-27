<?php

namespace BlockReassurance;

class ConfigurationUpdater
{
    const DEFAULT_BLOCKS_NUMBER = 5;

    /**
     * @return bool
     */
    public function updateConfigurationForInstallation()
    {
        $result = \Configuration::updateValue('BLOCKREASSURANCE_NBBLOCKS', self::DEFAULT_BLOCKS_NUMBER);

        return $result;
    }

    /**
     * @return bool
     */
    public function updateConfigurationForUninstallation()
    {
        $result = \Configuration::deleteByName('BLOCKREASSURANCE_NBBLOCKS');

        return $result;
    }
}