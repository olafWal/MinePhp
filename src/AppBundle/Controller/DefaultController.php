<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AbstractServer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        $servers = $this->getDoctrine()->getRepository(AbstractServer::class)->findAll();
        if (!count($servers)) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $this->addFlash('info', "flash.servers.not_configured");
                return $this->redirect($this->generateUrl('app_admin_serveredit'));
            }
            else {
                return [
                    'servers' => []
                ];
            }
        }

        foreach (AbstractServer::getDiscriminatorMap() as $name => $class) {
            $servers[$name] = $this->getDoctrine()->getRepository($class)->findAll();
        }
        return ['servers' => $servers];
    }
}
