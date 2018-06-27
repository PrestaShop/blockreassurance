<?php

namespace BlockReassurance;

use PrestaShopBundle\Translation\TranslatorComponent as Translator;

trait TranslationUtils
{
    /**
     * @param string $id
     * @param array $parameters
     * @param string $domain
     * @param string $locale
     *
     * @return string
     */
    protected function trans($id, array $parameters = array(), $domain = null, $locale = null)
    {
        $parameters['legacy'] = 'htmlspecialchars';

        return $this->getTranslator()->trans($id, $parameters, $domain, $locale);
    }

    /**
     * @return Translator
     */
    abstract protected function getTranslator();
}