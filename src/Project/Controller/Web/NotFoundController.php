<?php

namespace Project\Controller\Web;

use Symfony\Component\HttpFoundation\Response;

class NotFoundController extends ControllerAbstract
{
    /**
     * @param array $params
     * @return Response
     * @throws \Exception
     */
    public function handleRequest(array $params = []): Response
    {
        return $this->render('web/404.twig');
    }
}
