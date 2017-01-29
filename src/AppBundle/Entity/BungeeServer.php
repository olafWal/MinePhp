<?php
/**
 * Created by PhpStorm.
 * User: olaf
 * Date: 28.01.17
 * Time: 00:08
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class BungeeServer
 * @package AppBundle\Entity
 * @ORM\Entity()
 */
class BungeeServer extends AbstractServer
{
    /** @var  integer
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $queryPort;

    /**
     * @return int
     */
    public function getQueryPort()
    {
        return $this->queryPort;
    }

    /**
     * @param int $queryPort
     * @return BungeeServer
     */
    public function setQueryPort($queryPort)
    {
        $this->queryPort = $queryPort;
        return $this;
    }

    public function getTypeName()
    {
        return 'bungee';
    }
}