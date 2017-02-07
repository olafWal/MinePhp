<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AbstractServer;
use AppBundle\Entity\MinecraftServer;
use AppBundle\Repository\AbstractServerRepository;
use gries\Rcon\MessengerFactory;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Spirit55555\Minecraft\MinecraftColors;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RconController extends Controller
{
    /**
     * @Route("/index")
     * @Template()
     */
    public function indexAction()
    {
        /** @var AbstractServerRepository $repository */
        $repository = $this->getDoctrine()->getRepository(AbstractServer::class);
        $servers = $repository->getRconServers(true);
        return ['servers' => $servers];
    }

    /**
     * @Route("/server/{id}")
     * @Template()
     */
    public function serverAction($id)
    {
        $server = $this->getDoctrine()->getRepository(MinecraftServer::class)->find($id);
        if (!$server) {
            $this->addFlash('danger', 'flash.server.notfound');
            return $this->redirect($this->generateUrl('app_rcon_index'));
        }
        if (!$server->getRconPort() || !$server->getRconPassword()) {
            $this->addFlash('danger', 'flash.server.rconNotConfigured');
            return $this->redirect($this->generateUrl('app_rcon_index'));
        }

        return [
            'server' => $server
        ];
    }

    /**
     * @Route("/service/{id}", options={"expose": true})
     * @Method("POST")
     * @Secure(roles="ROLE_ADMIN")
     */

    public function serviceAction(Request $request, $id)
    {
        $server = $this->getDoctrine()->getRepository(MinecraftServer::class)->find($id);
        $success = true;
        $command = $request->request->get('command');
        if (!$server) {
            $response = "";
            $success = false;
        } else {
            $messenger = MessengerFactory::create($server->getAddress(), $server->getRconPort(), $server->getRconPassword());
            $response = $messenger->send($command);
        }
        return new JsonResponse([
            'success' => $success,
            'result' => MinecraftColors::convertToHTML($response)
        ]);
    }
}
