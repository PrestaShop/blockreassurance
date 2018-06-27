<?php

namespace BlockReassurance\Exception;

trait ExceptionUtils
{
    /**
     * @param mixed $result
     *
     * @throws ModuleInstallationException
     */
    protected function throwModuleInstallationExceptionIfResultFalse($result)
    {
        if (false === $result) {
            throw new ModuleInstallationException();
        }
    }

    /**
     * @param mixed $result
     *
     * @throws ModuleException
     */
    protected function throwModuleExceptionIfResultFalse($result)
    {
        if (false === $result) {
            throw new ModuleException();
        }
    }
}