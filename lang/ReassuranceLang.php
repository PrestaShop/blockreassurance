<?php
/**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

class ReassuranceLang extends DataLangCore
{
    // Don't replace domain in init() with $this->domain for translation parsing
    protected $domain = 'Modules.Blockreassurance.Shop      ';

    protected $keys = array('id_reassurance');

    protected $fieldsToUpdate = array('text');

    protected function init()
    {
        $this->fieldNames = array(
            'text' => array(
                md5('Security policy (edit with module Customer reassurance)') =>
                    $this->translator->trans('Security policy (edit with Customer reassurance module)', array(), 'Modules.Blockreassurance.Shop', $this->locale),

                md5('Delivery policy (edit with module Customer reassurance)') =>
                    $this->translator->trans('Delivery policy (edit with Customer reassurance module)', array(), 'Modules.Blockreassurance.Shop', $this->locale),

                md5('Return policy (edit with module Customer reassurance)') =>
                    $this->translator->trans('Return policy (edit with Customer reassurance module)', array(), 'Modules.Blockreassurance.Shop', $this->locale),

            ),
        );
    }
}
