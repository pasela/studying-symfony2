<?php

namespace Example\ExampleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class UserRegisterController extends Controller
{
    /**
     * @Route("/user/register", name="user_register_input")
     * @Template
     */
    public function inputAction(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            return $this->redirect($this->generateUrl('user_register_confirm'));
        }

        return array();
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
