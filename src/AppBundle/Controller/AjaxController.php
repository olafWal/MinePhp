<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AbstractServer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use xPaw\MinecraftPing;

class AjaxController extends Controller
{
    /**
     * @Route("/queryServer/{id}", options={"expose" = true})
     */
    public function queryServerAction($id)
    {
        $server = $this->getDoctrine()->getRepository(AbstractServer::class)->find($id);
        $ping = new MinecraftPing($server->getAddress(), $server->getPort(), 1);

        $ping->Connect();
        // TODO: Error Handling
        $pingData = $ping->Query();

        $result = [
            'success' => true,
            'data' => $pingData
        ];


        return new JsonResponse($result);
    }

}
