<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AbstractServer;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller implements TranslationContainerInterface
{
    /**
     * Returns an array of messages.
     *
     * @return array<Message>
     */
    public static function getTranslationMessages()
    {
        return [
            new Message('flash.servers.not_configured', 'messages'),
        ];
    }

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
            } else {
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
