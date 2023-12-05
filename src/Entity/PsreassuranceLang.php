<?php
/**
 * 2007-2020 PrestaShop SA and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0).
 * It is also available through the world-wide-web at this URL: https://opensource.org/licenses/AFL-3.0
 */
declare(strict_types=1);

namespace PrestaShop\Module\BlockReassurance\Entity;

use Doctrine\ORM\Mapping as ORM;
use PrestaShopBundle\Entity\Lang;

/**
 * @ORM\Table()
 *
 * @ORM\Entity()
 */
class PsreassuranceLang
{
    /**
     * @var Psreassurance
     *
     * @ORM\Id
     *
     * @ORM\ManyToOne(targetEntity="PrestaShop\Module\BlockReassurance\Entity\Psreassurance", inversedBy="psreassuranceLangs")
     *
     * @ORM\JoinColumn(name="id_psreassurance", referencedColumnName="id_psreassurance", nullable=false)
     */
    private $psreassurance;

    /**
     * @var Lang
     *
     * @ORM\Id
     *
     * @ORM\ManyToOne(targetEntity="PrestaShopBundle\Entity\Lang")
     *
     * @ORM\JoinColumn(name="id_lang", referencedColumnName="id_lang", nullable=false, onDelete="CASCADE")
     */
    private $lang;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", nullable=true)
     */
    private $link;

    /**
     * @return Psreassurance
     */
    public function getPsreassurance()
    {
        return $this->psreassurance;
    }

    /**
     * @param Psreassurance $psreassurance
     */
    public function setPsreassurance(Psreassurance $psreassurance): self
    {
        $this->psreassurance = $psreassurance;

        return $this;
    }

    /**
     * @return Lang
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param Lang $lang
     */
    public function setLang(Lang $lang): self
    {
        $this->lang = $lang;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }
}
