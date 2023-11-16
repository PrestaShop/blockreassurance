<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */
declare(strict_types=1);

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

    public function getId(): int
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

    public function addPsreassuranceLang(PsreassuranceLang $psreassuranceLang): self
    {
        $psreassuranceLang->setPsreassurance($this);
        $this->psreassuranceLangs->add($psreassuranceLang);

        return $this;
    }

    public function getPsreassuranceTitle(): string
    {
        if ($this->psreassuranceLangs->count() <= 0) {
            return '';
        }

        $psreassuranceLang = $this->psreassuranceLangs->first();

        return $psreassuranceLang->getTitle();
    }

    public function getPsreassuranceDescription(): string
    {
        if ($this->psreassuranceLangs->count() <= 0) {
            return '';
        }

        $psreassuranceLang = $this->psreassuranceLangs->first();

        return $psreassuranceLang->getDescription();
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getCustomIcon(): string
    {
        return $this->customIcon;
    }

    public function setCustomIcon(string $customIcon): self
    {
        $this->customIcon = $customIcon;

        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getLinkType(): int
    {
        return $this->linkType;
    }

    public function setLinkType(int $linkType): self
    {
        $this->linkType = $linkType;

        return $this;
    }

    public function getCmsId(): int
    {
        return $this->cmsId;
    }

    public function setCmsId(int $cmsId): self
    {
        $this->cmsId = $cmsId;

        return $this;
    }

    /**
     * Set dateAdd.
     */
    public function setDateAdd(\DateTime $dateAdd): self
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    /**
     * Get dateAdd.
     */
    public function getDateAdd(): \DateTime
    {
        return $this->dateAdd;
    }

    /**
     * Set dateUpd.
     */
    public function setDateUpd(\DateTime $dateUpd): self
    {
        $this->dateUpd = $dateUpd;

        return $this;
    }

    /**
     * Get dateUpd.
     */
    public function getDateUpd(): \DateTime
    {
        return $this->dateUpd;
    }
}
