<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $ping = new MinecraftPing('localhost', 25566, 1);

        $ping->Connect();

        $result = $ping->Query();


        return ['ping' => $result];

    }

    /**
     * @Route("/servers")
     * @Template()
     */
    public function serversAction()
    {
        return [];
    }

}
