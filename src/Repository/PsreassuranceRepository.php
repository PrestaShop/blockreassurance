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

namespace PrestaShop\Module\BlockReassurance\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;
use PrestaShop\Module\BlockReassurance\Entity\Psreassurance;

/**
 * @extends ServiceEntityRepository<Psreassurance>
 *
 * @method Psreassurance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Psreassurance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Psreassurance[] findAll()
 * @method Psreassurance[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PsreassuranceRepository extends ServiceEntityRepository
{
    /**
     * @var ManagerRegistry the Doctrine Registry
     */
    private $registry;

    /**
     * @var Connection the Database connection
     */
    private $connection;

    /**
     * @var string the Database prefix
     */
    private $databasePrefix;

    /**
     * @param ManagerRegistry $registry
     * @param Connection $connection
     * @param string $databasePrefix
     */
    public function __construct(
        $registry,
        $connection,
        $databasePrefix
    ) {
        parent::__construct($registry, Psreassurance::class);
        $this->connection = $connection;
        $this->databasePrefix = $databasePrefix;
    }

    public function add(Psreassurance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Psreassurance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return array
     */
    public function getAllBlock()
    {
        $result = [];

        $qb = $this->connection->createQueryBuilder();
        $qb
            ->addSelect('*')
            ->from($this->databasePrefix . 'psreassurance', 'pr')
            ->leftJoin('pr', $this->databasePrefix . 'psreassurance_lang', 'prl', 'pr.id_psreassurance = prl.id_psreassurance')
            ->addOrderBy('pr.position', 'ASC')
        ;

        $dbResult = $qb->execute()->fetchAll();

        foreach ($dbResult as $key => $value) {
            if (!isset($result[$value['id_psreassurance']])) {
                $result[$value['id_psreassurance']] = $value;
                $result[$value['id_psreassurance']]['title'] = [];
                $result[$value['id_psreassurance']]['description'] = [];
                $result[$value['id_psreassurance']]['url'] = [];
            }
            $result[$value['id_psreassurance']]['title'][$value['id_lang']] = $value['title'];
            $result[$value['id_psreassurance']]['description'][$value['id_lang']] = $value['description'];
            $result[$value['id_psreassurance']]['url'][$value['id_lang']] = $value['link'];
        }

        return $result;
    }

    /**
     * @param int $id_lang
     *
     * @return array
     */
    public function getAllBlockByStatus($id_lang = 1)
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->addSelect('*')
            ->from($this->databasePrefix . 'psreassurance', 'pr')
            ->leftJoin('pr', $this->databasePrefix . 'psreassurance_lang', 'prl', 'pr.id_psreassurance = prl.id_psreassurance')
            ->andWhere('pr.status = 1')
            ->andWhere('prl.id_lang = :id_lang')
            ->setParameter('id_lang', $id_lang)
            ->addOrderBy('pr.position', 'ASC')
        ;
        $result = $qb->execute()->fetchAll();

        $xmlMimes = ['image/svg', 'image/svg+xml'];
        foreach ($result as &$item) {
            $item['is_svg'] = !empty($item['custom_icon'])
                && in_array(\ImageManager::getMimeType(\blockreassurance::$static_folder_file_upload . $item['custom_icon']), $xmlMimes);

            if ($item['custom_icon'] != '') {
                $item['custom_icon'] = \blockreassurance::$static_img_path_perso . '/' . $item['custom_icon'];
            } elseif ($item['icon'] != '') {
                $item['icon'] = \blockreassurance::$static_img_path . $item['icon'];
            }
        }

        return $result;
    }
}
