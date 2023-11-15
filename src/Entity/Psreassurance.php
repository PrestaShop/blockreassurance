<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

namespace PrestaShop\Module\BlockReassurance\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 *
 * @ORM\Entity(repositoryClass="PrestaShop\Module\BlockReassurance\Repository\PsreassuranceRepository")
 */
class Psreassurance
{
    const TYPE_LINK_NONE = 0;
    const TYPE_LINK_CMS_PAGE = 1;
    const TYPE_LINK_URL = 2;

    /**
     * @var int
     *
     * @ORM\Id
     *
     * @ORM\Column(name="id_psreassurance", type="integer")
     *
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=255)
     */
    private $icon;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_icon", type="string", length=255)
     */
    private $customIcon;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var int
     *
     * @ORM\Column(name="type_link", type="integer")
     */
    private $linkType;

    /**
     * @var int
     *
     * @ORM\Column(name="id_cms", type="integer")
     */
    private $cmsId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_add", type="datetime", nullable=false)
     */
    private $dateAdd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_upd", type="datetime", nullable=true)
     */
    private $dateUpd;

    /**
     * @ORM\OneToMany(targetEntity="PrestaShop\Module\BlockReassurance\Entity\PsreassuranceLang", cascade={"persist", "remove"}, mappedBy="psreassurance")
     */
    private $psreassuranceLangs;

    public function __construct()
    {
        $this->psreassuranceLangs = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getPsreassuranceLangs()
    {
        return $this->psreassuranceLangs;
    }

    /**
     * @param int $langId
     *
     * @return QuoteLang|null
     */
    public function getPsreassuranceLangByLangId(int $langId)
    {
        foreach ($this->psreassuranceLangs as $psreassuranceLang) {
            if ($langId === $psreassuranceLang->getLang()->getId()) {
                return $psreassuranceLang;
            }
        }

        return null;
    }

    /**
     * @param PsreassuranceLang $psreassuranceLang
     *
     * @return $this
     */
    public function addPsreassuranceLang(PsreassuranceLang $psreassuranceLang)
    {
        $psreassuranceLang->setPsreassurance($this);
        $this->psreassuranceLangs->add($psreassuranceLang);

        return $this;
    }

    /**
     * @return string
     */
    public function getPsreassuranceTitle()
    {
        if ($this->psreassuranceLangs->count() <= 0) {
            return '';
        }

        $psreassuranceLang = $this->psreassuranceLangs->first();

        return $psreassuranceLang->getTitle();
    }

    /**
     * @return string
     */
    public function getPsreassuranceDescription()
    {
        if ($this->psreassuranceLangs->count() <= 0) {
            return '';
        }

        $psreassuranceLang = $this->psreassuranceLangs->first();

        return $psreassuranceLang->getDescription();
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $title
     *
     * @return Psreassurance
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomIcon()
    {
        return $this->customIcon;
    }

    /**
     * @param string $customIcon
     *
     * @return Psreassurance
     */
    public function setCustomIcon($customIcon)
    {
        $this->customIcon = $customIcon;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return Psreassurance
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return Psreassurance
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return int
     */
    public function getLinkType()
    {
        return $this->linkType;
    }

    /**
     * @param int $linkType
     *
     * @return Psreassurance
     */
    public function setLinkType($linkType)
    {
        $this->linkType = $linkType;

        return $this;
    }

    /**
     * @return int
     */
    public function getCmsId()
    {
        return $this->cmsId;
    }

    /**
     * @param int $cmsId
     *
     * @return Psreassurance
     */
    public function setCmsId($cmsId)
    {
        $this->cmsId = $cmsId;

        return $this;
    }

    /**
     * Set dateAdd.
     *
     * @param \DateTime $dateAdd
     *
     * @return $this
     */
    public function setDateAdd(\DateTime $dateAdd)
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    /**
     * Get dateAdd.
     *
     * @return \DateTime
     */
    public function getDateAdd()
    {
        return $this->dateAdd;
    }

    /**
     * Set dateUpd.
     *
     * @param \DateTime $dateUpd
     *
     * @return $this
     */
    public function setDateUpd(\DateTime $dateUpd)
    {
        $this->dateUpd = $dateUpd;

        return $this;
    }

    /**
     * Get dateUpd.
     *
     * @return DateTime
     */
    public function getDateUpd()
    {
        return $this->dateUpd;
    }
}
