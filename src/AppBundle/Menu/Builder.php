<?php
/**
 * Created by PhpStorm.
 * User: olaf
 * Date: 30.01.17
 * Time: 20:08
 */

namespace AppBundle\Menu;


use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, /** @noinspection PhpUnusedParameterInspection */
                             array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('menu.home', ['route' => 'homepage']);
        $menu->addChild('menu.admin', ['route' => 'app_admin_index']);
        $menu['menu.admin']->addChild('menu.servers', ['route' => 'app_admin_servers']);
        return $menu;
    }
}