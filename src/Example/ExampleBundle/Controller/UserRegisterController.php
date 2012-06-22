<?php

namespace Example\ExampleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Example\ExampleBundle\Entity\User;
use Example\ExampleBundle\Form\Type\UserRegisterType;


/**
 * @Route("/user")
 */
class UserRegisterController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @Template
     */
    public function topAction(Request $request)
    {
        $session = $request->getSession();
        if ($session->has('user/register')) {
            $session->remove('user/register');
        }

        return $this->redirect($this->generateUrl('user_register_input'));
    }

    /**
     * @Route("/register/input", name="user_register_input")
     * @Template
     */
    public function inputAction(Request $request)
    {
        $session = $request->getSession();
        $user = new User();
        $form = $this->createForm(new UserRegisterType(), $user);

        if ($request->getMethod() === 'POST') {
            $data = $request->request->get($form->getName());
            $form->bind($data);
            if ($form->isValid()) {
                $session->set('user/register', $data);
                return $this->redirect($this->generateUrl('user_register_confirm'));
            }
        } elseif ($session->has('user/register')) {
            $data = $session->get('user/register');
            $data['_token'] = $form['_token']->getData();
            $form->bind($data);
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/register/confirm", name="user_register_confirm")
     * @Template
     */
    public function confirmAction(Request $request)
    {
        $user = new User();

        if (!$this->restoreForm(new UserRegisterType(), $user, 'user/register')) {
            return $this->redirect($this->generateUrl('user_register_input'));
        }

        if ($request->getMethod() === 'POST') {
            if ($request->request->has('back')) {
                return $this->redirect($this->generateUrl('user_register_input'));
            } else {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($user);
                $em->flush();
                $request->getSession()->remove('user/register');
                return $this->redirect($this->generateUrl('user_register_complete'));
            }
        }

        return array('user' => $user, 'sexTypes' => User::$sexTypes);
    }

    /**
     * @Route("/register/complete", name="user_register_complete")
     * @Template
     */
    public function completeAction(Request $request)
    {
        return array();
    }

    private function restoreForm($type, User $user, $key)
    {
        $session = $this->getRequest()->getSession();

        if ($session->has($key)) {
            $data = $session->get($key);
            if (isset($data['_token'])) {
                unset($data['_token']);
            }

            $form = $this->createForm($type, $user, array('csrf_protection' => false));
            $form->bind($data);

            return $form->isValid();
        }

        return false;
    }
}
