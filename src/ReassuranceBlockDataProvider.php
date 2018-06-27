<?php

namespace BlockReassurance;

class ReassuranceBlockDataProvider
{
    /**
     * @var \DbCore
     */
    protected $databaseManager;

    /**
     * @param \DbCore $databaseManager
     */
    public function __construct(\DbCore $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * @param int $langId
     *
     * @return mixed
     */
    public function getBlocksList($langId)
    {
        $result = $this->databaseManager->executeS(sprintf('
            SELECT r.`id_reassurance`, r.`id_shop`, r.`file_name`, rl.`text`
            FROM `' . _DB_PREFIX_ . 'reassurance` r
            LEFT JOIN `' . _DB_PREFIX_ . 'reassurance_lang` rl ON (r.`id_reassurance` = rl.`id_reassurance`)
            WHERE `id_lang` = %d %s',
            (int)$langId,
            \Shop::addSqlRestrictionOnLang()
        ));

        return $result;
    }
}