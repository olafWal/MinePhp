<?php
/**
 * Created by PhpStorm.
 * User: olaf
 * Date: 28.01.17
 * Time: 00:07
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class MinecraftServer
 * @package AppBundle\Entity
 * @ORM\Entity()
 */
class MinecraftServer extends AbstractServer
{
    /**
     * @ORM\Column(type="integer")
     */
    protected $queryPort;

    /**
     * @return mixed
     */
    public function getQueryPort()
    {
        return $this->queryPort;
    }

    /**
     * @param mixed $queryPort
     * @return MinecraftServer
     */
    public function setQueryPort($queryPort)
    {
        $this->queryPort = $queryPort;
        return $this;
    }

    public function getTypeName()
    {
        return 'minecraft';
    }
}