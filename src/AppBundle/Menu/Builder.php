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
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class Builder implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /** @var  AuthorizationCheckerInterface */
    private $securityContext;


    public function mainMenu(
        FactoryInterface $factory,
        /** @noinspection PhpUnusedParameterInspection */
        array $options
    ) {
        $menu = $factory->createItem('root');

        $menu->addChild('menu.home', ['route' => 'homepage']);
        if ($this->securityContext->isGranted('ROLE_ADMIN')) {
            $menu->addChild('menu.admin', ['route' => 'app_admin_index']);
            $menu['menu.admin']->addChild('menu.servers', ['route' => 'app_admin_servers']);
        }
        return $menu;
    }

    public function rightMenu(
        FactoryInterface $factory,
        /** @noinspection PhpUnusedParameterInspection */
        array $options
    ) {
        $menu = $factory->createItem('root');
        if ($this->securityContext->isGranted('ROLE_USER')) {
            $menu->addChild('menu.account');
            $menu['menu.account']->addChild('menu.profile', ['route' => 'fos_user_profile_show']);
            $menu['menu.account']->addChild('menu.changepass', ['route' => 'fos_user_change_password']);
            $menu['menu.account']->addChild('menu.logout', ['route' => 'fos_user_security_logout']);
        }
        else {
            $menu->addChild('menu.login', ['route' => 'fos_user_security_login']);
        }
        return $menu;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        if (!$container) {
            return;
        }
        $this->container = $container;
        $this->securityContext = $this->container->get('security.authorization_checker');
    }
}
