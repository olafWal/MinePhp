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

        $menu->addChild('Home', ['route' => 'homepage']);
        $menu->addChild('Admin', ['route' => 'app_admin_index']);
        $menu['Admin']->addChild('Servers', ['route' => 'app_admin_servers']);
        return $menu;
    }
    
    public function rightMenu(FactoryInterface $factory, /** @noinspection PhpUnusedParameterInspection */
                             array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Account', ['route' => 'homepage']);
        $menu['Account']->addChild('Logout', ['route' => 'app_admin_servers']);
        return $menu;
    }
    
}
