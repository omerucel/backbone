<?php

namespace Project\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;

class LogoutController extends ControllerAbstract
{
    /**
     * @param array $params
     * @return Response
     */
    protected function handleRequest(array $params = []): Response
    {
        $this->getSession()->remove('admin.user_id');
        return $this->redirectToRoute('admin.login');
    }
}
