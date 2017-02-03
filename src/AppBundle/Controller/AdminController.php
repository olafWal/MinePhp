<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AbstractServer;
use AppBundle\Form\UserType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller implements TranslationContainerInterface
{
    /**
     * Returns an array of messages.
     *
     * @return array<Message>
     */
    public static function getTranslationMessages()
    {
        return [
            new Message('flash.user.notfound', 'messages'),
            new Message('flash.server.notfound', 'messages'),
            new Message('flash.user.updated', 'messages'),
            new Message('flash.user.created', 'messages'),
        ];
    }

    /**
     * @Route("/")
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/servers")
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
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
     * @Secure(roles="ROLE_ADMIN")
     */
    public function serverEditAction(Request $request, $id = null)
    {
        $forms = [];
        $views = [];
        $servers = [];
        if ($id) {
            $server = $this->getDoctrine()->getRepository(AbstractServer::class)->find($id);
            if (!$server) {
                $this->addFlash('danger', 'flash.server.notfound');
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

    /**
     * @Route("/users")
     * @Template()
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function usersAction()
    {

        $userManager = $this->container->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        return [
            'users' => $users
        ];
    }

    /**
     * @Route("/user_edit/{id}")
     * @Template()
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function userEditAction(Request $request, $id = null)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $flashMessage = 'flash.user.updated';
        if ($id) {
            $user = $userManager->findUserBy(['id' => $id]);
            if (!$user) {
                $this->addFlash('danger', 'flash.user.notfound');
                return $this->redirect($this->generateUrl('app_admin_servers'));
            }

        } else {
            $user = $userManager->createUser();
            $flashMessage = 'flash.user.created';
        }

        $form = $this->createForm(UserType::class, $user);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $newpass = $form->get('password')->getData();
                if ($newpass) {
                    $user->setPlainPassword($newpass);
                }
                $userManager->updateUser($user, true);
                $this->addFlash('success', $flashMessage);
                return $this->redirect($this->generateUrl('app_admin_users'));
            }
        }

        return [
            'form' => $form->createView()
        ];
    }
}