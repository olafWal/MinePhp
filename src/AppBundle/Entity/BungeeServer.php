<?php
/**
 * Created by PhpStorm.
 * User: olaf
 * Date: 28.01.17
 * Time: 00:08
 */

namespace AppBundle\Entity;

use AppBundle\Model\RconEnabledInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class BungeeServer
 * @package AppBundle\Entity
 * @ORM\Entity()
 */
class BungeeServer extends AbstractServer implements RconEnabledInterface
{
    /** @var  integer
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $queryPort;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $rconPort;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $rconPassword;

    /**
     * @return mixed
     */
    public function getRconPassword()
    {
        return $this->rconPassword;
    }

    /**
     * @param mixed $rconPassword
     * @return BungeeServer
     */
    public function setRconPassword($rconPassword)
    {
        $this->rconPassword = $rconPassword;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRconPort()
    {
        return $this->rconPort;
    }

    /**
     * @param mixed $rconPort
     * @return BungeeServer
     */
    public function setRconPort($rconPort)
    {
        $this->rconPort = $rconPort;
        return $this;
    }

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