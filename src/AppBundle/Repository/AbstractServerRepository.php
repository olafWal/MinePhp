<?php

namespace AppBundle\Repository;

use AppBundle\Entity\AbstractServer;
use AppBundle\Entity\BungeeServer;
use AppBundle\Entity\MinecraftServer;
use AppBundle\Model\RconCapable;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AbstractServerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AbstractServerRepository extends \Doctrine\ORM\EntityRepository
{
    public function getRconServers($onlyActive = false)
    {
        $queryBuilder =$this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('s')->from(AbstractServer::class, 's')
            ->where( $queryBuilder->expr()->isInstanceOf('s', MinecraftServer::class))
            ->orWhere($queryBuilder->expr()->isInstanceOf('s', BungeeServer::class))
        ;
        /** @var ArrayCollection $result */
        $result = new ArrayCollection($queryBuilder->getQuery()->getResult());

        if ($onlyActive) {
            $result = $result->filter(function(RconCapable $server) {
                return ($server->getRconPort() && $server->getRconPassword());
            });
        }

        return $result;
    }
}
