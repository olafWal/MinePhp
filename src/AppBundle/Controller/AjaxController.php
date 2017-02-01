<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AbstractServer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use xPaw\MinecraftPing;
use xPaw\MinecraftPingException;

class AjaxController extends Controller
{
    /**
     * @Route("/queryServer/{id}", options={"expose" = true})
     */
    public function queryServerAction($id)
    {
        /** @var AbstractServer $server */
        $server = $this->getDoctrine()->getRepository(AbstractServer::class)->find($id);
        $success = true;
        $pingData = null;
        try {
            $ping = new MinecraftPing($server->getAddress(), $server->getPort(), 1);
            $ping->Connect();
            // TODO: Error Handling
            $pingData = $ping->Query();
        } catch (MinecraftPingException $e) {
            $success = false;
        }

        $result = [
            'success' => $success,
            'data' => [
                'pingData' => $pingData,
            ]
        ];

        return new JsonResponse($result);
    }

}
