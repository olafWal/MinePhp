<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AbstractServer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use xPaw\MinecraftPing;
use xPaw\MinecraftPingException;
use xPaw\MinecraftQuery;
use xPaw\MinecraftQueryException;

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
        $queryData = null;
        $queryPlayers = null;
        try {
            $ping = new MinecraftPing($server->getAddress(), $server->getPort(), 1);
            $ping->Connect();
            // TODO: Error Handling
            $pingData = $ping->Query();
            if (!$pingData) {
                $success = false;
            }

        } catch (MinecraftPingException $e) {
            $success = false;
        }

        if ($success) {

            try {
                $query = new MinecraftQuery();
                $query->Connect($server->getAddress(), $server->getQueryPort(), 1);
                $queryData = $query->GetInfo();
                $queryPlayers = $query->GetPlayers();


            } catch (MinecraftQueryException $e) {

            }
        }
        $result = [
            'success' => $success,
            'data' => [
                'pingData' => $pingData,
                'queryData' => $queryData,
                'players' => $queryPlayers
            ]
        ];


        return new JsonResponse($result);
    }

}
