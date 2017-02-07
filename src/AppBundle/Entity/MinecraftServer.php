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
    public function getTypeName()
    {
        return 'minecraft';
    }
}