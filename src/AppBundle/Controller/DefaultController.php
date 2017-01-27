<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AbstractServer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use xPaw\MinecraftPing;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $servers = $this->getDoctrine()->getRepository(AbstractServer::class)->findAll();
        if (!$servers) {

        }

    }
}
