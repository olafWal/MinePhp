<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AbstractServer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $servers = $this->getDoctrine()->getRepository(AbstractServer::class)->findAll();
        if (!count($servers)) {
            $this->addFlash('info', "servers.not.configured");
            return $this->redirect($this->generateUrl('app_admin_servers'));
        }
    }
}
