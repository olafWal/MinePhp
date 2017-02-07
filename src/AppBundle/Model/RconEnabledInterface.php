<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * PHP version 5
 *
 * @category
 * @package    MinePhp
 * @author     Olaf Walkowiak <o.walkowiak@zooroyal.de>
 * @copyright  Copyright (c) 2017 ZooRoyal GmbH
 * @license    ZooRoyal
 * @version    $Id$
 * @link       http://www.zooroyal.de
 */

namespace AppBundle\Model;


interface RconEnabledInterface
{
    public function getRconPort();
    public function getRconPassword();

}