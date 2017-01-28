<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AbstractServer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use xPaw\MinecraftPing;

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
        $servers = $this->getDoctrine()->getRepository(AbstractServer::class)->findAll();
        return [
            'servers' => $servers
        ];
    }

    /**
     * @Route("/server_edit/{id}")
     * @Template()
     */
    public function serverEditAction(Request $request, $id = null)
    {
        $forms = [];
        $views = [];
        $servers = [];
        if ($id) {
            $server = $this->getDoctrine()->getRepository(AbstractServer::class)->find($id);
            if (!$server) {
                $this->addFlash('error', 'flash.server.notfound');
                return $this->redirect($this->generateUrl('app_admin_servers'));
            }
            $servers[$server->getTypeName()] = $server;
            $formClass = 'AppBundle\\Form\\' . (new \ReflectionClass($server))->getShortName() . 'Type';
            $form = $this->createForm($formClass, $server);
            $forms[$server->getTypeName()] = $form;
        } else {
            foreach (AbstractServer::getDiscriminatorMap() as $name => $class) {
                $servers[$name] = new $class();
                $formClass = 'AppBundle\\Form\\' . (new \ReflectionClass($servers[$name]))->getShortName() . 'Type';
                $form = $this->createForm($formClass, $servers[$name]);
                $forms[$name] = $form;

            }
        }

        if ($request->isMethod(Request::METHOD_POST)) {
            /**
             * @var string $name
             * @var  Form $form
             */
            foreach ($forms as $name => $form) {
                $form->handleRequest($request);
                if (!$form->isSubmitted()) {
                    continue;
                }
                if ($form->isValid()) {
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($servers[$name]);
                    $manager->flush();
                    return $this->redirect($this->generateUrl('app_admin_servers'));
                }
            }
        }
        /**
         * @var string $name
         * @var  Form $form
         */
        foreach ($forms as $name => $form) {
            $views[$name] = $form->createView();
        }

        return ['forms' => $views];
    }
}
