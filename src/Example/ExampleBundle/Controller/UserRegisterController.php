<?php

namespace Example\ExampleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Example\ExampleBundle\Entity\User;
use Example\ExampleBundle\Form\Type\UserRegisterType;


class UserRegisterController extends Controller
{
    /**
     * @Route("/user/register", name="user_register_input")
     * @Template
     */
    public function inputAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new UserRegisterType(), $user);

        if ($request->getMethod() === 'POST') {
            $data = $request->request->get($form->getName());
            $form->bind($data);
            if ($form->isValid()) {
                $request->getSession()->set('user/register', $data);
                return $this->redirect($this->generateUrl('user_register_confirm'));
            }
        } elseif ($request->getSession()->has('user/register')) {
            $data = $request->getSession()->get('user/register');
            $data['_token'] = $form['_token']->getData();
            $form->bind($data);
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/user/register/confirm", name="user_register_confirm")
     * @Template
     */
    public function confirmAction(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            if ($request->request->has('edit')) {
                $url = $this->generateUrl('user_register_input');
            } else {
                $url = $this->generateUrl('user_register_complete');
            }
            return $this->redirect($url);
        }

        return array();
    }

    /**
     * @Route("/user/register/complete", name="user_register_complete")
     * @Template
     */
    public function completeAction(Request $request)
    {
        return array();
    }
}
